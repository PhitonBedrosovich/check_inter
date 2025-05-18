<?php
$envFile = __DIR__ . '/key.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    if ($env === false) {
        die("Ошибка чтения файла key.env");
    }
    foreach ($env as $key => $value) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
    }
} else {
    die("Файл key.env не найден");
}
try {
    $db = new PDO(
        "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8",
        getenv('DB_USER'),
        getenv('DB_PASS')
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("create table IF not exists `comments` (
        `id` int(11) not null AUTO_INCREMENT,
        `text` text collate utf8_unicode_ci not null,
        `created_at` timestamp not null default current_timestamp,
        primary key (`id`)
    ) ENGINE=InnoDB default CHARSET=utf8 collate=utf8_unicode_ci");
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
    $db->prepare('insert into comments (text) values (?)')->execute([$_POST['comment']]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
$comments = $db->query('select * from comments order by created_at asc')->fetchAll(PDO::FETCH_ASSOC);
require 'comments.html';