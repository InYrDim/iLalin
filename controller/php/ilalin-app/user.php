<?php
include_once(__DIR__.'/ilalin_app.php');
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