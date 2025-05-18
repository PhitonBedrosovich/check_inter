<?php
require_once __DIR__ . '/Logger.php';

class Database {
    private static $instance = null;
    private $conn = null;
    private $logger = null;

    private function __construct() {
        define('SECURE_ACCESS', true);
        $this->logger = new Logger();
        $this->logger->addLog("Configuration loaded");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        if ($this->conn === null) {
            $envFile = __DIR__ . '/../config/key.env';
            
            if (!file_exists($envFile)) {
                $this->logger->addLog("Configuration file not found: " . $envFile);
                throw new Exception("Файл конфигурации config/key.env не найден. Пожалуйста, создайте его в директории config.");
            }
            
            $env = [];
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if ($lines === false) {
                $this->logger->addLog("Failed to read configuration file");
                throw new Exception("Не удалось прочитать файл конфигурации config/key.env");
            }
            
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $env[trim($key)] = trim($value);
                }
            }
            
            $requiredParams = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
            foreach ($requiredParams as $param) {
                if (!isset($env[$param]) || empty($env[$param])) {
                    $this->logger->addLog("Missing required parameter: " . $param);
                    throw new Exception("В файле config/key.env отсутствует обязательный параметр: " . $param);
                }
            }
            
            $config = [
                'host' => $env['DB_HOST'],
                'dbname' => $env['DB_NAME'],
                'username' => $env['DB_USER'],
                'password' => $env['DB_PASSWORD'],
                'charset' => 'utf8mb4'
            ];
            
            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
                $this->logger->addLog("New connection established");
            } catch(PDOException $e) {
                $this->logger->addLog("Connection failed: " . $e->getMessage());
                throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    public function __destruct() {
        if ($this->conn !== null) {
            $this->conn = null;
            $this->logger->addLog("All connections closed");
        }
    }

    private function __clone() {}
    
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
} 