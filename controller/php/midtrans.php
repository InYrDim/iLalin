<?php

class Midtrans {

    public function getPaymentStatusByOrderId($order_id) {
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
        $response = curl_exec(handle: $curl);

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

    public function refundPaymentByOrderId($order_id) {
        $curl = curl_init();

        $paymentStatus = $this->getPaymentStatusByOrderId($order_id);

        $paymentData = json_decode($paymentStatus, true);
        $transactionId = $paymentData['transaction_id'];
        // $grossAmount = $paymentData['gross_amount'];

        // header(header: 'Content-Type: application/json');
        // echo $paymentStatus;
        // exit();

        
        // Set the URL for the POST request
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/{$transactionId}/refund");
        
        // Set the URL for the POST body
        // $body = [
        //     "amount" => $grossAmount,
        // ];
        // $data_string = json_encode($body);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        // Set the request method to POST
        curl_setopt($curl, CURLOPT_POST, true);

        // Set the headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic U0ItTWlkLXNlcnZlci1XUEppVlZQVmluckREc0JHeVdOQlpHeGY6' 
        ]);

        // Return the response instead of outputting it
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session
        $response = curl_exec(handle: $curl);

        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($curl);
        } else {
            return $response;
        }

        // Close cURL session
        curl_close($curl);
    }
}