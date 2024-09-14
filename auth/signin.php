<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
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
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />


    <link href="../css/tiny-slider.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="sign-google.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js" defer></script>

    <title>Login - iLalin</title>
</head>

<body>

    <div class="row h-screen">
        <!-- Start Hero Section -->
        <div class="col-md-4 bg-mitra pb-5 p-0">
            <nav class="w-100 p-0 navbar navbar-dark bg-ilalin flex-column align-items-start p-5">
                <a class="navbar-brand fs-4 w-100" href="../index.php">iLalin<span>.</span></a>
                <ul class="navbar-nav flex-row gap-3 fs-5">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php"><i class="ri-home-6-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../tentang.php"><i class="ri-team-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../layanan.php"><i class="ri-service-line text-white-80"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="../mitra.php"><i class="ri-shake-hands-line text-white-80"></i></a>
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
                        <form action="#!">
                            <div class="row gy-2">

                                <!-- Nama -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <input type="name" class="form-control" name="name" id="name" value=""
                                            placeholder="Name" required />
                                        <label for="email" class="form-label">Nama</label>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-lg-6">
                                    <div class="form-floating mb-1">
                                        <select class="form-control" id="floatingSelect"
                                            aria-label="Floating label select example">
                                            <option selected value="penumpang">Penumpang</option>
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
                                        <input type="tel" id="telepon" name="telepon"
                                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" class="form-control" value=""
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
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" placeholder="Password" required />
                                        <label for="password" class="form-label">Konfirmasi Password</label>
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
                                        <button class="btn btn-dark" type="submit">
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

                        <!-- Sigin With Google -->
                        <div class="d-flex justify-content-center  ">
                            <button class="gsi-material-button mt-3">
                                <div class="gsi-material-button-state"></div>
                                <div class="gsi-material-button-content-wrapper">
                                    <div class="gsi-material-button-icon">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                                            <path fill="#EA4335"
                                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                            </path>
                                            <path fill="#4285F4"
                                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                            </path>
                                            <path fill="#FBBC05"
                                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                            </path>
                                            <path fill="#34A853"
                                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                            </path>
                                            <path fill="none" d="M0 0h48v48H0z"></path>
                                        </svg>
                                    </div>
                                    <span class="gsi-material-button-contents">Sign in with Google</span>
                                    <span style="display: none;">Sign in with Google</span>
                                </div>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tiny-slider.js"></script>
    <script src="../js/custom.js"></script>
    <script>
    $("#tel").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
    </script>
</body>

</html>