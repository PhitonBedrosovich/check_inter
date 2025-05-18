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

    $queries = [
        "update categories set is_hidden = false",
        
        "update products set is_hidden = false",
        
        "update stocks set is_hidden = false",
        
        "update availabilities set is_hidden = false"
    ];

    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }

    $cache->clearCache();

    $conn->commit();

    header("Location: availabilities.php?restore=1");
    exit();

} catch(Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Database Error in restore.php: " . $e->getMessage());
    
    header("Location: availabilities.php?error=" . urlencode("Ошибка при восстановлении данных: " . $e->getMessage()));
    exit();
}