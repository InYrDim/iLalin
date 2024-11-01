<?php

include_once 'ilalin.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $postData = file_get_contents("php://input");
    $postJson = json_decode($postData, true);
    
    if(isset($postJson['action'])) {
        
        if (!isset($postJson['driver_id'])) {
            if(!isset($postJson['trip_id'])) {
                echo json_encode([
                    'status' =>'failed',
                    'message' => "no trip_id provided" 
                ]);
                exit();
            }
            
            $trip = new TripController();
            
            $tripId = trim($postJson['trip_id']);
    
            $isHadTrip = $trip->getTrips($tripId);
    
            if(!$isHadTrip) {
                echo json_encode([
                    'status' =>'failed',
                    'message' => "trip_id $tripId not found"
                ]);
                exit();
            }
    
        }
       
        switch($postJson['action']) {
            case 'getTripsByDriverID': 
                $driverId = trim($postJson['driver_id']);
                $trips = $trip->getTripsByDriverID($driverId);
                echo json_encode($trips);
                break;
            case 'updateTripStatus':
                $tripStatus = trim($postJson['status']);
                // Call the appropriate function based on the 'action' parameter in the POST data
                $tripId = trim($postJson['trip_id']);
                
                $trip->updateTripStatus($tripId, $tripStatus);
                
                if(isset($postJson['clearToken']) && $postJson['clearToken'] == 'yes') {
                    session_start();
                    $_SESSION['snapToken'] = null;
                }
                echo json_encode([
                    'status' =>'success',
                    'message' =>"Trip status updated to $tripStatus successfully"
                ]);
                break;
            default:
                echo '<script>alert("action trip handller default")</script>';
        }
        exit();
    }
}