<?php
// Update.php

// Connect to database
$conn = mysqli_connect("localhost", "username", "password", "database");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get data from form
$id = $_POST['id'];
$nama = $_POST['nama'];
$no_hp = $_POST['no_hp'];
$status = $_POST['status'];

// Update data in database
$query = "UPDATE users SET nama = '$nama', nomor_telepon = '$no_hp', aktif = '$status' WHERE id_pengguna = '$id'";
mysqli_query($conn, $query);

// Close connection
mysqli_close($conn);

// Redirect to index page
header("Location: index.php");
exit;
?>