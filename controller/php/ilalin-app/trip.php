<?php

include_once(__DIR__.'/ilalin_app.php');
/**
 * Handles operations related to trips.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class TripController extends IlalinApp {
    
    /**
     * Adds a new trip to the database with the provided trip data.
     *
     * @param array $data Associative array containing trip details:
     *                    - 'name' (string): Name of the trip.
     *                    - 'time' (int): Duration of the trip in minutes.
     *                    - 'distance' (int): Distance of the trip in kilometers.
     *                    - 'startPoint' (array): Starting point details in JSON format.
     *                    - 'finishingPoint' (array): Finishing point details in JSON format.
     *                    - 'status' (string): Status of the trip.
     *                    - 'email' (string): Email of the user who created the trip.
     *
     * @return string Unique identifier of the newly added trip.
     *
     * @throws Exception If the provided data is invalid or if any database error occurs.
     */
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
    
    /**
     * Get a trip by trip ID
     * 
     * @param string $tripId Unique identifier of trip
     * @return array|null  Array of trip data if found, null otherwise
     */
    public function getTrips($tripId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM trips WHERE trip_id = ?',
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
    
    /**
     * Get all trips by trip_id
     *
     * @param string $tripId Trip ID
     *
     * @return array|null Array of trips or null if not found
     */

    public function getAllTripsById($tripId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM trips WHERE trip_id = ?',
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
    
    /**
     * Retrieve all trips from the database.
     *
     * @return array|string An array of all trips if found, or "Trip not found" if no trips exist.
     * @throws Exception If the query fails, an error message is echoed.
     */
    public function getAllTrips() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM trips'
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
    /**
     * Fetches trips with a specific status and email.
     *
     * @param string $status The status of the trip to fetch.
     * @param string $email The email of the user to fetch trips for.
     *
     * @return array|string The trip data if found, or an error message if not.
     */
    public function getTripsFilterByStatus( $status, $email) {
        try {
            // Prepare and execute query to fetch trips with status = 'ongoing'
            $stmt = $this->db->query(
                'SELECT * FROM trips WHERE status = ? AND email = ?', ['ss', $status, $email]
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

    /**
     * Fetches all trips associated with the given email.
     * 
     * @param string $email Email address of the user to fetch trips for.
     * @return array|null An array of trip data if found, "User not found" if not.
     * @throws Exception If the database query fails, an exception is thrown.
     */
    public function getTripsByEmail($email) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM trips WHERE email = ?',
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

    /**
     * Updates the status of a trip in the database.
     *
     * @param string $tripId    The ID of the trip to update.
     * @param string $status    The new status of the trip.
     *
     * @throws Exception If the update query fails.
     */
    public function updateTripStatus($tripId, $status) {
        try {
            $this->db->query(
                'UPDATE trips SET status = ? WHERE trip_id = ?',
                ['ss', $status, $tripId]
            );
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        } 
    }
    /**
     * Updates the driver assigned to a trip.
     *
     * @param string $tripId    The ID of the trip to update.
     * @param string $driver_id The ID of the driver to assign to the trip.
     *
     * @throws Exception If the database query fails, an exception is thrown.
     */
    public function updateTripDriver($tripId, $driver_id) {
        try {
            // Prepare and execute query to update trip with the given driver ID
            $this->db->query(
                'UPDATE trips SET driver_id = ? WHERE trip_id = ?',
                ['ss', $driver_id , $tripId]
            );
        } catch (Exception $e) {
            // Handle any exceptions
            echo "Failed to get user profile: " . $e->getMessage();
        } 
    }

    
    /**
     * Fetches all ongoing trips assigned to the given driver ID.
     * 
     * @param string $driverId The ID of the driver to fetch trips for.
     * @return array|null An array of trip data if found, or "User not found" if not.
     * @throws Exception If the database query fails, an exception is thrown.
     */
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
    /**
     * Updates the status of trips for a specific driver to 'completed'.
     *
     * @param string $driverId The ID of the driver whose trip status is to be updated.
     *
     * @return mixed The result of the update query.
     *
     * @throws Exception If the query execution fails.
     */
    public function updateTripsByDriver($driverId) {
        try {
            // Prepare and execute query to update trips with status = 'completed'
            $update = $this->db->query(
                'UPDATE trips SET status = ? WHERE driver_id = ?',
                ['ss', 'completed', $driverId]
            )
            ;
            return $update;
        } catch (Exception $e) {
            // Handle any exceptions
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }

    /**
     * Update the acceptance status of trips for a specific driver.
     *
     * @param string $driverId   The ID of the driver whose trip acceptance status is to be updated.
     * @param string $isAccepted The new acceptance status to set for the trips.
     *
     * @return mixed The result of the update query.
     *
     * @throws Exception If the query execution fails.
     */
    public function updateTripsByDriverWithIsAccepted($driverId, $isAccepted) {
        try {
            $update = $this->db->query(
                'UPDATE trips SET is_accepted = ? WHERE driver_id =?',
                ['ss', $isAccepted, $driverId]
            );
            return $update;
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    /**
     * Fetches trips by driver id with is_accepted status.
     *
     * @param string $driverId
     * @param string $isAccepted
     *
     * @return array
     */
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