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
include '../controller/php/connection.php';
include '../controller/php/validator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $validator = new FormValidator($_POST);

    try {
        $validator->validate();
        // If validation passes, process the form
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if($role == "pengemudi") {
            
            $stmt = $conn->prepare("SELECT * FROM drivers WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();    
            $user = $stmt->get_result()->fetch_assoc();
            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['driver_id'] = $user['driver_id'];
                $_SESSION['nama'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = 'driver';
                $_SESSION['logged_in'] = true;
                header("Location:../driver/index.php"); // Redirect to a protected page
                echo "Logged in successfully!";
                exit();
            } else {
                ?>
<!-- Popup Invalid Credential -->
<div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
    style="position: fixed;z-index: 2;bottom: 0;left: 0;margin-block-end: 1rem;margin-inline-start: 1rem; border-color: var(--primary-color-name);">
    <div class="toast-header  ">
        <strong class="me-auto" style="color: var(rgb(--primary-color)) !important;">Error! Invalid Credential</strong>
        <button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Masukkan Email/Password yang benar.
    </div>
</div>
<?php
                // exit();
            }
        }

                // Prepare and execute SQL query to fetch the admin record
        $stmt = $conn->prepare("SELECT id_pengguna, nama, email, nomor_telepon, password, peran, profile_image FROM users WHERE email = ? AND peran = ?");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();     
        $stmt->store_result();

        // Validate Password
        if ($stmt->num_rows == 1) {
            // Bind the result to variables
            $stmt->bind_result($id_pengguna, $nama, $email, $nomor_telepn, $hashed_password, $peran, $profileImage);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                // Password is correct, store user data in the session and redirect
                $_SESSION['user_id'] = $id_pengguna;
                $_SESSION['email'] = $email;

                $_SESSION['logged_in'] = true;
                // username as name from the 'name' fields
                $_SESSION['username'] = $nama;
                $_SESSION['profile_image'] = $profileImage;
                $_SESSION['message'] = "Login successful!";
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $peran;
                $_SESSION['profile_image'] = $profileImage;
                
                header("Location: ../users/index.php"); // Redirect to a protected page

                echo "aw";
                exit();
            } else {

    ?>
<!-- Popup Invalid Credential -->

<?php

                    $_SESSION['message'] = "Invalid password.";
                    //header("Location: ../../auth/admin-login.php");
                    echo $_SESSION['message'];
                }
            } else {
                $_SESSION['message'] = "No account found with that email.";
                echo $_SESSION['message'];
                header("Location: ");
                // exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="../assets/images/logo/logo-ilalin.ico" />

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

    <title>Login - iLalin</title>
</head>

<body>

    <div class="row h-screen">
        <!-- Start Hero Section -->
        <div class="col-4 p-0 bg-mitra">
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
        <div class="col bg-light d-flex align-items-center justify-content-center">
            <div class="row ">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="px-5">

                        <div class="text-center mb-4">
                            <a href="../index.php">
                                <img src="../assets/images/logo/logo-ilalin.png" alt="BootstrapBrain Logo" width="100"
                                    height="100">
                            </a>
                        </div>

                        <div class="text-center">
                            <h4>Masuk Dengan Akun Anda</h4>
                            <p>
                                Selamat datang kembali, silahkan mengisi data anda. <a href="signin.php">Belum punya
                                    akun?</a>
                            </p>
                        </div>



                        <form>
                            <input type="hidden" name="action" value="passengerLogin">
                            <input type="hidden" name="type" value="user">
                            <div class="row gy-2">
                                <!-- Email -->
                                <div class="col-12">
                                    <div class="form-floating mb-1">
                                        <input type="email" class="form-control" name="email" id="email" value=""
                                            placeholder="Email" required />
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="col-12 ">
                                    <div class="form-floating mb-1">
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" placeholder="Password" required />
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                </div>
                                <!-- Type -->
                                <div class="col-12 ">
                                    <div class="form-floating mb-1">
                                        <select class="form-control" id="floatingSelect" name="role"
                                            aria-label="Floating label select example" required>
                                            <option value="penumpang">Penumpang</option>
                                            <option value="pengemudi">Pengemudi</option>
                                        </select>
                                        <label for="floatingSelect">Masuk sebagai: </label>
                                    </div>
                                </div>
                                <!-- Keep Login -->
                                <div class="col-12">
                                    <div class="form-check d-flex align-items-center gap-1">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="simpan_kredensial" id="simpan_kredensial" />
                                        <label class="form-check-label text-primary" for="simpan_kredensial">
                                            Simpan Kredensial
                                        </label>
                                    </div>
                                </div>

                                <!-- Login BTN -->
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="button" id="login-btn">
                                            Masuk
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                        //Handle login on above form element, by using loginHandler function
                        document.querySelector('#login-btn').addEventListener('click', loginHandler);

                        function loginHandler(e) {
                            const form = document.querySelector('form');
                            const email = form.email.value;
                            const password = form.password.value;
                            const role = form.role.value;
                            const simpan_kredensial = form.simpan_kredensial.checked;

                            if (simpan_kredensial) {
                                localStorage.setItem('email', email);
                                localStorage.setItem('password', password);
                                localStorage.setItem('role', role);
                            } else {
                                localStorage.removeItem('email');
                                localStorage.removeItem('password');
                                localStorage.removeItem('role');
                            }

                            //manually add action and method
                            const formData = new FormData(form);
                            formData.append('action', 'passengerLogin');
                            formData.append('type', 'user');

                            fetch('../controller/php/authHandler.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '../index.php';
                                    } else {
                                        const toast = document.createElement('div');
                                        toast.classList.add('toast', 'fade', 'show');
                                        toast.setAttribute('role', 'alert');
                                        toast.setAttribute('aria-live', 'assertive');
                                        toast.setAttribute('aria-atomic', 'true');
                                        toast.style =
                                            "position: fixed;z-index: 2;bottom: 0;left: 0;margin-block-end: 1rem;margin-inline-start: 1rem; border-color: var(--primary-color-name);";
                                        toast.innerHTML = `<div class="toast-header">
                                                            <strong class="me-auto">Error</strong>
                                                        </div>
                                                        <div class="toast-body">
                                                            ${data.message}
                                                        </div>`;
                                        document.body.appendChild(toast);
                                        setTimeout(() => {
                                            toast.remove();
                                        }, 3000);
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        }
                        </script>

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

</body>

</html>