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
class Auth extends IlalinApp {
    protected $userType;

    public function __construct($userType = 'user', IlalinUtils $utils = null) {
        parent::__construct($utils);
        $this->userType = $userType;
    }

    // Determine table based on user type
    private function getTableName() {
        return $this->userType === 'admin' ? 'Admins' : 'Users';
    }


    // Register a new user or admin
    public function register($username, $email, $password) {
        try {
            $table = $this->getTableName();
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered!";
            }

            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user or admin
            $this->db->query(
                "INSERT INTO $table (username, email, password_hash) VALUES (?, ?, ?)",
                ['sss', $username, $email, $passwordHash]
            );

            return "User registered successfully!";
        } catch (Exception $e) {
            return "Failed to register user: " . $e->getMessage();
        }
    }

    // Log in a user or admin
    public function login($email, $password, $table = null) {
        try {
            $table = $table ?? $this->getTableName();
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            $user = $stmt->get_result()->fetch_assoc();


            if ($user && password_verify($password, $user['password'])) {
                session_start();
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id_admin'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['profile_image'] = $user['profile_image'];
                $_SESSION['user_type'] = $this->userType;
                $_SESSION['logged_in'] = true;
                return "Logged in successfully!";
            } else {
                return "Invalid email or password.";
            }
        } catch (Exception $e) {
            return "Failed to log in: " . $e->getMessage();
        }
    }

    // Check if a user or admin is logged in
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    // Log out the user or admin
    public function logout() {
        session_unset();
        session_destroy();
        return "User logged out successfully!";
    }
}

class UserController extends IlalinApp {
    
    // Update user profile information
    public function updateUserProfile($userId, $username, $email, $phone) {
        try {
            // Check if email already exists for another user
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE email = ? AND id != ?',
                ['si', $email, $userId]
            );
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered to another user!";
            }

            // Update user information
            $this->db->query(
                'UPDATE Users SET username = ?, email = ?, phone = ? WHERE id = ?',
                ['sssi', $username, $email, $phone, $userId]
            );

            return "User  profile updated successfully!";
        } catch (Exception $e) {
            return "Failed to update user profile: " . $e->getMessage();
        }
    }

    // Change user password
    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            // Retrieve user data
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE id = ?',
                ['i', $userId]
            );
            $user = $stmt->get_result()->fetch_assoc();

            if ($user && password_verify($currentPassword, $user['password'])) {
                // Hash the new password
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

                // Update the password
                $this->db->query(
                    'UPDATE Users SET password = ? WHERE id = ?',
                    ['si', $newPasswordHash, $userId]
                );

                return "Password changed successfully!";
            } else {
                return "Current password is incorrect.";
            }
        } catch (Exception $e) {
            return "Failed to change password: " . $e->getMessage();
        }
    }

    // Get user by ID
    public function getUserById($userId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE id = ?',
                ['i', $userId]
            );
            $user = $stmt->get_result()->fetch_assoc();

            if ($user) {
                return $user; // Return user data if found
            } else {
                return "User  not found";
            }
        } catch (Exception $e) {
            return "Failed to get user: " . $e->getMessage();
        }
    }

    // List all users (for admin functionality)
    public function listAllUsers() {
        try {
            $stmt = $this->db->query('SELECT * FROM Users');
            $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            return $users; // Return all users
        } catch (Exception $e) {
            return "Failed to list users: " . $e->getMessage();
        }
    }

    // Search users by name or email
    public function searchUsers($searchTerm) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Users WHERE username LIKE ? OR email LIKE ?',
                ['ss', "%$searchTerm%", "%$searchTerm%"]
            );
            $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            return $users; // Return matched users
        } catch (Exception $e) {
            return "Failed to search users: " . $e->getMessage();
        }
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
    public function replaceImage($email, $imageString , $table = "Users") {
        try {
            // Update the user's profile image
            $this->db->query(
                "UPDATE $table SET profile_image = ? WHERE email = ?", 
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
class Driver extends ProfileController {
    
    public function getAvaiableDriverAndCar() {
        try {
            $stmt = $this->db->query(
                "SELECT `vehicle`.*, `drivers`.*, `drivers`.`status`, `vehicle`.`status`
                FROM `vehicle` 
                    LEFT JOIN `drivers` ON `vehicle`.`driver_id` = `drivers`.`driver_id`
                WHERE `drivers`.`status` = 'available' AND `vehicle`.`status` = 'available' ORDER BY RAND() LIMIT 1;"
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
    public function updateDriverStatus($driverId, $status) {
        try {
            $drivers = $this->db->query(
                'UPDATE Drivers SET status = ? WHERE driver_id = ?',
                ['si', $status, $driverId]
            );
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers available";
            }
        } catch (Exception $e) {
            echo "Failed to get user profile: ". $e->getMessage();
        }
    }
    public function updateDriverPosition($driverId, $latitude, $longitude) {
        try {
            $drivers = $this->db->query(
                'UPDATE Drivers SET latitude =?, longitude =? WHERE driver_id =?',
                ['ddi', $latitude, $longitude, $driverId]
            );
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers available";
            }
        } catch (Exception $e) {
            echo "Failed to update driver positiob: ". $e->getMessage();
        }
    }
    public function updateDriverPassword($driverId, $password) {
        try {
            $drivers = $this->db->query(
                'UPDATE Drivers SET password_hash =? WHERE driver_id =?',
                ['si', $password, $driverId]
            );
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers available";
            }
        } catch (Exception $e) {
            echo "Failed to update driver password: ". $e->getMessage();
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
    public function getDriverByEmail($email) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Drivers WHERE email = ?',
                ['s', $email]
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
    public function getDriversGroupedByCreationDate() {
        try {
            $stmt = $this->db->query(
                'SELECT DATE(created_at) as created_date, COUNT(*) as driver_count 
                    FROM drivers 
                    GROUP BY created_date 
                    ORDER BY created_date ASC'
            );
            $drivers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers with that status";
            }
        } catch (Exception $e) {
            echo "Failed to get drivers: ". $e->getMessage();
        }
    }
    public function deleteDriverById($driver_id) {
        try {
            // No Handler when driver is had foreign keys error
            return $this->db->query(
                'DELETE FROM Drivers WHERE driver_id =?',
                ['i', $driver_id]
            );
        } catch (Exception $e) {
            echo "Failed to delete driver: ". $e->getMessage();
        }
    }
    public function getAllDrivers() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Drivers'
            );
            $drivers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers found";
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

    public function updateDriverProfile($driverId, $name, $email, $phone_number) {
        try {
            $drivers = $this->db->query(
                "UPDATE `drivers` SET `name` = ?, `email` = ?, `phone_number` = ? WHERE driver_id = ?",
                ['sssi', $name, $email, $phone_number, $driverId]
            );
            if ($drivers) {
                return $drivers;
            } else {
                return "No drivers available";
            }
        } catch (Exception $e) {
            echo "Failed to get user profile: ". $e->getMessage();
        }
    }
}
class Passenger extends IlalinApp {
    
    public function getAllPassengers() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE peran = "penumpang"'
            );
            $passengers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            if ($passengers) {
                return $passengers;
            } else {
                return "No passengers found";
            }
        } catch (Exception $e) {
            echo "Failed to get passengers: " . $e->getMessage();
        }
    }

    public function deletePassengerByEmail($userEmail) {
        try {
            $this->db->beginTransaction(); // Start a transaction
            
            
            // Find related trips
            $trips = $this->db->query(
                'SELECT * FROM Trips WHERE email = ? ', 
                ['s', $userEmail]
            )->get_result()->fetch_all(MYSQLI_ASSOC);
    
            // Delete Trip Is FOund Where Email
            if(is_array($trips)) {
            $this->db->query('DELETE FROM trips WHERE email = ?', ['s', $userEmail]);
            }
            // Remove user record
            $this->db->query('DELETE FROM users WHERE email = ?', ['s', $userEmail]);
    
            $this->db->commit(); // Commit the transaction
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback the transaction if something fails
            echo "Failed to delete user: " . $e->getMessage();
        }
    }
    
}
class Admins extends IlalinApp {
    
    public function getAllAdmins() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM Admins'
            );
            $admins = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            if ($admins) {
                return $admins;
            } else {
                return "No admins found";
            }
        } catch (Exception $e) {
            echo "Failed to get admins: " . $e->getMessage();
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
    public function updateVehicle($driver_id, $vehicle_name, $plat_number) {
        try {
            $vehicle = $this->db->query(
                'UPDATE vehicle SET vehicle_name =?, plate_number =? WHERE driver_id =?',
                ['ssi', $vehicle_name, $plat_number, $driver_id]
            );
            if ($vehicle) {
                return $vehicle;
            } else {
                return "No vehicle found";
            }
        } catch (Exception $e) {
            echo "Failed to update vehicle: ". $e->getMessage();
        }
    }
    public function insertVehicle($driver_id, $vehicle_name, $plat_number) {
        try {
            $vehicle = $this->db->query(
                'INSERT INTO vehicle (driver_id, vehicle_name, plate_number) VALUES (?,?,?)',
                ['iss', $driver_id, $vehicle_name, $plat_number]
            );
            if ($vehicle) {
                return $vehicle;
            } else {
                return "Failed to insert vehicle";
            }
        } catch (Exception $e) {
            echo "Failed to insert vehicle: ". $e->getMessage();
        }
    }
}