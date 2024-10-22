<?php
session_start();

$active_page = "user_settings";
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
        <?php
           
            include_once './components/header.php';
        ?>

        <!--Container Main start-->
        <div class="p-5 d-flex flex-column">
            <h1 class="my-4 fw-bold">Settings</h1>
        </div>

        <!-- Custom Script -->
        <script src="script/sidebar.js"></script>


</body>

</html>

<?php 
} else {
    header("Location: ../auth/login.php");
    exit();
}
?>