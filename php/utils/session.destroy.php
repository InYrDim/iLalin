<?php

$redirect_to = $_GET['home'];


session_start();

// Destroy all sessions
session_unset();
session_destroy();

if(isset($_GET['home'])) {
    
    header("Location: $redirect_to"); // Adjust the path as needed
    exit();
}