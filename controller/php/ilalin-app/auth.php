<?php
include_once(__DIR__.'/ilalin_app.php');


/**
 * Class Auth
 *
 * Handles user authentication operations such as registration, login,
 * session management, and logout.
 *
 * @package IlalinApp
 */
class Auth extends IlalinApp {
    /**
     * @var string User type (e.g., 'user', 'admin', 'driver')
     */
    protected $userType;

    /**
     * Auth constructor.
     *
     * @param string $userType Type of user (default is 'user')
     * @param IlalinUtils|null $utils Utility class instance
     */
    public function __construct($userType = 'user', IlalinUtils $utils = null) {
        parent::__construct($utils);
        $this->userType = $userType;
    }

    /**
     * Determine the table name based on user type.
     *
     * @return string Table name
     */
    private function getTableName() {
        return $this->userType === 'admin' ? 'Admins' : 'Users';
    }

    /**
     * Register a new user or driver.
     *
     * @param string $table Table name ('users' or 'drivers')
     * @param array $data User data containing 'username', 'email', 'password', 'phone', 'image'
     * @return string Status message
     */
    public function register($table, $data = []) {
        try {
            // Extract user data
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $phone = $data['phone'];
            $imageString = $data['image'];

            // Check if the email is already registered
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered!";
            }

            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the appropriate table
            if ($table === 'users') {
                $this->db->query(
                    "INSERT INTO users (username, email, nomor_telepon, password, profile_image) VALUES (?, ?, ?, ?, ?)",
                    ['sssss', $username, $email, $phone, $passwordHash, $imageString]
                );
            } elseif ($table === 'drivers') {
                $this->db->query(
                    "INSERT INTO drivers (name, email, phone_number, password_hash, profile_image) VALUES (?, ?, ?, ?, ?)",
                    ['sssss', $username, $email, $phone, $passwordHash, $imageString]
                );
            }

            // Initialize session
            session_start();
            session_regenerate_id(true);
            $_SESSION['nama'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['user_type'] = $table;
            $_SESSION['logged_in'] = true;

            return "Created in successfully!";
        } catch (Exception $e) {
            return "Failed to register user: " . $e->getMessage();
        }
    }

    /**
     * Log in a user or driver.
     *
     * @param string $email User's email
     * @param string $password User's password
     * @param string|null $table Table name (defaults to userType's table)
     * @return string Status message
     */
    public function login($email, $password, $table = null) {
        try {
            $table = $table ?? $this->getTableName();
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            $user = $stmt->get_result()->fetch_assoc();

            // Adjust field names for different user types
            if (!isset($user['password'])) {
                $user['password'] = $user['password_hash'] ?? null;
            }
            if (!isset($user['nama'])) {
                $user['nama'] = $user['name'] ?? null;
            }

            // Verify password and initialize session if successful
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                session_regenerate_id(true);
                $_SESSION['user_id'] = $table === 'admins' ? $user['id_admin'] : ($table === 'drivers' ? $user['driver_id'] : $user['id_pengguna']);
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['profile_image'] = $user['profile_image'];
                $_SESSION['user_type'] = $table;
                $_SESSION['logged_in'] = true;
                return "Logged in successfully!";
            } else {
                return "Invalid email or password.";
            }
        } catch (Exception $e) {
            return "Failed to log in: " . $e->getMessage();
        }
    }

    /**
     * Check if a user is logged in.
     *
     * @return bool True if user is logged in, false otherwise
     */
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    /**
     * Log out the current user.
     *
     * @return string Status message
     */
    public function logout() {
        session_unset();
        session_destroy();
        return "User logged out successfully!";
    }
}