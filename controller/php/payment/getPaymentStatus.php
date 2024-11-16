<?php

function paymentStatus($order_id) {
    // Initialize cURL session
    $curl = curl_init();

    // Set the URL for the POST request
    curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/{$order_id}/status");

    // Set the request method to POST
    curl_setopt($curl, CURLOPT_HTTPGET, true);

    // Set the headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic U0ItTWlkLXNlcnZlci1XUEppVlZQVmluckREc0JHeVdOQlpHeGY6' 
    ]);

    // Return the response instead of outputting it
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $response = curl_exec($curl);

    // Check for errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($curl);
    } else {
        // Output the response as a JSON object
        // header('Content-Type: application/json');

        return $response;
    }

    // Close cURL session
    curl_close($curl);
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the order ID from the query string

    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        paymentStatus($order_id);
    }
}