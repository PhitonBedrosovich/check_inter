<?php

class Cache {
    private $cacheDir;
    
    public function __construct() {
        $this->cacheDir = __DIR__ . '/../cache/';
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }
    
    public function saveHiddenRecords($table, $records) {
        $filename = $this->cacheDir . $table . '_hidden.json';
        file_put_contents($filename, json_encode($records, JSON_UNESCAPED_UNICODE));
    }
    
    public function getHiddenRecords($table) {
        $filename = $this->cacheDir . $table . '_hidden.json';
        if (file_exists($filename)) {
            return json_decode(file_get_contents($filename), true);
        }
        return [];
    }
    
    public function clearCache() {
        $files = glob($this->cacheDir . '*_hidden.json');
        foreach ($files as $file) {
            unlink($file);
        }
    }
} 