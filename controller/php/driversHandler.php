<?php

include_once 'ilalin.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $postData = file_get_contents("php://input");
    $postJson = json_decode($postData, true);
    
    if(isset($postJson['action'])) {
        
        $driver = new Driver();
        
        switch($postJson['action']) {
            case 'getDriversGroupedByCreationDate':
                $driverData = $driver->getDriversGroupedByCreationDate();
                echo json_encode($driverData);
                break;
            case 'deleteDriverById':
                $driverId = isset($postJson['driver_id'])? trim($postJson['driver_id']) : null;
                if($driverId) {
                    $isDeleted = $driver->deleteDriverById($driverId);
                    
                    if($isDeleted) {
                        echo json_encode([
                            'status' =>'success',
                            'message' => "driver with id $driverId has been deleted successfully"
                        ]);
                    } else {
                        echo json_encode([
                            'status' =>'failed',
                            'message' => "driver with id $driverId not found"
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' =>'failed',
                        'message' => "no driver_id provided"
                    ]);
                }
                break;
            default:
                echo '<script>alert("action trip handller default")</script>';
        }
        exit();
    }
}