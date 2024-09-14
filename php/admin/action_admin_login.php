<?php
session_start();

// Include the database connection file
include '../middleware.php';
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to fetch the admin record
    $stmt = $conn->prepare("SELECT id_admin, nama, password, profile_image FROM Admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists
    if ($stmt->num_rows == 1) {
        // Bind the result to variables
        $stmt->bind_result($id_admin, $nama, $hashed_password, $profileImage);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, store admin data in the session and redirect
            $_SESSION['admin_id'] = $id_admin;
            $_SESSION['email'] = $email;
            $_SESSION['nama'] = $nama;
            $_SESSION['profile_image'] = $profileImage;
            $_SESSION['message'] = "Login successful!";
            header("Location: ../../admin/index.php"); // Redirect to a protected page
            exit();
        } else {
            $_SESSION['message'] = "Invalid password.";
            header("Location: ../../auth/admin-login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "No account found with that email.";
        header("Location: ../../auth/admin-login.php");
        exit();
    }

} else {
    header("Location: ../../auth/admin-login.php");
    exit();
}

?>