<?php

include_once(__DIR__.'/ilalin_app.php');
/**
 * ProfileController
 *
 * Handles user profile management, including deleting and updating user
 * profiles.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class ProfileController extends IlalinApp {
    
    /**
     * Delete a user and all associated records.
     *
     * This includes removing the user record, trips, and payments associated
     * with the user.
     *
     * @param int $userId User ID to delete.
     *
     * @return string Status message.
     */
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
    /**
     * Retrieve a user profile by email.
     *
     * @param string $email Email address of the user to retrieve.
     *
     * @return array|bool User data if found, false otherwise.
     */
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
    /**
     * Replace the user's profile image.
     *
     * @param string $email Email address of the user to update.
     * @param string $imageString New image string.
     * @param string $table Table to update. Defaults to 'users'.
     *
     * @return string Status message.
     */
    public function replaceImage($email, $imageString , $table = "users") {
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