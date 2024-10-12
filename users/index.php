<?php
session_start();

$active_page = "dashboard";
include '../controller/php/database.php';
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
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <script src="../assets/vendor/tailwind/tailwindcss" defer></script>

    <!-- Leafet -->
    <link rel="stylesheet" href="../assets/vendor/leaflet/leaflet.css" />
    <link rel="stylesheet" href="../assets/vendor/leaflet-routing-machine/leaflet-routing-machine.css" />

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="./css/sidebar.css" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/leaflet-geocoder/Control.Geocoder.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="./css/dashboard/custom.css">
    <style>
    .inputRouteContainer {
        margin-bottom: 1rem;
    }

    #routingForm .placeOption:hover {
        background-color: var(--primary-color-name);
        color: white;
    }
    </style>
    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">
        <?php
           
            include_once './components/header.php';
        ?>

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
                                    <a style="cursor:pointer;" class="getCurrentLocationBtn" id="showCurrentPositionBtn"
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
                            <div class="form-floating w-100 position-relative">
                                <input type="text" class="form-control" id="inputTitikAwal" placeholder="">
                                <label for="inputTitikAwal">Titik Awal</label>
                                <!-- <div class="position-absolute w-100 -bottom-100 mt-1" style="z-index: 10;"
                                    aria-label="search result">
                                    <div class="flex flex-column border-1 border border-primary rounded bg-white shadow white"
                                        id="search-result-options">
                                        <div class="py-2 px-3 border border-bottom-1 lh-sm placeOption">Option<span
                                                class="d-block opacity-75" style="font-size: .8rem;">auvayudvaud</span>
                                        </div>
                                        <div class="py-2 px-1 border border-bottom-1">opt1</div>
                                        <div class="py-2 px-1 border border-bottom-1">opt1</div>
                                    </div>
                                </div> -->
                            </div>

                            <a onClick="showCurrentPosition();" class="getCurrentLocationBtn">
                                <i class="ri-focus-3-line fs-3"></i>
                            </a>
                        </div>
                        <i class="ri-checkbox-blank-circle-fill fs-7"></i>
                        <div class="d-flex align-items-center gap-4">
                            <i class="ri-stop-large-fill fs-4 text-primary bx-rotate-270"></i>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="inputTitikAkhir" placeholder="">
                                <label for="inputTitikAkhir">Titik Akhir</label>
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
                            <a class="flex-grow-1 btn btn-primary rounded rounded-5" id="processRouting">Proses</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maps -->
            <div id="ilalinMap" class="shadow position-fixed top-0" style=" inset: 0; transition: 1s all; ">

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
    <script src="../assets/vendor/leaflet/leaflet.js"></script>
    <script src="../assets/vendor/leaflet-routing-machine/leaflet-routing-machine.min.js"></script>
    <script src="../assets/vendor/leaflet-geocoder/Control.Geocoder.js"></script>

    <!-- MAP for Leafet -->
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
    <script src="script/dashboard/map_class.js"></script>

</body>

</html>

<?php 
} else {
    header("Location: ../auth/login.php");
    exit();
}
?>