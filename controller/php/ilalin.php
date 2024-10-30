<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'ilalin';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }
    
        if ($params) {
            // Extract types from params and bind them.
            $types = array_shift($params);  // First param is type string.
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
    
        return $stmt;
    }
    
    // Start a new transaction
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    // Commit the current transaction
    public function commit() {
        $this->conn->commit();
    }

    // Roll back the current transaction
    public function rollback() {
        $this->conn->rollback();
    }
    public function __destruct() {
        $this->conn->close();
    }
}
class IlalinUtils {
    // Constants
    protected const PAYMENT_PER_KM = 900; // Rp 900 per km
    protected const DRIVER_PROFIT_PERCENTAGE = 0.8333; // 83.33%

    /**
     * Calculates the total payment for a trip based on distance.
     */
    public function calculateTotalPayment(int $distance): float {
        if ($distance < 0) {
            throw new InvalidArgumentException("Distance must be non-negative.");
        }
        return self::PAYMENT_PER_KM * $distance;
    }

    /**
     * Calculates both driver and company profits from the total payment.
     */
    public function calculateProfits(float $totalPayment): array {
        $driverProfit = round($totalPayment * self::DRIVER_PROFIT_PERCENTAGE, 2);
        $companyProfit = round($totalPayment - $driverProfit, 2);

        return [
            'driverProfit' => $driverProfit,
            'companyProfit' => $companyProfit
        ];
    }

    /**
     * Formats a given amount according to the country's currency format.
     */
    public function formatCurrency(float $amount, string $country = 'ID'): string {
        return match (strtoupper($country)) {
            'ID' => 'Rp. ' . number_format($amount, 2, ',', '.'), // Indonesia (Rp)
            'US' => '$' . number_format($amount, 2, '.', ','),   // US Dollar ($)
            default => number_format($amount, 2), // Default formatting
        };
    }
}
class IlalinApp {
    protected $db;
    protected $utils;

    public function __construct(IlalinUtils $utils = null) {
        $this->db = new Database();
        $this->utils = $utils ?? new IlalinUtils(); // Use the provided $utils or create a new instance.
    }    

    
    

    public function deleteUser($userId) {
        try {
            $this->db->beginTransaction(); // Start a transaction
    
            // Find related trips
            $trips = $this->db->query(
                'SELECT * FROM Trips WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            )->get_result()->fetch_all(MYSQLI_ASSOC);
    
            // Update trips to set status to 'cancelled'
            foreach ($trips as $trip) {
                $this->db->query(
                    'UPDATE Trips SET status = ? WHERE id = ?', 
                    ['si', 'cancelled', $trip['id']]
                );
            }
    
            // Remove payments associated with the user
            $this->db->query(
                'DELETE FROM Payments WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            );
    
            // Remove user record
            $this->db->query('DELETE FROM Users WHERE id = ?', ['i', $userId]);
    
            $this->db->commit(); // Commit the transaction
            echo "User deleted successfully!";
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback the transaction if something fails
            echo "Failed to delete user: " . $e->getMessage();
        }
    }
    public function getUserProfile($email) {
        try {
            // Retrieve user profile based on email
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE email = ?', 
                ['s', $email]
            );
            $user = $stmt->get_result()->fetch_assoc();
    
            if ($user) {
                return $user; // Return user data if found
            } else {
                return "User not found";
            }
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function replaceImage($email, $imageString) {
        try {
            // Update the user's profile image
            $this->db->query(
                'UPDATE Users SET profile_image = ? WHERE email = ?', 
                ['ss', $imageString, $email]
            );
    
            echo "Image replaced successfully!";
        } catch (Exception $e) {
            echo "Failed to replace image: " . $e->getMessage();
        }
    }
    
}
class PaymentsUtils extends IlalinUtils {
    /**
     * Calculates the total payment for a trip based on distance.
     */
    public function calculateTotalPayment(int $distance): float {
        if ($distance < 0) {
            throw new InvalidArgumentException("Distance must be non-negative.");
        }
        return self::PAYMENT_PER_KM * $distance;
    }

    /**
     * Calculates both driver and company profits from the total payment.
     */
    public function calculateProfits(float $totalPayment): array {
        $driverProfit = round($totalPayment * self::DRIVER_PROFIT_PERCENTAGE, 2);
        $companyProfit = round($totalPayment - $driverProfit, 2);

        return [
            'driverProfit' => $driverProfit,
            'companyProfit' => $companyProfit
        ];
    }

    /**
     * Formats a given amount according to the country's currency format.
     */
    public function formatCurrency(float $amount, string $country = 'ID'): string {
        return match (strtoupper($country)) {
            'ID' => 'Rp. ' . number_format($amount, 2, ',', '.'), // Indonesia (Rp)
            'US' => '$' . number_format($amount, 2, '.', ','),   // US Dollar ($)
            default => number_format($amount, 2), // Default formatting
        };
    }
}
class ProfileController extends IlalinApp {
    
    public function deleteUser($userId) {
        try {
            $this->db->beginTransaction(); // Start a transaction
    
            // Find related trips
            $trips = $this->db->query(
                'SELECT * FROM Trips WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            )->get_result()->fetch_all(MYSQLI_ASSOC);
    
            // Update trips to set status to 'cancelled'
            foreach ($trips as $trip) {
                $this->db->query(
                    'UPDATE Trips SET status = ? WHERE id = ?', 
                    ['si', 'cancelled', $trip['id']]
                );
            }
    
            // Remove payments associated with the user
            $this->db->query(
                'DELETE FROM Payments WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            );
    
            // Remove user record
            $this->db->query('DELETE FROM Users WHERE id = ?', ['i', $userId]);
    
            $this->db->commit(); // Commit the transaction
            echo "User deleted successfully!";
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback the transaction if something fails
            echo "Failed to delete user: " . $e->getMessage();
        }
    }
    public function getUserProfile($email) {
        try {
            // Retrieve user profile based on email
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE email = ?', 
                ['s', $email]
            );
            $user = $stmt->get_result()->fetch_assoc();
    
            if ($user) {
                return $user; // Return user data if found
            } else {
                return "User not found";
            }
        } catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function replaceImage($email, $imageString) {
        try {
            // Update the user's profile image
            $this->db->query(
                'UPDATE Users SET profile_image = ? WHERE email = ?', 
                ['ss', $imageString, $email]
            );
    
            echo "Image replaced successfully!";
        } catch (Exception $e) {
            echo "Failed to replace image: " . $e->getMessage();
        }
    }
}

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
                return "User not found";
            }
        }catch (Exception $e) {
            echo "Failed to get user profile: " . $e->getMessage();
        }
    }
    public function getTripsFilterByStatus( $status) {
        try {
            // Prepare and execute query to fetch trips with status = 'ongoing'
            $stmt = $this->db->query(
                'SELECT * FROM Trips WHERE status = ?', ['s', $status]
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
}
class Driver extends ProfileController {
    
    public function getAvaiableDriver() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Drivers WHERE status = "available" ORDER BY RAND() LIMIT 1;', 
            );
            $drivers = $stmt->get_result()->fetch_assoc();
            
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers available";
            }
        } catch (Exception $e) {
            echo "Failed to get drivers: " . $e->getMessage();
        }
    }
    
    public function getDriverById($driverId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Drivers WHERE driver_id = ?',
                ['i', $driverId]
            );
            $driver = $stmt->get_result()->fetch_assoc();
        
            if ($driver) {
                return $driver;
            } else {
                return "No drivers by that id";
            }
        } catch (Exception $e) {
            echo "Failed to get drivers: " . $e->getMessage();
        }
    }

    public function getTripsWithPassengerLocation() {
        try {
            $stmt = $this->db->query(
                'SELECT trip_id, name, email, latitude, longitude 
                 FROM trips WHERE status = ?', 
                ['s', 'active']
            );
            $trips = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if ($trips) {
                return $trips;
            } else {
                return "No active trips found.";
            }
        } catch (Exception $e) {
            echo "Error fetching trips: " . $e->getMessage();
        }
    }
}
class Vehicle extends IlalinApp {
    
    public function getVehicleType($driver_id ) {
        try {
            $stmt = $this->db->query(
               'SELECT * FROM vehicle WHERE driver_id = ?',
                ['s', $driver_id]
            );
            $vehicle = $stmt->get_result()->fetch_assoc();

            return $vehicle;
        } catch (Exception $e) {
            echo "Failed to get vehicle: " . $e->getMessage();
        }
    }
}