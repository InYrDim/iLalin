<?php

class Database {
    private $host = 'localhost'; // Database host
    private $user = 'root';      // Database username
    private $pass = '';          // Database password
    private $db = 'ilalin';      // Database name
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Create a new MySQLi connection
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind the parameters if any
        if (!empty($params)) {
            // Dynamically bind parameters based on the types of input data
            $types = str_repeat('s', count($params)); // Assume all parameters are strings, modify as needed
            $stmt->bind_param($types, ...array_values($params));
        }

        // Execute the statement
        $stmt->execute();

        // Return the result
        return $stmt;
    }

    public function fetch($table, $columns = '*', $where = '', $params = []) {
        // Build the SQL query dynamically
        $sql = "SELECT $columns FROM $table";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
    
        $stmt = $this->query($sql, $params);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function fetchAll($table, $columns = '*', $where = '', $params = []) {
        // Build the SQL query dynamically
        $sql = "SELECT $columns FROM $table";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }

        $stmt = $this->query($sql, $params);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($table, $data) {
        // Prepare the column names and placeholders
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
    
        // Build the SQL query
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
        // Execute the query
        $stmt = $this->query($sql, $data);
    
        // Check if the insert was successful
        if ($stmt) {
            return $this->conn->insert_id; // Return the last inserted ID if success
        } else {
            return false; // Return false if failed
        }
    }
    

    public function update($table, $data, $where, $whereParams = []) {
    $set = "";
    foreach ($data as $key => $value) {
        $set .= "$key = ?, ";
    }
    $set = rtrim($set, ', ');

    // Build the SQL query
    $sql = "UPDATE $table SET $set WHERE $where";

    // Merge data values with where parameters for binding
    $params = array_values($data);
    $params = array_merge($params, $whereParams);

    // Execute the query with the combined parameters
    return $this->query($sql, $params);
}


    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql);
    }

    public function close() {
        // Close the connection
        $this->conn->close();
    }
}

// DOCS

// $data = [
//     'column1' => 'value1',
//     'column2' => 'value2',
// ];
// $db->insert('your_table', $data);