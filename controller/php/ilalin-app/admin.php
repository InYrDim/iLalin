<?php

include_once(__DIR__.'/ilalin_app.php');

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