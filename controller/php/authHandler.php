<?php

include_once 'ilalin.php';

function getRandomProfileImage($imageFolder) {
    // Define the folder where images are stored
    $images = glob( $imageFolder.'*.*', GLOB_BRACE);
    
    if (!$images) {
        return null; // Or handle as needed if no images are found
    }

    $randomImage = $images[array_rand($images)];
    return getBase64($randomImage);
}

function getBase64($image_path) {
    $image_data = file_get_contents($image_path);
    return base64_encode($image_data);
}

$data;


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

        if (!isset($postJson['email']) || !isset($postJson['password'])) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Email or password not provided'
            ])
            ;
        }
        
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
                $loginResult = $auth->login($email, $password, 'admins');

                header('Content-Type: application/json');                
                echo json_encode([
                    'status' => $loginResult === "Logged in successfully!" ? 'success' : 'failed',
                    'message' => $loginResult
                ]);
                exit(); 
            
            case 'passengerLogin':
            
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
            case 'driverLogin':
                
                $email = trim($postJson['email']);
                $password = trim($postJson['password']);
                $loginResult = $auth->login($email, $password, 'drivers');

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
                if (!isset($postJson['email']) || !isset($postJson['password']) || !isset($postJson['username'])) {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'Email, password, or name not provided'
                    ]);
                    exit();
                }
                
                if (!isset($postJson['role']) || ($postJson['role'] !== 'penumpang' && $postJson['role'] !== 'pengemudi')) {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'Invalid role, please choose penumpang or pengemudi'
                    ]);
                    exit();
                }

                $name = trim($postJson['username']);
                $email = trim($postJson['email']);
                $password = trim($postJson['password']);
                $nomor_telepon = trim($postJson['phone']);

  
                
                $data = [
                    'username' => $name,
                    'email' => $email, 
                    'password' => $password, 
                    'phone'=> $nomor_telepon
                ];
                
                $registerResult;
                if ($postJson['role'] === 'penumpang') {
                    $imageString = getRandomProfileImage("../../assets/images/__DEFAULTs/user_profile_images/");
                    $data['image'] = $imageString;
                    $registerResult = $auth->register('users', $data);
                } else if ($postJson['role'] === 'pengemudi') {    
                    $imageString = getRandomProfileImage("../../assets/images/__DEFAULTs/driver_profile_images/");
                    $data['image'] = $imageString;
                    $registerResult = $auth->register('drivers', $data);
                }
                header('Content-Type: application/json');                
                echo json_encode([
                    'status' => $registerResult === "Created in successfully!" ? 'success' : 'failed',
                    'message' => $registerResult
                ]);
                exit();

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