<?php
include_once(__DIR__.'/ilalin_app.php');
class Auth extends IlalinApp {
    protected $userType;

    public function __construct($userType = 'user', IlalinUtils $utils = null) {
        parent::__construct($utils);
        $this->userType = $userType;
    }

    // Determine table based on user type
    private function getTableName() {
        return $this->userType === 'admin' ? 'Admins' : 'Users';
    }


    // Register a new user
    public function register($table, $data = []) {
        try {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $phone = $data['phone'];
            $imageString = $data['image'];
            
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            
            if ($stmt->get_result()->num_rows > 0) {
                return "Email already registered!";
            }
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            
            if ($table === 'users') {
                $this->db->query(
                    "INSERT INTO users (username, email, nomor_telepon,  password, profile_image ) VALUES (?, ?, ?, ?, ?)",
                    ['sssss', $username, $email, $phone, $passwordHash, $imageString]
                );
            } elseif ($table === 'drivers') {
                $this->db->query(
                    "INSERT INTO drivers (name, email, phone_number, password_hash, profile_image) VALUES (?, ?, ?, ?, ?)",
                    ['sssss', $username, $email, $phone, $passwordHash, $imageString]
                );
            }
            
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

    // Log in a user or admin
    public function login($email, $password, $table = null) {
        try {
            $table = $table ?? $this->getTableName();
            $stmt = $this->db->query("SELECT * FROM $table WHERE email = ?", ['s', $email]);
            $user = $stmt->get_result()->fetch_assoc();

            if(!isset($user['password'])) {
                if(isset($user['password_hash'])) {
                    $user['password'] = $user['password_hash'];
                }
            }
            if(!isset($user['nama'])) {
                if(isset($user['name'])) {
                    $user['nama'] = $user['name'];
                }
            }
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

    // Check if a user or admin is logged in
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    // Log out the user or admin
    public function logout() {
        session_unset();
        session_destroy();
        return "User logged out successfully!";
    }
}