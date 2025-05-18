<?php

class Logger {
    private $logFile;
    
    public function __construct() {
        $this->logFile = __DIR__ . '/../logs/database.log';
    }
    
    public function getLogs() {
        if (!file_exists($this->logFile)) {
            return [];
        }
        
        $logs = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_reverse($logs);
    }
    
    public function addLog($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
} 