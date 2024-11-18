<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->

<?php
// include '../controller/php/middleware.php';
session_start();
// Check if there is a message in the session
if (isset($_SESSION['logged_in'])){
    header('Location: ../admin/index.php');
}

?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />

    <link rel="shortcut icon" href="../assets/images/logo/logo-ilalin.ico" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Vendor -->
    <!-- 1. Remix Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.4.0/remixicon.min.css"
        integrity="sha512-6sfYTBLNjOZhwJ5g/J0529qHqIdXxO1BycUHd1LIJjEzVCzX8cHtoXDgd+ylrqCl/OZM/RMDgkn2Dd41lJsJjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />



    <style>
    .btn-loading {
        position: relative;
        overflow: hidden;
    }

    .btn-loading::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        inset: 0;
        background-color: var(--primary-color-name);
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-loading::after {
        content: "";
        left: 50%;
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        background: none;
        border-top-color: #fff;
        border-radius: 50%;
        animation: loading 1s linear infinite;
    }

    @keyframes loading {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
    <title>Admin Login</title>

</head>

<body>
    <div class="row h-screen">
        <!-- Login 1 - Bootstrap Brain Component -->
        <div class="bg-light py-3 py-md-5">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                        <div class="bg-white p-4 p-md-5 rounded shadow-sm">

                            <!-- Form Header Container -->
                            <div class="row align-items-center">
                                <div class="col-12">

                                    <!-- Logo container -->
                                    <div class="text-center mb-2">
                                        <a href="../index.html">
                                            <img src="../assets/images/logo/logo-ilalin.png" alt="BootstrapBrain Logo"
                                                width="100" height="100" />
                                        </a>
                                    </div>

                                    <!-- Navigation -->
                                    <div class="mb-3">
                                        <h4 class="text-center">Welcome Admin!</h4>
                                        <div class="">
                                            <ul class="navbar-nav flex-row justify-content-center gap-3 fs-5">
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="../index.html"><i
                                                            class="ri-home-6-line text-dark"></i></a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="../tentang.html"><i
                                                            class="ri-team-line text-dark"></i></a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="../layanan.html"><i
                                                            class="ri-service-line text-dark"></i></a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="../mitra.html"><i
                                                            class="ri-shake-hands-line text-dark"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Login Form -->
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                            </svg>
                                        </span>
                                        <input type="email" class="form-control" id="email" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </span>
                                        <input type="password" class="form-control" id="password" value="" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg position-relative" id="login">
                                            Log In
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="loading-modal" tabindex="-1" role="dialog"
                                aria-labelledby="loading-modal-label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <p>Loading...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                            document.getElementById('login').addEventListener('click', async (e) => {
                                const email = document.getElementById('email').value;
                                const password = document.getElementById('password').value;

                                document.getElementById('login').classList.add('btn-loading');

                                const toast = document.createElement('div');
                                toast.classList.add('toast', 'fade', 'show');
                                toast.setAttribute('role', 'alert');
                                toast.setAttribute('aria-live', 'assertive');
                                toast.setAttribute('aria-atomic', 'true');
                                toast.style =
                                    "position: fixed;z-index: 2;bottom: 0;left: 0;margin-block-end: 1rem;margin-inline-start: 1rem; border-color: var(--primary-color-name);";


                                try {
                                    const response = await fetch('../controller/php/authHandler.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            action: 'adminLogin',
                                            type: 'admin',
                                            email: email,
                                            password: password
                                        }),
                                    });

                                    const data = await response.json();
                                    document.getElementById('login').classList.remove('btn-loading');

                                    if (data.status === "success") {
                                        toast.innerHTML = `<div class="toast-header">
                                                            <strong class="me-auto">Success</strong>
                                                        </div>
                                                        <div class="toast-body">
                                                            ${data.message}
                                                        </div>`;
                                        document.body.appendChild(toast);

                                        setTimeout(() => {
                                            toast.remove();
                                            window.location.href =
                                                '../admin/index.php';
                                        }, 3000);

                                    } else {
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
                                } catch (error) {
                                    console.log(error);
                                }
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>