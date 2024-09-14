<?php
// Include the middleware script

// Database configuration
$host = 'localhost'; // Change if your database is on a different host
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password
$database = 'ilalin'; // The name of the database you want to connect to

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If you reach here, the connection was successful
echo "Connected successfully";

// Close the connection (optional, you can also keep it open for further queries)
?>

