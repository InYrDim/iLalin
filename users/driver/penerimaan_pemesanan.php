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

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/dashboard/custom.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .header,
    .l-navbar {
        background-color: #3b5d50;
        color: #ffffff;
    }

    .profile-section {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .profile-section img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .username {
        margin-right: 10px;
        color: #ffffff;
        font-weight: bold;
    }

    /* Order Section */
    .order-section {
        margin-left: 70px;
        /* Adjusted for sidebar */
        padding: 20px;
    }

    .order-card {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .order-details {
        margin-bottom: 15px;
    }

    .accept-btn,
    .reject-btn {
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 5px;
        margin-right: 5px;
    }

    .accept-btn {
        background-color: #52796F;
        border-color: #52796F;
        color: white;
    }

    .accept-btn:hover {
        background-color: #354F52;
    }

    .reject-btn {
        background-color: #F94144;
        border-color: #F94144;
        color: white;
    }

    .reject-btn:hover {
        background-color: #D62828;
    }

    .map-container {
        width: 100%;
        height: 300px;
        background-color: #f0f0f0;
        margin-bottom: 15px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 2px dashed #ccc;
    }

    .contact-section {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .contact-btn {
        background-color: #3b5d50;
        color: #ffffff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .contact-btn:hover {
        background-color: #2b4c3d;
    }

    h2 {
        color: #354F52;
        font-weight: bold;
        margin-bottom: 20px;
    }
    </style>
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

        <!-- Container Main start -->
        <div class="p-5 d-flex flex-column">
            <div class="order-section">
                <h2>New Order Request</h2>

                <!-- Order Card -->
                <div class="order-card">
                    <div class="order-details">
                        <strong>Pickup Location:</strong> Jl. Mawar No. 5<br>
                        <strong>Destination:</strong> Jl. Melati No. 10<br>
                        <strong>Estimated Cost:</strong> 100.000<br>
                        <strong>Payment Method:</strong> Cash<br>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="map-container">
                        <i class="bi bi-map"></i>
                        <span>Map Preview</span>
                    </div>

                    <div class="contact-section">
                        <div>
                            <strong>Requester:</strong> John Doe<br>
                            <strong>Contact:</strong> 0812-3456-7890
                        </div>
                        <div>
                            <button class="contact-btn" onclick="callRequester()">Call</button>
                            <button class="contact-btn" onclick="chatRequester()">Chat</button>
                        </div>
                    </div>

                    <div>
                        <button class="accept-btn">Accept</button>
                        <button class="reject-btn">Reject</button>
                    </div>
                </div>
                <!-- End of Order Card -->

                <!-- Repeat Order Card as needed -->
            </div>
        </div>
        <!-- Container Main end -->
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tiny-slider.js"></script>
    <script src="../js/leaflet.js"></script>
    <script src="../js/app.js"></script>
</body>

</html>

<?php
} else {
    header('Location: ../auth/login.php');
}
?>