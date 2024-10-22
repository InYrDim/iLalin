<?php
session_start();

function showMidtransUsingSnap() {
        
    require_once './midtrans/Midtrans.php';
    // Set your Merchant Server Key
    \Midtrans\Config::$serverKey = 'SB-Mid-server-WPJiVVPVinrDDsBGyWNBZGxf';
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;


    $json = file_get_contents("php://input");
    $params = array(
        'transaction_details' => array(
            'order_id' => rand(),
            'gross_amount' => 10000,
        ),
        'customer_details' => json_decode($json, associative: true)['customer_details'],
    );
    $snapToken;

    if(isset($_SESSION['snapToken'])) {
        echo $_SESSION['snapToken'];

        exit();
    }
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    $_SESSION['snapToken'] = $snapToken;
    echo $snapToken;
}

function cancelOrder($order_id) {
    // Initialize cURL session
    $curl = curl_init();

    // Set the URL for the POST request
    curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/{$order_id}/cancel");

    // Set the request method to POST
    curl_setopt($curl, CURLOPT_POST, true);

    // Set the headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic U0ItTWlkLXNlcnZlci1XUEppVlZQVmluckREc0JHeVdOQlpHeGY6' // Replace 'ayudga' with your actual authorization token
    ]);

    // Return the response instead of outputting it
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $response = curl_exec(handle: $curl);

    // Check for errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($curl);
    } else {
        // Output the response as a JSON object
        header('Content-Type: application/json');
        echo $response;
    }

    // Close cURL session
    curl_close($curl);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    showMidtransUsingSnap();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(isset($_GET['order_id']) && $_GET['order_id']) {
        // Replace with your actual order ID
        // Assuming you're sending the order ID from JavaScript
        
        $order_id = $_GET['order_id']; // Use $_GET since you're passing it as a query parameter
        cancelOrder($order_id);

    }
}