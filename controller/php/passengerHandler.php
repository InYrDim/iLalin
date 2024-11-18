<?php

include_once ('ilalin.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $postData = file_get_contents("php://input");
    $postJson = json_decode($postData, true);
    
    if(isset($postJson['action'])) {
        
        $passenger = new Passenger();

        include_once('./utils/alertUtils.php');
        $utils = new AlertUtils();
        
        switch($postJson['action']) {
            case 'deletePassengerById':
                $passengerEmail = isset($postJson['passenger_email'])? trim($postJson['passenger_email']) : null;
                if($passengerEmail) {



                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Passenger deleted successfully'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'failed',
                        'message' => 'No passenger_email provided'
                    ]);
                }
                break;
            case 'updatePassenger':
            default:
                echo '<script>alert("action trip handller default")</script>';
        }
        exit();
    }
}