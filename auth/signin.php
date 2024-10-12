<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->


<?php
session_start();

// Include the database connection file
include '../controller/php/database.php';

// Create Account Validation
$isSubmit = isset($_POST['submit']);

if($isSubmit) {
    // Check for empty fields by POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $username = $_POST['username'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $tel = $_POST['telepon'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
 
        function duplicate($email) {
            $db = new Database();
            $result = $db->fetch('users', "*", 'email = ?', [$email]);

            if ($result) {
                return true;
            }

            return false;
        };

        // Check for duplicated email addresss
        if(duplicate($email)) { 
?>

<!-- Popup Duplicated Email -->
<div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
    style="position: fixed;z-index: 2;bottom: 0;left: 0;margin-block-end: 1rem;margin-inline-start: 1rem; border-color: var(--primary-color-name);">

    <div class="toast-header  ">
        <strong class="me-auto" style="color: var(rgb(--primary-color)) !important;">Error! Duplicate Email
            Address</strong>
        <button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Gunakan alamat email yang berbeda.
    </div>
</div>
<?php 

        } else {
            $db = new Database();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            function getBase64($image_path) {
                $image_data = file_get_contents($image_path);
                return base64_encode($image_data);
            }

            $data = [
                'nama' => $username, 
                'email' => $email,
                'nomor_telepon' => $tel,
                'password' => $hashed_password, 
                'peran' => $role,        
                'profile_image' => getBase64('../images/default_profile.png')
            ];
            $insertResult = $db->insert('users', $data);
            
            if ($insertResult !== false) {
                $message = "Data inserted successfully!";
                
                $_SESSION['message'] = $message;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;

                unset($_SESSION['message']);
                ?>

<!-- Account Created Successfully Pop UP -->
<div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
    style="position: fixed;z-index: 2;bottom: 0;left: 0;margin-block-end: 1rem;margin-inline-start: 1rem; border-color: var(--primary-color-name);">

    <div class="toast-header  ">
        <p class="me-auto" style="color: var(rgb(--primary-color)) !important;"> Great
            <strong><?=$username?></strong>!,
            Account Created Successfully!
        </p>
        <button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">We will redirect you to user page in a few seconds
    </div>
</div>
<script>
setTimeout(function() {
    window.location.href = '../users/index.php';
}, 3000);
</script>

<?php

            } else {
                echo "Error inserting data";
            }
            $db->close();
        }

    } 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="../images/logo/logo-ilalin.ico" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Vendor -->
    <link href="../admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style/sign-google.css">
    <style>
    .bg-mitra {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(28, 56, 39, 0.641)),
            url("../assets/images/supir/tr5.png");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top;
    }
    </style>

    <title>Signin - iLalin</title>
</head>

<body>

    <div class="row h-screen">
        <!-- Start Hero Section -->
        <div class="col-md-4 bg-mitra pb-5 p-0">
            <nav class="w-100 p-0 navbar navbar-dark bg-ilalin flex-column align-items-start p-5">
                <a class="navbar-brand fs-4 w-100" href="../index.php">iLalin<span>.</span></a>
                <ul class="navbar-nav flex-row gap-3 fs-5">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.html"><i class="ri-home-6-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../tentang.html"><i class="ri-team-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../layanan.html"><i class="ri-service-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../mitra.html"><i class="ri-shake-hands-line text-white-80"></i></a>
                    </li>
                </ul>
            </nav>
            <div class="d-flex flex-column justify-content-between px-5 mt-5">
                <div class="d-flex">
                    <div class="text-white">
                        <p class="fs-1 fw-bold lh-sm text-yellow">Apa Kareba?</p>
                        <div class="d-flex flex-column">
                            <a class="text-white-80 text-decoration-none" href="./login.php">Login</a>
                            <a class="text-white-80 text-decoration-none" href="./signin.php">Sign Up</a>
                        </div>
                    </div>
                </div>
                <div class="mt-5 row">
                    <a href="" class="fs-7 text-white">Butuh bantuan? Hubungi kami.</a>
                    <a href="admin-login.php" class="fs-7 text-white mt-3">Admin?</a>
                </div>
            </div>
        </div>
        <!-- End Hero Section -->

        <!-- Login 8 - Bootstrap Brain Component -->
        <div class="col-md bg-light d-flex align-items-center justify-content-center">
            <div class="row ">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="px-5">

                        <div class="text-center mb-4">
                            <a href="../index.php">
                                <img src="../images/logo/logo-ilalin.png" alt="BootstrapBrain Logo" width="100"
                                    height="100">
                            </a>
                        </div>

                        <div class="text-center">
                            <h4>Terhubung dengan kami</h4>
                            <p>
                                Selamat datang kembali, silahkan mengisi data anda. <a href="login.php">Sudah punya
                                    akun?</a>
                            </p>
                        </div>

                        <!-- Manual Sigin -->
                        <form action="" method="POST">
                            <div class="row gy-2">

                                <!-- Username -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <input type="text" minlength="4" class="form-control" name="username" id="name"
                                            value="" placeholder="Name" required />
                                        <label for="username" class="form-label">Nama Pengguna</label>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <select class="form-control" id="floatingSelect" name="role"
                                            aria-label="Floating label select example" required>
                                            <option value="penumpang">Penumpang</option>
                                            <option value="pengemudi">Pengemudi</option>
                                        </select>
                                        <label for="floatingSelect">Masuk sebagai: </label>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <input type="email" class="form-control" name="email" id="email" value=""
                                            placeholder="Email" required />
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>

                                <!-- No Telepon -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <input type="tel" id="telepon" name="telepon" class="form-control" value=""
                                            placeholder="Telepon" required />
                                        <label for="telepon" class="form-label">Telepon</label>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-12">
                                    <div class="form-floating mb-1">
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" placeholder="Password" required />
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="col-12">
                                    <div class="form-floating mb-1">
                                        <input type="password" class="form-control" name="confirm_password"
                                            id="confirm_password" value="" placeholder="Confirm Password" required />
                                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    </div>
                                </div>



                                <!-- Keep Login -->
                                <div class="col-12">
                                    <div class="form-check d-flex align-items-center gap-1">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="simpan_kredensial" id="simpan_kredensial" />
                                        <label class="form-check-label text-secondary" for="simpan_kredensial">
                                            Simpan Kredensial
                                        </label>
                                    </div>
                                </div>

                                <!-- Login BTN -->
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-dark" type="submit" name="submit">
                                            Masuk
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Forgot Password -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="">
                                    <a href="#!" class="link-secondary text-decoration-none">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/script.js"></script>
    </script>
</body>

</html>