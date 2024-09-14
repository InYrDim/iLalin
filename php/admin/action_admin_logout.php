<?php
session_start();

// Destroy all sessions
session_unset();
session_destroy();

// Redirect to login page or homepage
header("Location: action_admin_login.php"); // Adjust the path as needed
exit();
?>