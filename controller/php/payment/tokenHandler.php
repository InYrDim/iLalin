<?php

session_start();

$postJson = json_decode(file_get_contents('php://input'), true);

if (isset($postJson['action']) && $postJson['action'] == 'delete') {
    unset($_SESSION['token']);
    echo json_encode([
        'status' => 'success',
        'message' => 'Token deleted successfully',
        'action' => 'delete' 
    ]);
    exit;
}

if(!isset($_SESSION['token'])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = "Accept: application/json";
    $headers[] = 'Authorization: Basic U0ItTWlkLXNlcnZlci1XUEppVlZQVmluckREc0JHeVdOQlpHeGY6';
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postJson));

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    $_SESSION['token'] = $response;
}

echo $_SESSION['token'];