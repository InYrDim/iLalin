<?php

include('midtrans.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $postData = file_get_contents("php://input");
    $postJson = json_decode($postData, true);
    
    if(isset($postJson['action'])) {
        if(!isset($postJson['order_id'])) {
            echo json_encode([
                'status' =>'failed',
                'message' => "no order_id provided" 
            ]);
            exit();
        }
        
        if(!isset($postJson['action'])) {
            echo json_encode([
                'status' =>'failed',
                'message' => "no action provided" 
            ]);
            exit();
        }
        
        $midtrans = new IlalinMidtrans();
        
        $order_id = trim($postJson['order_id']);
        
        switch($postJson['action']) {
            case 'getPaymentStatus':
                $paymentStatus = $midtrans->getPaymentStatusByOrderId($order_id);
                header('Content-Type: application/json');
                echo $paymentStatus;
                break;

            case 'refundPayment':
                $refundStatus = $midtrans->refundPaymentByOrderId($order_id);
                header('Content-Type: application/json');
                echo $refundStatus;
                break;
                
            case 'cancelPayment':
                $cancelStatus = $midtrans->cancelPaymentByOrderId($order_id);
                header('Content-Type: application/json');
                echo $cancelStatus;
                break;
                
            default:
                echo json_encode([
                    'status' =>'failed',
                    'message' => "invalid action"     
                ]);
        }
        exit();


    }
}