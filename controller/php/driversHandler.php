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
            default:
                echo '<script>alert("action trip handller default")</script>';
        }
        exit();
    }
}