<?php
session_start();

include '../php/database.php';
$email = $_SESSION['email'];

if(isset($email)) {
    $db = new Database();
    $profile = $db->fetch('users', '*', 'email = ?',[$email]);

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

    <!-- Leafet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="../css/tiny-slider.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="./css/sidebar.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="./css/dashboard/custom.css">

    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">
        <header class="header border-bottom shadow-sm" id="header" style="z-index: 999999;">
            <div class="header_toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="d-flex flex gap-3 align-items-center">
                <span class="ts-uppper"><?= $profile['nama'] ?></span>
                <div class="header_img">
                    <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                        alt="<?= $profile["nama"] ?>">
                </div>

            </div>
        </header>

        <aside class="l-navbar" id="nav-bar" style="z-index: 999999;">
            <nav class="nav">
                <div>
                    <a href="" class="nav_logo">
                        <i class="ri-side-bar-fill nav_logo-icon"></i>
                        <span class="nav_logo-name">iLalin</span>
                    </a>
                    <div class="nav_list">
                        <a href="index.php" class="nav_link active">
                            <i class="ri-dashboard-horizontal-line nav_icon"></i>
                            <span class="nav_name">Dashboard</span>
                        </a>
                        <a href="profile.php" class="nav_link">
                            <i class="ri-user-line nav_icon"></i>
                            <span class="nav_name">Users</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class="ri-message-2-line nav_icon"></i>
                            <span class="nav_name">Messages</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class="ri-settings-5-line nav_icon"></i>
                            <span class="nav_name">Settings</span>
                        </a>
                    </div>
                </div>
                <div>

                </div>
                <div>
                    <a href="../php/utils/session.destroy.php?home=../../auth/login.php" class="nav_link">
                        <i class="ri-switch-line nav_icon"></i>
                        <span class="nav_name">Switch Role</span>
                    </a>
                    <a href="../php/utils/session.destroy.php?home=../../auth/login.php" class="nav_link">
                        <i class="ri-logout-box-line nav_icon"></i>
                        <span class="nav_name">SignOut</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!--Container Main start-->
        <div class="p-5 d-flex flex-column">
            <!--  -->
            <div class="row justify-content-between mb-4 gap-sm-4 position-relative"
                style="z-index:5; transition:1s cubic-bezier(.68,.04,.14,.87);" id="greet">

                <!-- Mau Kemana? -->
                <div class="col-lg-8 p-0 ">
                    <div class="bg-ilalin text-white  p-5 shadow" style="border-radius: 1.5rem;">
                        <div class="d-flex gap-1 fs-4" style="color: var(--secondary-color-name);">
                            Halo <p class="ts-uppper fw-bold"><?= $_SESSION['username'] ?></p>
                        </div>
                        <div class="meta">
                            <div class="display-6 d-block fw-bold mb-4">Mau Ke Mana Hari Ini?</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div id="date-span" class="d-flex flex-column">
                                    <span id="date" class="bg-ilalin px-3 py-1 fs-7"
                                        style="background-color: hsla(158, 20%, 19%, 1); border-radius: 1.5rem; font-size: 12px;"></span>
                                    <span id="time" class="mt-2" style="font-size: 12px; margin-left: 5px;"></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Get Position -->
                                    <a onClick="showCurrentPosition();" style="cursor:pointer;"
                                        class="getCurrentLocationBtn" id="showCurrentPositionBtn"
                                        title="Lihat Lokasi Sekarang">
                                        <svg width="39" height="39" viewBox="0 0 39 39" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.125 1.625L21.1266 6.60077C27.0062 7.33468 31.6662 11.9951 32.3994 17.875H37.375V21.125L32.3993 21.1266C31.6654 27.0057 27.0057 31.6654 21.1266 32.3993L21.125 37.375H17.875V32.3994C11.9951 31.6662 7.33468 27.0062 6.60077 21.1266L1.625 21.125V17.875H6.60057C7.33382 11.9946 11.9946 7.33382 17.875 6.60057V1.625H21.125ZM19.5 9.75C14.1152 9.75 9.75 14.1152 9.75 19.5C9.75 24.8848 14.1152 29.25 19.5 29.25C24.8848 29.25 29.25 24.8848 29.25 19.5C29.25 14.1152 24.8848 9.75 19.5 9.75ZM19.5 16.25C21.295 16.25 22.75 17.705 22.75 19.5C22.75 21.295 21.295 22.75 19.5 22.75C17.705 22.75 16.25 21.295 16.25 19.5C16.25 17.705 17.705 16.25 19.5 16.25Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                    <a id="btn-route">
                                        <svg width="43" height="43" viewBox="0 0 43 43" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.16667 26.875V15.2292C7.16667 10.7764 10.7764 7.16667 15.2292 7.16667C19.682 7.16667 23.2917 10.7764 23.2917 15.2292V27.7708C23.2917 30.2446 25.2971 32.25 27.7708 32.25C30.2446 32.25 32.25 30.2446 32.25 27.7708V15.8191C30.1624 15.0813 28.6667 13.0903 28.6667 10.75C28.6667 7.78148 31.0731 5.375 34.0417 5.375C37.0103 5.375 39.4167 7.78148 39.4167 10.75C39.4167 13.0903 37.921 15.0813 35.8333 15.8191V27.7708C35.8333 32.2237 32.2237 35.8333 27.7708 35.8333C23.318 35.8333 19.7083 32.2237 19.7083 27.7708V15.2292C19.7083 12.7554 17.7029 10.75 15.2292 10.75C12.7554 10.75 10.75 12.7554 10.75 15.2292V26.875H16.125L8.95834 35.8333L1.79167 26.875H7.16667Z"
                                                fill="#F9BF29" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weather -->
                <div class="col-lg-3 bg-ilalin d-flex align-items-end position-relative "
                    style="border-radius: 1.5rem;">

                    <!-- bgilalin overlay -->
                    <span class="bg-ilalin shadow"
                        style="position:absolute; height: 100%; width:100vw; left:0; z-index:-1;border-radius: 1.5rem;"></span>

                    <div class="d-flex align-items-end text-white p-4 " id="weather-group">
                        <div class="">
                            <div class="weather_temp display-5 fw-bold d-flex">
                                34 <span class="degree "><i class="ri-circle-line fs-6"></i></span>
                            </div>
                            <div class="weatber_location">Makssar</div>
                        </div>
                        <div>
                            <span class="weather_icon">
                                <img src="./assets/weather/PartlyCloudy.svg" alt="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Routing -->
            <div class="position-fixed" id="routingForm"
                style="max-width:480px; z-index:999; transition:1s cubic-bezier(.68,.04,.14,.87); bottom: -100%; margin-bottom: -10px;">
                <div style="" class="d-flex flex-column align-items-center justify-content-center border border-4 border-primary
                    rounded rounded-5 p-5 pb-0 bg-white fs-7 ">
                    <div class="mb-3 w-100">
                        <div class="d-flex align-items-center gap-4">
                            <i class="ri-stop-large-fill fs-4 text-secondary"></i>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control p-0" id="inputTitikAwal" placeholder="">
                                <label for="inputTitikAwal">Titik Awal</label>
                            </div>
                            <a onClick="showCurrentPosition();" class="getCurrentLocationBtn">
                                <i class="ri-focus-3-line fs-3"></i>
                            </a>
                        </div>
                        <i class="ri-checkbox-blank-circle-fill fs-7"></i>
                        <div class="d-flex align-items-center gap-4">
                            <i class="ri-stop-large-fill fs-4 text-primary bx-rotate-270"></i>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="inputTitikAwal" placeholder="">
                                <label for="inputTitikAwal">Titik Awal</label>
                            </div>
                            <i class="ri-arrow-up-down-line fs-3"></i>
                        </div>


                    </div>
                    <div class="py-3 bg-primary text-center rounded rounded-5 text-white fw-bold mb-3 w-100">Detail
                        Perjalanan
                    </div>
                    <div class="pt-2 pb-4 px-4 border border-1 border-primary rounded rounded-5 w-100">
                        <div class="py-2 text-primary">
                            <div id="startpoint" class="fw-bold">Pinrang</div>
                            <div class="divider border border-1 border-secondary my-1"></div>
                            <div id="endpoint" class="fw-bold">Makassar</div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control border border-1 border-primary"
                                placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Catatan Perjalanan</label>
                        </div>
                        <div class="d-flex gap-2">
                            <a class="flex-grow-1 btn btn-outline-primary rounded rounded-5" id="cancelRouting">Batal
                            </a>
                            <div class="flex-grow-1 btn btn-primary rounded rounded-5">Proses</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Maps -->
            <div id="map" class="shadow position-fixed top-0" style=" inset: 0; transition: 1s all; ">

                <div id="map-overlay">
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Script -->
    <script src="script/dashboard/custom.js"></script>
    <script src="script/dashboard/weather.js"></script>
    <script src="script/sidebar.js"></script>

    <!-- Leafet -->
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <!-- MAP for Leafet -->
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
    <script src="script/dashboard/map.js"></script>

</body>

</html>

<?php 
} else {
    header("Location: ../auth/login.php");
    exit();
}
?>