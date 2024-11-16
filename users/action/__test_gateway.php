<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['email'])) { 

    header("location: /auth/login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "invalid request";
    exit;
}

$email = $_SESSION['email'];

include_once(__DIR__ . '/../../controller/php/ilalin.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postJson = null;
    $contentType = $_SERVER["CONTENT_TYPE"] ?? "";
    
    if (strpos($contentType, 'application/json') !== false) {
        // Handle JSON data
        $postData = file_get_contents("php://input");
        $postJson = json_decode($postData, true);
    } else if (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
        // Handle form data
        $postJson = $_POST;
    } else {
        http_response_code(400);
        echo "Unsupported content type: $contentType";
        exit;
    }

    $tripsController = new TripController();
    
    
        switch (true) {
            case isset($postJson['trip_id']) && isset($postJson['status']):
                $tripsController->updateTripStatus($postJson['trip_id'], $postJson['status']);
                $tripsController->updateTripDriver($postJson['trip_id'], $postJson['driver_id']);
                echo json_encode(['status' => 'success', 'message' => 'Status pembayaran berhasil diubah']);
                exit();
            case isset($postJson['trip_id']):
                $trips = $tripsController->getTrips($_POST['trip_id']);
            
                if ($trips['email'] === $_SESSION['email']) {

                    // Process payment information
                    $il_util = new PaymentsUtils();
                    
                    //payment information

                    $total_payment = $il_util->formatCurrency($trips['total_payment']);
                    
                    $starting_point = json_decode($trips['start_point'], true);
                    $finishing_point = json_decode($trips['finishing_point'], true);
                    
                    $driver = new Driver();
                    $avaiable_driver = $driver->getAvaiableDriverAndCar();

                    if (!$avaiable_driver) {
                        http_response_code(404);

                        $alert_message = "Driver not available";                        
                        include_once('alert_page.php');
                        
                        $location_url = $_SERVER['HTTP_REFERER'];
                        $redirect_location_timeout = 4000;
                        include_once('redirect.php');
                        
                        exit;
                    }

                    switch (true) {
                        case $avaiable_driver:
                            $vehicle = new Vehicle();
                            $driver_vehicle = $vehicle->getVehicleType($avaiable_driver['driver_id']);
                            break;
                        default:
                            http_response_code(404);
                            echo "Driver not avaiable";
                            exit;
                    }

                    // update payment databse, add founded driver when payed
                    // update trip status to 'paid'
                    // add trip_id to user's trip history
                    // add driver's information to user's profile

                    //Run HTML Below Only When trip_id is SET and email is equal to current session of user.

                    
                    $profileController = new ProfileController(); 
                    $userProfile=$profileController->getUserProfile($email);
                    $profile = $userProfile;
                    
                    include_once(__DIR__ . '/gateway_page.php');
                    
                    exit;
                }
                echo "Trip not found";
                exit;
                
            case !isset($postJson['trip_id']):
                header("Content-Type: application/json"); // Ensure the response is JSON formatted

                try {
                    // Read the raw input data from the request body
                    $rawData = file_get_contents("php://input");
                                    
                    // Decode JSON into an associative array
                    $data = json_decode($rawData, true);
                    
                    // Validate JSON decoding
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new Exception("Invalid JSON format.");
                    }
                
                    // Append email from session if available
                    if (isset($_SESSION['email'])) {
                        $data['email'] = $_SESSION['email']; // Add the email to the data array
                    } else {
                        throw new Exception("Email not found in session.");
                    }
                
                    // Ensure all required fields are present
                    $requiredFields = ['name', 'time', 'distance', 'startPoint', 'finishingPoint', 'status'];
                    foreach ($requiredFields as $field) {
                        if (!isset($data[$field])) {
                            throw new Exception("Missing required field: $field");
                        }
                    }
                    
                    // If validation passes, add the trip
                    $tripId = $tripsController->addTrip($data);
                    
                    // Return a success response
                    if($tripId) {
                        http_response_code(200); // 200 OK
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Trip added successfully',
                            'id' => $tripId
                        ]);
                    }
                
                } catch (Exception $e) {
                    // Handle errors and return a meaningful response
                    http_response_code(400); // 400 Bad Request
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to add trip: ' . $e->getMessage()
                    ]);
                } finally {
                    exit(); // Ensure script execution is terminated after response
                }
                break;
            default:
                echo json_encode(['status' => 'failed', 'message' => 'No status provided']);
                break;
        }
}

// var_dump($_SESSION);
?>