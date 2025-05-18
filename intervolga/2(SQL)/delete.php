<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Cache.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Method not allowed');
}

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $cache = new Cache();

    $conn->beginTransaction();

    $stmt = $conn->query("select * from categories where is_hidden = false");
    $hiddenCategories = $stmt->fetchAll();
    
    $stmt = $conn->query("select * from products where is_hidden = false");
    $hiddenProducts = $stmt->fetchAll();
    
    $stmt = $conn->query("select * from stocks where is_hidden = false");
    $hiddenStocks = $stmt->fetchAll();

    $queries = [
        "update categories c left join products p on c.id = p.category_id set c.is_hidden = true where p.id is null",
        "update products p left join availabilities a on p.id = a.product_id set p.is_hidden = true where a.id is null",
        "update stocks s left join availabilities a on s.id = a.stock_id set s.is_hidden = true where a.id is null"
    ];

    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }

    $cache->saveHiddenRecords('categories', $hiddenCategories);
    $cache->saveHiddenRecords('products', $hiddenProducts);
    $cache->saveHiddenRecords('stocks', $hiddenStocks);

    $conn->commit();

    header("Location: availabilities.php?success=1");
    exit();

} catch(Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Database Error in delete.php: " . $e->getMessage());
    
    header("Location: availabilities.php?error=" . urlencode("Ошибка при скрытии данных: " . $e->getMessage()));
    exit();
}
