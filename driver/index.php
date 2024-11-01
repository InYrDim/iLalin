<?php
session_start();

$active_page = "dashboard";
include '../../controller/php/database.php';
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
    <link rel="shortcut icon" href="../../images/logo/logo-ilalin.ico" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Vendor -->
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <script src="../../assets/vendor/tailwind/tailwindcss" defer></script>

    <!-- Leafet -->
    <link rel="stylesheet" href="../../assets/vendor/leaflet/leaflet.css" />
    <link rel="stylesheet" href="../../assets/vendor/leaflet-routing-machine/leaflet-routing-machine.css" />

    <!-- Bootstrap CSS -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="../../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href="../css/sidebar.css" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/vendor/leaflet-geocoder/Control.Geocoder.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="./css/dashboard/custom.css">
    <style>
    .inputRouteContainer {
        margin-bottom: 1rem;
    }

    .search-results-container {
        max-height: 120px;
        overflow-y: scroll;
    }

    #routingForm .placeOption:hover {
        background-color: var(--primary-color-name);
        color: white;
    }

    .custom-input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }

    .start-icon {
        left: 10px;
    }

    .end-icon {
        right: 10px;
    }
    </style>
    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">
    <header class=" header border-bottom shadow-sm" id="header" style="z-index: 999999;">
        <div class="header_toggle">
            <i class="ri-menu-fold-4-line" id="header-toggle"></i>
        </div>
        <div class="d-flex flex gap-3 align-items-center">
            <span class="ts-uppper text-primary fw-bold"><?= $profile['nama'] ?></span>
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
                    <a href="index.php" class="nav_link active ">
                        <i class="ri-dashboard-horizontal-line nav_icon"></i>
                        <span class="nav_name ">Dashboard</span>
                    </a>
                    <a href="profil_pengemudi.php" class="nav_link ">
                        <i class="ri-user-line nav_icon"></i>
                        <span class="nav_name">Users</span>
                    </a>
                    <a href="informasi_pemesanan.php" class="nav_link ">
                        <i class="ri-notification-line nav_icon"></i>
                        <span class="nav_name">Messages</span>
                    </a>
                    <a href="proses_perjalanan.php" class="nav_link ">
                        <i class="ri-map-pin-user-fill nav_icon"></i>
                        <span class="nav_name">Messages</span>
                    </a>
                  
                </div>
            </div>
            <div>

            </div>

            <div>
                <a href="../../controller/php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                    <i class="ri-switch-line nav_icon"></i>
                    <span class="nav_name">Switch Role</span>
                </a>

                <!-- Redirect To Login Form -->
                <a href="../../controller/php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                    <i class="ri-logout-box-line nav_icon"></i>
                    <span class="nav_name">SignOut</span>
                </a>
            </div>
        </nav>
    </aside>

        <!--Container Main start-->
        <div class="p-5 d-flex flex-column">
           
        <div class="container">
        <div class="car-image">
    <img id="carImage" src="https://example.com/car-image.jpg" alt="Mobil">
    <input type="file" id="carPhotoInput" style="display: none;" accept="image/*" onchange="previewCarPhoto(event)">
    <button class="upload-button" onclick="document.getElementById('carPhotoInput').click()">Unggah Foto Mobil</button>
</div>

<div class="info-container">
    <div class="info-box vehicle-info">
        <h3>Informasi Kendaraan</h3>
        <p><strong>Model:</strong> Toyota Camry</p>
        <p><strong>Plat Nomor:</strong> ABC1234</p>
        <p><strong>Status:</strong> Tersedia</p>
        <div class="rating">
            <strong>Rating:</strong> ★★★★☆ (4.5)
        </div>
    </div>
    
    <div class="info-box driver-info">
        <h3>Informasi Sopir</h3>
        <img id="driverImage" src="https://example.com/driver-photo.jpg" alt="Sopir">
        <input type="file" id="driverPhotoInput" style="display: none;" accept="image/*" onchange="previewDriverPhoto(event)">
        <p><strong>Nama:</strong> John Doe</p>
        <p><strong>Telepon:</strong> 081234567890</p>
        <p><strong>Pengalaman:</strong> 5 tahun</p>
        <button class="edit-button" onclick="document.getElementById('driverPhotoInput').click()">Edit Foto Profil</button>
    </div>
    
    <div class="info-box income-info">
        <h3>Informasi Pemasukan</h3>
        <p><strong>Total Pendapatan:</strong> $1500</p>
        <p><strong>Rata-rata Harian:</strong> $50</p>
        <p><strong>Pembayaran Tertunda:</strong> $200</p>
        <p><strong>Perjalanan Selesai:</strong> 150</p>
        <p><strong>Umpan Balik:</strong> "Pendapatan konsisten setiap minggu."</p>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e8f5e9;
        margin: 0;
        padding: 20px;
    }

    .car-image {
        text-align: center;
        margin-bottom: 20px;
    }

    #carImage {
        width: 100%;
        max-width: 400px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .upload-button {
        background-color: #3b5d50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: bold;
    }

    .upload-button:hover {
        background-color: #2a3c3b;
    }

    .info-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .info-box {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .info-box h3 {
        color: #3b5d50;
        margin-bottom: 15px;
        text-align: center;
    }

    .info-box img {
        width: 100%;
        max-width: 100px;
        border-radius: 50%;
        margin: 10px auto;
        display: block;
    }

    .edit-button {
        background-color: #3b5d50;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: bold;
        display: block;
        margin: 10px auto;
    }

    .edit-button:hover {
        background-color: #2a3c3b;
    }
</style>

</div>

    <!-- Custom Script -->
    <script src="../script/dashboard/custom.js"></script>
    <script src="../script/dashboard/weather.js"></script>
    <script src="../script/sidebar.js"></script>

    <script>

    </script>

    <!-- Leafet -->
    <script src="../assets/vendor/leaflet/leaflet.js"></script>
    <script src="../assets/vendor/leaflet-routing-machine/leaflet-routing-machine.min.js"></script>
    <script src="../assets/vendor/leaflet-geocoder/Control.Geocoder.js"></script>

    <!-- MAP for Leafet -->
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
    <script src="s../cript/dashboard/map_class.js"></script>

</body>

</html>

<?php 
} else {
    header("Location: ../auth/login.php");
    exit();
}
?>