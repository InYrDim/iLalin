<?php

include_once(__DIR__.'/ilalin_app.php');
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