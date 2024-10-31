<?php

//handle check payment request if it already had payment with pending status
session_start();
include_once '../ilalin.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //read php input parameters using php://infput
    $data = json_decode(file_get_contents('php://input'), true);
    
    $status = $data['status'];

    
    $trip = new TripController();

    $lookForStatus = $status;
    $tripData = $trip->getTripsFilterByStatus($lookForStatus, $_SESSION['email']);

    if(isset($tripData['status']) && $tripData['status'] === $lookForStatus) {
        header('Content-Type: application/json');
        echo json_encode($tripData);
        exit();
    }
 

    
}