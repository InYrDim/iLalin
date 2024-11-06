<?php

include_once 'ilalin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (strpos($contentType, 'application/json') !== false) {
        // Handle JSON data
        $postData = file_get_contents("php://input");
        $postJson = json_decode($postData, true);
    } else {
        // Handle form data
        $postJson = $_POST;
    }
    if (isset($postJson['action']) && isset($postJson['type'])) {
        // Dynamically set user type based on `type` from request
        //  type is handle table name like 'admins' or 'users
        $userType = $postJson['type'] === 'user' ? 'user' : 'admin';
        $auth = new Auth($userType); // Initialize Auth with specified user type

        switch ($postJson['action']) {
            case 'adminLogin':
                // Login Action
                if (!isset($postJson['email']) || !isset($postJson['password'])) {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'Email or password not provided'
                    ]);
                    exit();
                }

                $email = trim($postJson['email']);
                $password = trim($postJson['password']);
                $loginResult = $auth->login($email, $password);

                if ($loginResult === "Logged in successfully!") {
                    $referer = $_SERVER['HTTP_REFERER'];
                    echo "<script>alert('$loginResult'); setTimeout(()=>{window.location.href = '$referer'},1000)</script>";
                    exit();
                } else {
                    $referer = $_SERVER['HTTP_REFERER'];
                    echo "<script>alert('$loginResult'); window.location.href = '$referer'</script>";
                    exit();
                }
            
            case 'passengerLogin':
                // Login Action
                if (!isset($postJson['email']) || !isset($postJson['password'])) {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'Email or password not provided'
                    ]);
                    exit();
                } 

                $email = trim($postJson['email']);
                $password = trim($postJson['password']);
                $loginResult = $auth->login($email, $password, 'users');

                // add response as json
                header('Content-Type: application/json');                
                echo json_encode([
                    'status' => $loginResult === "Logged in successfully!" ? 'success' : 'failed',
                    'message' => $loginResult
                ]);
                exit();            
            case 'logout':
                // Logout Action
                $logoutResult = $auth->logout();
                echo json_encode([
                    'status' => 'success',
                    'message' => $logoutResult
                ]);
                break;

            case 'register':
                // Register Action
                if (!isset($postJson['email']) || !isset($postJson['password']) || !isset($postJson['name'])) {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'Email, password, or name not provided'
                    ]);
                    exit();
                }

                $name = trim($postJson['name']);
                $email = trim($postJson['email']);
                $password = trim($postJson['password']);
                $registerResult = $auth->register($name, $email, $password);

                if ($registerResult === "Registration successful!") {
                    echo json_encode([
                        'status' => 'success',
                        'message' => $registerResult
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => $registerResult
                    ]);
                }
                break;

            default:
                echo json_encode([
                    'status' => 'failed',
                    'message' => 'Invalid action'
                ]);
                break;
        }
    } else {
        echo json_encode([
            'status' => 'failed',
            'message' => 'No action specified'
        ]);
    }
}