<?php

include_once 'ilalin.php';

function get_content($URL){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getRandomProfileImage($imageUrls) {
    // If no images are provided, return null
    if (empty($imageUrls)) {
        return null;
    }

    $randomImageUrl = $imageUrls[array_rand($imageUrls)];
    $imageData = get_content($randomImageUrl);
    return getBase64($imageData);
}

function getBase64($imageData) {
    return base64_encode($imageData);
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
                    $imageString = getRandomProfileImage([
                        'https://i.ibb.co.com/PFgzzKV/2c0af4f20efa8e06768f664cf2c3058c8bac642d0a541406f182650c52154646.png',
                        'https://i.ibb.co.com/ScPtjRN/4af312136aae6cddae82660486e4dfb2416c7cbfb87b3890d3b12d36dc30094b.png',
                        'https://i.ibb.co.com/n8DFsrK/24c4361e0a576856788e7464d14a18d1342da8f96b9d318919334a2326af9902.png',
                        'https://i.ibb.co.com/WyFXNw3/7ac059cdc21d3bced71937f937528bb05c78dc35792bffecd22bcba94e259bb1.png',
                        'https://i.ibb.co.com/vw2298L/8435ede38c522f48866551483c366941ab27f28c4d79c95159c0d80080952a8f.png',
                        'https://i.ibb.co.com/3Y9HJSj/14090cdeaa58893274f85333566b9c97eb28b4473e266a76c58b54b7e3e919c8.png',
                        'https://i.ibb.co.com/2jtrtyy/a7910c16042859c948d3072afbc2023f28a6844e20ff2fece921d51131c1a694.png',
                        'https://i.ibb.co.com/6R3n40f/b8088ab14114c7dba105e221b0cfa01d557bd444e1aa5a6c91dd0c674e2b106c.png',
                        'https://i.ibb.co.com/0nyHCsJ/cf3ea4a9b6d3d5bfca4101edaad7fc20e45f03fbae0526d61d34e3b87c18421b.png'
                    ]);
                    $data['image'] = $imageString;
                    $registerResult = $auth->register('users', $data);
                } else if ($postJson['role'] === 'pengemudi') {    
                    $imageString = getRandomProfileImage([
                        'https://i.ibb.co.com/M6HHpBM/85a9051b88129ce1ed9243e28695553020ae0cee3183f91ce5e4e34edfc07080.png',
                        'https://i.ibb.co.com/Ttm5Zzw/16d0984d7d271b894d7835ce04520453188dddd932d4fd8dbbdf779b8d4e4d43.png',
                        'https://i.ibb.co.com/cLTfTCT/6331f7ff695d09263ec8d7ff4b12facaa9f9223363db17faf5367deb90057723.png',
                        'https://i.ibb.co.com/9TQyJCH/79755ae8106147e139801b82b986f7cf6d4cc19081642baf20507d8fa8ab4273.png',
                        'https://i.ibb.co.com/7XZr5jx/435252cd96ac560e0ad8fb859e1ce0404b0e6886fd91fc29876b56314c25c3a1.png',
                        'https://i.ibb.co.com/JQLG4GX/c197e0ca597550ab6627d997f278e9f5a2f3e92ae33f36ff00e913a06ce095fe.png',
                        'https://i.ibb.co.com/pzgNXcv/d08a945298566e2f93391ba8d2098693b044a999d0c0d213826aed9b77e9bdbf.png',
                        'https://i.ibb.co.com/tzd60nC/e62b8a5e8bba33a243a54798d760c5a193fe597cc1550bd17fa97a24d4d59475.png'
                    ]);
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