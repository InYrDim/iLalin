<?php


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
                'SELECT * FROM trips WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            )->get_result()->fetch_all(MYSQLI_ASSOC);
    
            // Update trips to set status to 'cancelled'
            foreach ($trips as $trip) {
                $this->db->query(
                    'UPDATE trips SET status = ? WHERE id = ?', 
                    ['si', 'cancelled', $trip['id']]
                );
            }
    
            // Remove payments associated with the user
            $this->db->query(
                'DELETE FROM payments WHERE user_id = ? OR driver_id = ?', 
                ['ii', $userId, $userId]
            );
    
            // Remove user record
            $this->db->query('DELETE FROM users WHERE id = ?', ['i', $userId]);
    
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
                'SELECT * FROM users WHERE email = ?', 
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
                'UPDATE users SET profile_image = ? WHERE email = ?', 
                ['ss', $imageString, $email]
            );
    
            echo "Image replaced successfully!";
        } catch (Exception $e) {
            echo "Failed to replace image: " . $e->getMessage();
        }
    }
    
}