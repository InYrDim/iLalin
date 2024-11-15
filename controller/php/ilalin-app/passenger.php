<?php

include_once(__DIR__.'/ilalin_app.php');
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