<?php 
session_start(); include '../../php/connection.php' ; 
if(isset($_SESSION['email'])) {
    //  echo $_SESSION['email'];
    } else { 
        echo "ss" ; exit(); 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="images/logo/logo-ilalin.ico" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Vendor -->
    <link href="../../admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Leafet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="../../css/tiny-slider.css" rel="stylesheet" />
    <link href="../../css/style.css" rel="stylesheet" />

    <style>
    .custom-navbar {
        width: 100vw;
        z-index: 9999;
    }
    </style>


    <!-- Sidebar -->
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");
    @import url('../css/main.css');

    :root {
        --header-height: 3rem;
        --nav-width: 68px;
        --first-color: var(--primary-color-name);
        ;
        --first-color-light: #AFA5D9;
        --white-color: #F7F6FB;
        --body-font: 'Nunito', sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100
    }

    *,
    ::before,
    ::after {
        box-sizing: border-box
    }

    body {
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 1rem;
        font-family: var(--body-font);
        font-size: var(font-size: 15px);
        transition: .5s
    }

    a {
        text-decoration: none
    }

    .header {
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        background-color: var(--white-color);
        z-index: var(--z-fixed);
        transition: .5s
    }

    .persegi-details,
    .bgr-info {
        background-color: #000;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .persegi-details,
    .ilalin-info {
        background-color: #3b5d50;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .header_toggle {
        color: var(--first-color);
        font-size: 1.5rem;
        cursor: pointer
    }

    .header_img {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        border-radius: 50%;
        overflow: hidden
    }

    .header_img img {
        width: 40px
    }

    .l-navbar {
        position: fixed;
        top: 0;
        left: -30%;
        width: var(--nav-width);
        height: 100vh;
        background-color: var(--first-color);
        padding: .5rem 1rem 0 0;
        transition: .5s;
        z-index: var(--z-fixed)
    }

    .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden
    }

    .nav_logo,
    .nav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: .5rem 0 .5rem 1.5rem
    }

    .nav_logo {
        margin-bottom: 2rem
    }

    .nav_logo-icon {
        font-size: 1.25rem;
        color: var(--white-color)
    }

    .nav_logo-name {
        color: var(--white-color);
        font-weight: 700
    }

    .nav_link {
        position: relative;
        color: var(--first-color-light);
        margin-bottom: 1.5rem;
        transition: .3s
    }

    .nav_link:hover {
        color: var(--white-color)
    }

    .nav_icon {
        font-size: 1.25rem
    }

    .show {
        left: 0
    }

    .body-pd {
        padding-left: calc(var(--nav-width) + 1rem)
    }

    .active {
        color: var(--white-color)
    }

    .active::before {
        content: '';
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--white-color)
    }

    .rating {
        font-size: 40px;
    }

    .star {
        cursor: pointer;
        color: #777;
        /* warna default */
    }

    .star:hover {
        color: #ffd700;
        /* warna hover */
    }

    .star.active {
        color: #ffc107;
        /* warna aktif */
    }

    .height-100 {
        height: 100vh
    }

    @media screen and (min-width: 768px) {
        body {
            margin: calc(var(--header-height) + 1rem) 0 0 0;
            padding-left: calc(var(--nav-width) + 2rem)
        }

        .header {
            height: calc(var(--header-height) + 1rem);
            padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
        }

        .header_img {
            width: 40px;
            height: 40px
        }

        .header_img img {
            width: 45px
        }

        .l-navbar {
            left: 0;
            padding: 1rem 1rem 0 0
        }

        .show {
            width: calc(var(--nav-width) + 156px)
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 188px)
        }

        .ulasan textarea {
            width: 100%;
            height: 300px;
        }

        .submit-btn {
            background-color: #28a745;
            color: #000;
            border: none;
            padding: 5px 5px;
            cursor: pointer;
        }
    }

    /* div {
                outline: 1px solid black;
            } */
    </style>

    <style>
    .profile-card-3 {
        background-color: #FFF;
        border-radius: 5px;
        box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        margin: 10px auto;
        cursor: pointer;
        padding: 25px 15px;
    }

    .profile-card-3 .profile-name {
        font-weight: bold;
        color: #21304e;
    }

    .profile-card-3 .profile-location {
        color: #999;
        font-size: 13px;
        font-weight: 600;
    }

    .profile-card-3 img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        margin: 10px auto;
        border-radius: 50%;
        transition: all linear 0.25s;
    }

    .profile-card-3 .profile-description {
        font-size: 13px;
        color: #777;
        padding: 10px;
    }

    .profile-card-3 .profile-icons {
        margin: 15px 0px;
    }

    .profile-card-3 .profile-icons .fa {
        color: #fe455a;
        margin: 0px 5px;
    }
    </style>

    <title>iLalin</title>
</head>


<body>


    <div id="body-pd ">
        <header class="header border-bottom shadow-sm" id="header">
            <div class="header_toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="d-flex flex gap-3 align-items-center">
                <span><?= $_SESSION['nama'] ?></span>
                <div class="header_img">
                    <img src="../../admin/assets/img/il.jpeg" alt="">
                </div>

            </div>
        </header>

        <aside class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a href="" class="nav_logo">
                        <i class='bx bx-layer nav_logo-icon'></i>
                        <span class="nav_logo-name">iLalin</span>
                    </a>
                    <div class="nav_list">
                        <a href="" class="nav_link active">
                            <i class='bx bx-grid-alt nav_icon'></i>
                            <span class="nav_name">Dashboard</span>
                        </a>
                        <a href="profile.php" class="nav_link">
                            <i class='bx bx-user nav_icon'></i>
                            <span class="nav_name">Users</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class='bx bx-message-square-detail nav_icon'></i>
                            <span class="nav_name">Messages</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class='bx bx-bookmark nav_icon'></i>
                            <span class="nav_name">Bookmark</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class='bx bx-folder nav_icon'></i>
                            <span class="nav_name">Files</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
                            <span class="nav_name">Stats</span>
                        </a>
                    </div>
                </div> <a href="../php/utils/session.destroy.php?home=../../index.html" class="nav_link"> <i
                        class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>

            </nav>
        </aside>
        <!--Container Main start-->
        <div class="container pt-4 d-flex align-items-center justify-content-center">

            <!-- Start "Trip Finish" -->
            <div class="row container">
                <div class="col-5 d-flex flex-column align-items-start bgr-info bg-white">
                    <div class=" flex-column w-100 text-black ">
                        <img src="../../admin/assets/img/pengemudi.jpg" class="rounded mx-auto d-block" alt="Pengemudi"
                            width="170" height="170">
                        <div class="d-flex flex-column gap-0 ">
                            <p class="m-0 fs-4 text-center fw-bold my-3">Muhammad Ibrahim</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <i class="ri-phone-line"></i>
                                <p class="m-0 fs-7">083769784536</p>
                            </div>
                            <div class="d-flex gap-2 justify-content-center">
                                <i class="ri-car-fill"></i>
                                <p class="m-0 fs-7">DD 1456 KL</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-column w-100 text-black bg-white w-full mt-3">
                        <p class="fw-bold m-0 fs-5 fst-underline text-decoration-underline"
                            style="text-align: center; color: var(--primary-color-name) !important;">Detail Perjalanan
                        </p>
                        <div class="border border-1 p-2 mt-3 shadow-sm"
                            style="border-radius: 10px; border-color: var(--primary-color-name) !important;">
                            <p class="m-0"><strong>Dari:</strong> Makassar</p>
                            <p class="m-0"><strong>Ke:</strong> Pare-pare</p>
                            <p class="m-0"><strong>Jam Berangkat:</strong> 09:00</p>
                            <p class="m-0"><strong>Jam Tiba:</strong> 14:05</p>
                        </div>
                        <div class="mt-2 text-end fs-6">Total biaya: <strong>Rp. 120.000</strong></div>
                    </div>
                </div>

                <div
                    class="col-7 d-flex flex-column align-items-center justify-content-center bg-ilalin ilalin-info text-black">
                    <div>
                        <h3 class="display-7 fw-bold text-white text-center mb-3" style="text-wrap: balance;">Bagaimana
                            perjalananmu?</h3>
                        <h5 class="text-center text-white fs-5" style="opacity: 60%;">Masukkan Penilaian</h5>
                    </div>
                    <div class="d-flex flex-column gap-4 w-100 px-5 justify-content-center mt-3">
                        <div class="rating mx-auto">
                            <span class="star" data-value="1">★</span>
                            <span class="star" data-value="2">★</span>
                            <span class="star" data-value="3">★</span>
                            <span class="star" data-value="4">★</span>
                            <span class="star" data-value="5">★</span>
                        </div>
                        <div class="ulasan">
                            <form action="" method="post">
                                <div class="d-flex flex-column align-items-end">
                                    <input type="hidden" name="rating" id="rating-input" value="0">
                                    <div class="mb-3 w-100">
                                        <textarea class="form-control w-100 " id="ulasan" name="ulasan" rows="6"
                                            placeholder="Tulis ulasan Anda"></textarea>
                                    </div>
                                    <button type="submit" class="btn mb-3 ">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <!-- Edit "Trip Finish" -->
        <div class="d-flex flex-wrap position-relative">
        </div>
    </div>


    <!-- Rating -->
    <script>
    const stars = document.querySelectorAll('.star');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            stars.forEach((s) => s.classList.remove('active'));

            for (let i = 0; i <= index; i++) {
                stars[i].classList.add('active');
            }

        });
    });
    </script>
</body>

</html>