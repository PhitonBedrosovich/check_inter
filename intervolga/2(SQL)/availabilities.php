<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Cache.php';

$categories = [];
$products = [];
$stocks = [];
$availabilities = [];
$error = null;

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $cache = new Cache();

    $stmt = $conn->query("select * from categories where is_hidden = false order by id");
    $categories = $stmt->fetchAll();
    
    $stmt = $conn->query("select * from products where is_hidden = false order by id");
    $products = $stmt->fetchAll();
    
    $stmt = $conn->query("select * from stocks where is_hidden = false order by id");
    $stocks = $stmt->fetchAll();
    
    $stmt = $conn->query("select * from availabilities where is_hidden = false order by id");
    $availabilities = $stmt->fetchAll();
    
} catch(Exception $e) {
    $error = $e->getMessage();
    error_log("Database Error: " . $e->getMessage());
}

require_once __DIR__ . '/templates/availabilities.php';