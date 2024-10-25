<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'ilalin';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($params) {
            $stmt->bind_param(...$params);
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