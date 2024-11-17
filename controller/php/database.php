<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'vegm1133_iLalin03';
    private $username = 'vegm1133_iLalin03';
    private $password = 'iLalin03';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            http_response_code(500);
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            http_response_code(500);
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }
    
        if ($params) {
            // Extract types from params and bind them.
            $types = array_shift($params);  // First param is type string.
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
    
        return $stmt;
    }
    
    // Start a new transaction
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    // Commit the current transaction
    public function commit() {
        $this->conn->commit();
    }

    // Roll back the current transaction
    public function rollback() {
        $this->conn->rollback();
    }
    public function __destruct() {
        $this->conn->close();
    }
}