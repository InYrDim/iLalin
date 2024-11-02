<?php

include_once 'ilalin.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $postData = file_get_contents("php://input");
    $postJson = json_decode($postData, true);
    
    if(isset($postJson['action'])) {
        
        $driver = new Driver();
        
        switch($postJson['action']) {
            
            case 'updateDriverPosition':
                $driverId = isset($postJson['driver_id'])? trim($postJson['driver_id']) : null;
                $latitude = isset($postJson['latitude'])? trim($postJson['latitude']) : null;
                $longitude = isset($postJson['longitude'])? trim($postJson['longitude']) : null;
                
                if($driverId && $latitude && $longitude) {
                    $isUpdated = $driver->updateDriverPosition($driverId, $latitude, $longitude);
                    
                    if($isUpdated) {
                        echo json_encode([
                            'status' =>'success',
                            'message' => "driver with id $driverId has been updated successfully"
                        ]);
                    } else {
                        echo json_encode([
                            'status' =>'failed',
                            'message' => "driver with id $driverId not found"
                        ]);
                    }
                    exit();
                } else {
                    echo json_encode([
                        'status' =>'failed',
                       'message' => "invalid request"
                       ]);
                    exit();
                }
            case 'updateDriverStatus':
                $driverId = isset($postJson['driver_id']) ? trim($postJson['driver_id']) : null;
                $status = isset($postJson['status']) ? trim($postJson['status']) : null;
                
                if($driverId && $status) {
                    $isUpdated = $driver->updateDriverStatus($driverId, $status);
                    
                    if($isUpdated) {
                        echo json_encode([
                            'status' =>'success',
                            'message' => "driver with id $driverId has been updated successfully"
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
                        'message' => "no driver_id or status provided"
                    ]);
                }
                break;
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