<?php

include_once(__DIR__.'/ilalin_app.php');
/**
 * Handles operations related to vehicles.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class Vehicle extends IlalinApp {

    /**
     * Retrieves the vehicle associated with the given driver ID.
     *
     * @param int $driver_id Driver ID to retrieve the vehicle for.
     *
     * @return array|bool    Array of vehicle data if found, false otherwise.
     */
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

    /**
     * Updates the vehicle associated with the given driver ID.
     *
     * @param int $driver_id    Driver ID to update the vehicle for.
     * @param string $vehicle_name Vehicle name to update.
     * @param string $plat_number Plate number to update.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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

    /**
     * Inserts a new vehicle into the database.
     *
     * @param int $driver_id    Driver ID to insert the vehicle for.
     * @param string $vehicle_name Vehicle name to insert.
     * @param string $plat_number Plate number to insert.
     *
     * @return bool|string    True if successful, error message otherwise.
     */
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