<?php
session_start();

$email = $_SESSION['email'];

include_once '../../controller/php/ilalin.php' ; 

if(isset($email)) { 

    // $ilalin = new IlalinApp(); 
    $profileController = new ProfileController(); 
    $userProfile=$profileController->getUserProfile($email);
    $profile = $userProfile;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tripsController = new TripController();
        
        // Check if the trip_id is provided in the POST request
        // If it not then assume user want to create a new trip_id and save to database
        if(!isset($_POST['trip_id'])) {
            header("Content-Type: application/json"); // Ensure the response is JSON formatted

            try {
                // Read the raw input data from the request body
                $rawData = file_get_contents("php://input");
            
                
                // Decode JSON into an associative array
                $data = json_decode($rawData, true);
                
                // Validate JSON decoding
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Invalid JSON format.");
                }
            
                // Append email from session if available
                if (isset($_SESSION['email'])) {
                    $data['email'] = $_SESSION['email']; // Add the email to the data array
                } else {
                    throw new Exception("Email not found in session.");
                }
            
                // Ensure all required fields are present
                $requiredFields = ['name', 'time', 'distance', 'startPoint', 'finishingPoint', 'status'];
                foreach ($requiredFields as $field) {
                    if (!isset($data[$field])) {
                        throw new Exception("Missing required field: $field");
                    }
                }
                
                // If validation passes, add the trip
                $tripId = $tripsController->addTrip($data);
               
                // Return a success response
                http_response_code(200); // 200 OK
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Trip added successfully',
                    'id' => $tripId
                ]);
            
            } catch (Exception $e) {
                // Handle errors and return a meaningful response
                http_response_code(400); // 400 Bad Request
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to add trip: ' . $e->getMessage()
                ]);
            } finally {
                exit(); // Ensure script execution is terminated after response
            }
        }

        // Check if the trip_id is provided in the POST request
        // If it set, assume that user wants to proceed with the trip
        if (isset($_POST['trip_id'])) {
            
            $trips = $tripsController->getTrips($_POST['trip_id']);
            
            if ($trips['email'] === $_SESSION['email']) {

                // Process payment information
                $il_util = new PaymentsUtils();
                echo json_encode($trips);

                //payment information
                $paymentId = uniqid('pay_', true);

                $total_payment = $il_util->formatCurrency($trips['total_payment']);
                
                $starting_point = json_decode($trips['start_point'], true);
                $finishing_point = json_decode($trips['finishing_point'], true);
                
                $driver = new Driver();
                $avaiable_driver = $driver->getAvaiableDriver();
                
                echo $avaiable_driver['driver_id'];

                $vehicle = new Vehicle();
                $driver_vehicle = $vehicle->getVehicleType($avaiable_driver['driver_id']);
      

                // Search for driver
                // update payment databse, add founded driver when payed
                // update trip status to 'paid'
                // add trip_id to user's trip history
                // add driver's information to user's profile

                //Run HTML Below Only When trip_id is SET and email is equal to current session of user.
?>

<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="images/logo/logo-ilalin.ico" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Vendor -->
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/profile.css">
    <title>iLalin</title>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>

</head>

<body>
    <div id="">
        <header>
            <div class="d-flex justify-content-between bg-white p-3">
                <a href="" class="nav_logo">
                    <span class="nav_logo-name fw-bold fs-3">iLalin</span>
                </a>
                <div class="d-flex flex gap-3 align-items-center">
                    <span class="text-primary fw-bold "><?= $profile['nama'] ?></span>
                    <div class="header_img">
                        <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                            alt="<?= $profile["nama"] ?>" style="width: 36px; border-radius: 100%; aspect-ratio: 1/1;">
                    </div>

                </div>
            </div>
        </header>
        <div id="snap-container"
            style="display: none; position: fixed; z-index: 9999; inset: 0px; place-items: center;backdrop-filter: brightness(50%);">
        </div>
        <div
            style="display: flex; flex-direction: column; justify-content: center; padding-top: 40px; max-width: 1000px; margin-inline: auto;">
            <h2>Detail Perjalanan Anda</h2>
            <div style="display: flex; justify-content:space-between; gap: 40px; margin-top: 40px;">
                <!-- Bagian penumpang -->
                <div
                    style="width: 50%; line-height: 0.7; border: 1px solid black; display: flex; flex-direction: column; gap: 1rem; padding: 1rem; border-radius: 10px;">
                    <p class="info-row"><span class="info-label"><strong>Nama:</strong></span> <span class="info-value"
                            data-user="fullname"><?= $userProfile['nama'] ?></span></p>
                    <p class="info-row"><span class="info-label"><strong>Nomor Telepon:</strong></span> <span
                            class="info-value" data-user="no_telepon"><?= $userProfile['nomor_telepon'] ?></span></p>
                    <p class="info-row"><span class="info-label"><strong>Titik Jemput:</strong></span> <span
                            class="info-value"
                            data-user="start_point"><?= $starting_point['formatted_address'] ?></span></p>
                    <p class="info-row"><span class="info-label"><strong>Tujuan:</strong></span> <span
                            class="info-value" data-user="end_point"><?= $finishing_point['formatted_address'] ?></span>
                    </p>
                    <p class="info-row"><span class="info-label"><strong>Jarak:</strong></span> <span class="info-value"
                            data-user="length"><?= $trips['distance'] ?> Km</span></p>
                </div>

                <!-- Bagian Supir -->
                <div
                    style="width: 50%; line-height: 0.7; border: 1px solid black; display: flex; gap: 1rem; padding: 1rem; border-radius: 10px;">
                    <div style="line-height: 0.5;">
                        <p style="font-weight: bold;">Driver</p>
                        <div style="margin-top: 2rem;">
                            <p style="font-size: 2em;" data-user="fullname_driver"><?= $avaiable_driver['name'] ?></p>
                            <p data-user="phone_driver"><?= $avaiable_driver['phone_number'] ?></p>
                        </div>
                        <div style="margin-top: 2rem;">
                            <p>Avanza</p>
                            <p>DD 1234 LL</p>
                        </div>
                    </div>
                    <div style="">
                        <img src="../../admin/assets/img/messages-2.jpg" alt="Foto Sopir" class="driver-photo">
                    </div>
                </div>
            </div>

            <div class="payment-section d-flex justify-content-between align-items-center"
                style="border: 1px solid black; border-radius: 10px; margin-top: 40px; padding: 10px;">
                <div>
                    <h3>Total Pembayaran</h3>
                    <p class="total-payment" id="payment_amount"><?= $total_payment ?></p>
                    <!-- Ukuran font diperbesar -->
                </div>
            </div>

            <div class="btn-container d-flex justify-content-end mt-3 gap-2">
                <button type="button" class="btn btn-danger" style="border-radius: 10px;" id="cancelBtn" data-order_id
                    disabled>Batal</button>
                <button type="button" class="btn btn-success" style="border-radius: 10px;"
                    id="pay-button">Bayar</button>
            </div>
        </div>
    </div>

    <input type="hidden" id="order_id" value="<?= $paymentId ?>">
    <input type="hidden" id="gross_amount" value="<?= $trips['total_payment'] ?>">
    <input type="hidden" id="passenger_id" value="<?= $userProfile['username'] ?>">
    <input type="hidden" id="passenger_email" value="<?= $userProfile['email'] ?>">
    <input type="hidden" id="passenger_fullname" value="<?= $userProfile['nama'] ?>">
    <input type="hidden" id="passenger_phone" value="<?= $userProfile['nomor_telepon'] ?>">
    <input type="hidden" id="passenger_address" value="<?= $userProfile['alamat'] ?>">
    <input type="hidden" id="driver_email" value="<?= $avaiable_driver['email'] ?>">
    <input type="hidden" id="driver_fullname" value="<?= $avaiable_driver['name'] ?>">
    <input type="hidden" id="driver_phone" value="<?= $avaiable_driver['phone_number'] ?>">
    <input type="hidden" id="vehicle_name" value="<?= $driver_vehicle['vehicle_name'] ?>">
    <input type="hidden" id="vehicle_plate_number" value="<?= $driver_vehicle['plate_number'] ?>">



    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-75iUAElAx67168zX"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    let token = null;
    payButton.addEventListener('click', async function() {
        if (!token) {
            const getToken = await fetch('../../controller/php/payment/prosesMidtrans.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "transaction_details": {
                        "order_id": document.getElementById("order_id").value,
                        "gross_amount": parseInt(document.getElementById("gross_amount")
                            .value)
                    },
                    "credit_card": {
                        "secure": true
                    },
                    "customer_details": {
                        "passenger_details": {
                            "usernames": document.getElementById("passenger_id").value,
                            "name": document.getElementById("passenger_fullname").value,
                            "email": document.getElementById("passenger_email").value,
                            "phone": document.getElementById("passenger_phone").value,
                            "address": document.getElementById("passenger_address").value,
                        },
                        "driver_details": {
                            "name": document.getElementById("driver_fullname").value,
                            "email": document.getElementById("driver_email").value,
                            "phone": document.getElementById("driver_phone").value,
                        },
                        "vehicle_details": {
                            "vehicle_name": document.getElementById("vehicle_name").value,
                            "plate_number": document.getElementById("vehicle_plate_number")
                                .value,
                        }
                    }


                })
            })


            token = await getToken.text();
        }
        const snapContainer = document.getElementById('snap-container');
        snapContainer.style.display = 'grid';

        const cancelBtn = document.getElementById('cancelBtn');

        window.snap.embed(token, {
            embedId: 'snap-container',
            onSuccess: function(result) {
                token = null;
                fetch(`gateway.php?token=${token}`).then(function(response) {
                    window.location.href = "../index.php"
                })
            },
            onPending: function(result) {
                const urlParams = new URLSearchParams(result)
                const url = "pembayaran.php?" + urlParams.toString();
                fetch(url)

                snapContainer.style.display = 'none';

                cancelBtn.removeAttribute('disabled')
                cancelBtn.dataset.order_id = result.order_id;
                cancelBtn.addEventListener('click', async function() {
                    const response = await fetch(
                        `../../controller/php/payment/prosesMidtrans.php?order_id=${result.order_id}`
                    )
                    if (response.ok) {
                        const data = await response
                            .json(); // Use json() since the response is a JSON object

                        console.log(data);
                        if (data.status_code === '200') {
                            alert("Payment cancelled!");
                            fetch("gateway.php?token=" + token).then(function(
                                response) {
                                window.location.href = "../index.php";
                            })
                        }
                    } else {
                        console.error('HTTP Error:', response.statusText);
                    }
                    cancelBtn.setAttribute('disabled', true);
                })
            },
            onError: function(result) {
                alert("payment failed!");
                console.log(result);
            },
            onClose: function(e) {
                fetch("gateway.php?token=" + token);
                snapContainer.style.display = 'none';
            }
        });
    });
    </script>



</body>

</html>

<?php
            }
        }
        
    }
       
    
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Should Destroy the session
        if(isset($_SESSION['snapToken']) && isset($_GET['token'])) {
            $snapToken = $_SESSION['snapToken'];
            $_SESSION['snapToken'] = null;
    
            echo $snapToken;
            exit();
        } else if (isset($_GET['order_id'])) {
            exit();
        }
    
    }
?>


<?php 
} else {
    header(header: "Location: ../auth/login.php");
    exit();
}
?>