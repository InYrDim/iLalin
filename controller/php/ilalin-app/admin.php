<?php

include_once(__DIR__.'/ilalin_app.php');
/**
 * Admins class extends IlalinApp
 * 
 * Provides functionality to manage and retrieve admin users from the database.
 *
 * @package IlalinApp
 * @since 1.0.0
 */
class Admins extends IlalinApp {
    
    /**
     * Retrieve all admin users.
     *
     * @return array|string List of admin users or a message if no admins are found.
     */
    public function getAllAdmins() {
        try {
            // Query to fetch all admin users
            $stmt = $this->db->query('SELECT * FROM Admins');
            
            // Fetch all results as an associative array
            $admins = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            if ($admins) {
                return $admins; // Return list of admins
            } else {
                return "No admins found"; // Return message if no admins
            }
        } catch (Exception $e) {
            // Handle any errors that occur during the query
            echo "Failed to get admins: " . $e->getMessage();
        }
    }
}