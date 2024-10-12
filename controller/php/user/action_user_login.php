<?php

session_start();

// Include the database connection file
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to fetch the admin record
    $stmt = $conn->prepare("SELECT id_pengguna, nama, email, nomor_telepon, password, peran, profile_image FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists
    if ($stmt->num_rows == 1) {
        // Bind the result to variables
        $stmt->bind_result($id_pengguna, $nama, $email, $nomor_telepn, $hashed_password, $peran, $profileImage);
        $stmt->fetch();

        // Verify the password
        var_dump($stmt);
        echo "<br/>";
        echo $peran == "";
        
        if (password_verify($password, $hashed_password) and $peran != "") {
            // Password is correct, store admin data in the session and redirect
            $_SESSION['user_id'] = $id_pengguna;
            $_SESSION['email'] = $email;
            $_SESSION['nama'] = $nama;
            $_SESSION['profile_image'] = $profileImage;
            $_SESSION['message'] = "Login successful!";
            header("Location: ../../admin/index.php"); // Redirect to a protected page
            exit();
        } else {
            $_SESSION['message'] = "Invalid password.";
            $_SESSION['email'] = $email;
            //header("Location: ../../auth/admin-login.php");
            echo $_SESSION['message'];
            exit();
        }
    } else {
        $_SESSION['message'] = "No account found with that email.";
        echo $_SESSION['message'];
        //header("Location: ../../auth/admin-login.php");
        exit();
    }

} else {
    echo $_SESSION['message'];
    //header("Location: ../../auth/admin-login.php");
    exit();
}

?>