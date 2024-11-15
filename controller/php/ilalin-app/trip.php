<?php

include_once(__DIR__.'/ilalin_app.php');
class TripController extends IlalinApp {
    
    public function addTrip($data) {
        
        try {
            if (!is_array($data) || 
            !isset($data['name'], $data['time'], $data['distance'], 
                    $data['startPoint'], $data['finishingPoint'], $data['status'], $data['email'])) {
                throw new Exception("Invalid trip data.");
            }
            $this->db->beginTransaction(); // Start transaction
    
            // Calculate total payment and profits
            $totalPayment = $this->utils->calculateTotalPayment($data['distance']);
            $profits = $this->utils->calculateProfits($totalPayment);

            // Generate a unique identifier for the trip
            $uniqueId = uniqid('trip_', true); // Prefix with 'trip_'
            $order_id = uniqid('pay_', true);
            
            // Prepare SQL query
            $sql = "INSERT INTO trips 
            (trip_id, order_id, name, email, time, distance, start_point, finishing_point, 
            total_payment, driver_profit, company_profit, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // JSON encode start and finishing points          
            $startPoint = json_encode($data['startPoint']);
            $finishingPoint = json_encode($data['finishingPoint']);

            // Define parameters (with types string)
            $params = [
                'sssssissddds', // Type string: string, string, int, string, string, double, double, double, string
                $uniqueId,
                $order_id,
                $data['name'], 
                $data['email'], 
                $data['time'], 
                $data['distance'], 
                $startPoint, 
                $finishingPoint, 
                $totalPayment, 
                $profits['driverProfit'], 
                $profits['companyProfit'], 
                $data['status']
            ];
            
            // Execute query with parameters
            $this->db->query($sql, $params);
    
            $this->db->commit(); // Commit transaction

            return $uniqueId;
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback on error
            echo "Error adding trip: " . $e->getMessage();
        }
    }
    public function getTrips($tripId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Trips WHERE trip_id = ?',
                ['s', $tripId]
            );
            $trip = $stmt->get_result()->fetch_assoc();
            
    
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return null;
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function getAllTripsById($tripId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Trips WHERE trip_id = ?',
                ['s', $tripId]
            );
            $trip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return "User not found";
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function getAllTrips() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Trips'
            );
            $trip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return "Trip not found";
            }
        }catch (Exception $e) {
            echo "Failed to get Trip profile: " . $e->getMessage();
        }
    }
    public function getTripsFilterByStatus( $status, $email) {
        try {
            // Prepare and execute query to fetch trips with status = 'ongoing'
            $stmt = $this->db->query(
                'SELECT * FROM Trips WHERE status = ? AND email = ?', ['ss', $status, $email]
            );
        
            $trip = $stmt->get_result()->fetch_assoc();
        
            // Check if any trip was found
            if ($trip) {
                return $trip; // Return trip data if found
            } else {
                return "No ". $status . " trips status found.";
            }
        } catch (Exception $e) {
            // Handle any exceptions
            echo "Failed to get trip status ". $status . " data: " . $e->getMessage();
        }
        // Fetch all as associative array
    }
    public function getTripsByEmail($email) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Trips WHERE email = ?',
                ['s', $email]
            );
            $trip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
          
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return "User not found";
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function updateTripStatus($tripId, $status) {
        try {
            $this->db->query(
                'UPDATE Trips SET status = ? WHERE trip_id = ?',
                ['ss', $status, $tripId]
            );
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        } 
    }
    public function updateTripDriver($tripId, $driver_id) {
        try {
            $this->db->query(
                'UPDATE Trips SET driver_id = ? WHERE trip_id = ?',
                ['ss', $driver_id , $tripId]
            );
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        } 
    }
    
    public function getTripsByDriverID($driverId)  {
        try {
            $stmt = $this->db->query(
                "SELECT `users`.*, `trips`.`status`, `trips`.*, `trips`.`driver_id`
                FROM `users` 
                    LEFT JOIN `trips` ON `trips`.`email` = `users`.`email`
                WHERE `trips`.`status` = 'ongoing' AND `trips`.`driver_id` = ?",
                ['s', $driverId]
            );
            $trip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return "User not found";
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }

    //function to handle finishTrip
    public function updateTripsByDriver($driverId) {
        try {
            $update = $this->db->query(
                'UPDATE Trips SET status = ? WHERE driver_id = ?',
                ['ss', 'completed', $driverId]
            )
            ;
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }

    public function updateTripsByDriverWithIsAccepted($driverId, $isAccepted) {
        try {
            $update = $this->db->query(
                'UPDATE Trips SET is_accepted = ? WHERE driver_id =?',
                ['ss', $isAccepted, $driverId]
            );
            return $update;
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function getTripsByDriverIdWithIsAccepted($driverId, $isAccepted = 'accepted')  {
        try {
            $stmt = $this->db->query(
                "SELECT `users`.*, `trips`.*, `trips`.`status`, `trips`.`driver_id`, `trips`.`is_accepted` FROM `users` LEFT JOIN `trips` ON `trips`.`email` = `users`.`email` WHERE `trips`.`status` = 'ongoing' AND `trips`.`driver_id` = ? AND `trips`.`is_accepted` = ? ",
                ['ss', $driverId, $isAccepted]
            );
            $trip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            if ($trip) {
                return $trip; // Return user data if found
            } else {
                return "User not found";
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
}