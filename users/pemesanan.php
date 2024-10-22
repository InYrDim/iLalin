<?php
session_start();
$active_page = "dashboard";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if the data is set
    if (isset($data["routeData"])) {
        // Return a response
        $_SESSION['routeData'] = $data["routeData"];
        echo json_encode(['status' => 'success', 'message' => 'Data stored in session']);
        exit();
    } else {
        // Return an error response
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
   
    include '../controller/php/database.php';
    $email = $_SESSION['email'];

    if(isset($email)) {
        $db = new Database();
        $profile = $db->fetch('users', '*', 'email = ?',[$email]);
        $avaiable_driver = $db->fetch('users', '*', 'peran = ?', ["pengemudi"]);

        echo "<br>route: ";
        var_dump($_SESSION['routeData']);
        
        echo "<br><br>pengguna: ";
        var_dump($profile);

        echo "<br>avaiable driver: ";
        var_dump($avaiable_driver);
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

<?php include_once './components/header.php'; ?>

</div>
<h1>Session Data</h1>
Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae ad necessitatibus explicabo excepturi sint ut nihil, sed illum aliquam unde provident facere placeat reiciendis, quibusdam fuga consequuntur, quas fugiat voluptatum!


    <!-- Custom Script -->
    <script src="script/dashboard/custom.js"></script>
    <script src="script/dashboard/weather.js"></script>
    <script src="script/sidebar.js"></script>

    <script>

    </script>

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

}
?>