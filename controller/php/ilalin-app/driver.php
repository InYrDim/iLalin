<?php

include_once(__DIR__.'/ilalin_app.php');
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
                return false;
            }
        } catch (Exception $e) {
            echo "Failed to get drivers: " . $e->getMessage();
        }
    }
    public function updateDriverStatus($driverId, $status) {
        try {
            $drivers = $this->db->query(
                'UPDATE drivers SET status = ? WHERE driver_id = ?',
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
                'UPDATE drivers SET latitude =?, longitude =? WHERE driver_id =?',
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
                'UPDATE drivers SET password_hash =? WHERE driver_id =?',
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
                'SELECT * FROM drivers WHERE driver_id = ?',
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
                'SELECT * FROM drivers WHERE email = ?',
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
                'DELETE FROM drivers WHERE driver_id =?',
                ['i', $driver_id]
            );
        } catch (Exception $e) {
            echo "Failed to delete driver: ". $e->getMessage();
        }
    }
    public function getAllDrivers() {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM drivers'
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