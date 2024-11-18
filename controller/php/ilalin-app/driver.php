<?php

include_once(__DIR__.'/ilalin_app.php');
/**
 * Handles operations related to drivers.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class Driver extends ProfileController {

    /**
     * Retrieve a list of all drivers that are available.
     *
     * @return array|bool Array of drivers if found, false otherwise.
     */
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

    /**
     * Update the status of a driver to the given status.
     *
     * @param int $driverId   Driver ID to update.
     * @param string $status  Status to update the driver to.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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

    /**
     * Update the position of a driver to the given coordinates.
     *
     * @param int $driverId    Driver ID to update.
     * @param float $latitude  Latitude of the driver's new position.
     * @param float $longitude Longitude of the driver's new position.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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

    /**
     * Update the password of a driver to the given password.
     *
     * @param int $driverId    Driver ID to update.
     * @param string $password Password to update the driver to.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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

    /**
     * Get a driver by their ID.
     *
     * @param int $driverId Driver ID to retrieve.
     *
     * @return array|bool  Array of driver data if found, false otherwise.
     */
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

    /**
     * Get a driver by their email.
     *
     * @param string $email  Email address of the driver to retrieve.
     *
     * @return array|bool  Array of driver data if found, false otherwise.
     */
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

    /**
     * Get the count of drivers grouped by their creation date.
     *
     * @return array|bool  Array of driver counts if found, false otherwise.
     */
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

    /**
     * Delete a driver by their ID.
     *
     * @param int $driver_id Driver ID to delete.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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

    /**
     * Get all drivers.
     *
     * @return array|bool  Array of drivers if found, false otherwise.
     */
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

    /**
     * Get a list of trips with the passenger's location.
     *
     * @return array|bool  Array of trip data if found, false otherwise.
     */
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

    /**
     * Update the profile information of a driver.
     *
     * @param int $driverId    Driver ID to update.
     * @param string $name     Name to update the driver to.
     * @param string $email    Email address to update the driver to.
     * @param string $phone_number Phone number to update the driver to.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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