<?php
include_once(__DIR__.'/profile.php');
class UserController extends ProfileController {

    /**
     * Update user profile information.
     *
     * @param int $userId User ID to update.
     * @param string $username New username.
     * @param string $email New email address.
     * @param string $phone New phone number.
     *
     * @return string Status message.
     */
    public function updateUserProfile($userId, $username, $email, $phone) {
        try {
            // Check if email already exists for another user
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE email = ? AND id != ?',
                ['si', $email, $userId]
            );
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered to another user!";
            }

            // Update user information
            $this->db->query(
                'UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ?',
                ['sssi', $username, $email, $phone, $userId]
            );

            return "User  profile updated successfully!";
        } catch (Exception $e) {
            return "Failed to update user profile: " . $e->getMessage();
        }
    }

    /**
     * Change user password.
     *
     * @param int $userId User ID to change password.
     * @param string $currentPassword Current password.
     * @param string $newPassword New password.
     *
     * @return string Status message.
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            // Retrieve user data
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE id_pengguna = ?',
                ['i', $userId]
            );
            $user = $stmt->get_result()->fetch_assoc();

            if ($user && password_verify($currentPassword, $user['password'])) {
                // Hash the new password
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password
                $this->db->query(
                    'UPDATE users SET password = ? WHERE id_pengguna = ?',
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

    /**
     * Get user by ID.
     *
     * @param int $userId User ID to retrieve.
     *
     * @return array|bool User data if found, false otherwise.
     */
    public function getUserById($userId) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE id = ?',
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

    /**
     * List all users (for admin functionality).
     *
     * @return array All users.
     */
    public function listAllUsers() {
        try {
            $stmt = $this->db->query('SELECT * FROM users');
            $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            return $users; // Return all users
        } catch (Exception $e) {
            return "Failed to list users: " . $e->getMessage();
        }
    }

    /**
     * Search users by name or email.
     *
     * @param string $searchTerm Search term to search for users.
     *
     * @return array Matched users.
     */
    public function searchUsers($searchTerm) {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE username LIKE ? OR email LIKE ?',
                ['ss', "%$searchTerm%", "%$searchTerm%"]
            );
            $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            return $users; // Return matched users
        } catch (Exception $e) {
            return "Failed to search users: " . $e->getMessage();
        }
    }

    
    /**
     * Update user profile information.
     *
     * @param int $userId User ID to update.
     * @param string $nama New full name.
     * @param string $username New username.
     * @param string $email New email address.
     * @param string $nomorTelepon New phone number.
     * @param string $alamat New address.
     *
     * @return string Status message.
     */
    public function updateProfile($userId, $nama, $username, $email, $nomorTelepon, $alamat) {
        try {
            // Check if email already exists for another user
            $stmt = $this->db->query(
                'SELECT * FROM users WHERE email = ? AND id_pengguna != ?',
                ['si', $email, $userId]
            );
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered to another user!";
            }

            try {
                // start trnsaction
                $this->db->query("START TRANSACTION");
                
                $this->db->query(
                    'UPDATE users SET nama = ?, username = ?, email = ?, nomor_telepon = ?, alamat = ? WHERE id_pengguna = ?',
                    ['sssssi', $nama, $username, $email, $nomorTelepon, $alamat, $userId]
                    
                );

                $this->db->query("COMMIT");

                return true;
            } catch (Exception $e) {
                $this->db->query("ROLLBACK");
                return "Failed to update user profile: " . $e->getMessage();
            }

        
        } catch (Exception $e) {
            return "Failed to update user profile: " . $e->getMessage();
        }
    }
}