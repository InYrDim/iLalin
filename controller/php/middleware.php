<?php
session_start();

// Include configuration file
include 'config.php'; // Adjust the path as necessary

// Middleware function to check if the user is logged in
function checkAdmin() {
    // Get the current script name
    $currentFile = basename($_SERVER['PHP_SELF']);

     // If the user directly opens the middleware page, redirect to a different page
    if ($currentFile === 'middleware.php') {
        header("Location: " . LANDING_PAGE_URL);
        exit();
    }
    
    // Bypass the middleware check if the request is a POST request to action_admin_login.php
    if ($currentFile === 'action_admin_login.php' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        return;
    }

    

    // Check if the user is logged in
    if (isset($_SESSION['admin_id'])) {
        // If the user is logged in and is trying to access the login page, redirect to the dashboard
        if ($currentFile === 'admin-login.php') {
            header("Location: " . ADMIN_DASHBOARD_URL);
            exit();
        }
    } else{
        // If the user is not logged in and is trying to access a protected page, redirect to the login page
        if ($currentFile !== 'admin-login.php') {
            header("Location: " . ADMIN_LOGIN_BASE_URL);
            exit();
        }
    } 
}

// Call the middleware function
checkAdmin();