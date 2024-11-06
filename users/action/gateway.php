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
        $rawData = file_get_contents("php://input");
        // Decode JSON into an associative array
        $data = json_decode($rawData, true);
        //update status payment
        if(isset($data['trip_id']) && isset($data['status'])) {

            $tripsController->updateTripStatus($data['trip_id'], $data['status']);
            $tripsController->updateTripDriver($data['trip_id'], $data['driver_id']);

            echo json_encode(['status' => 'success', 'message' => 'Status pembayaran berhasil diubah']);

            exit();
        }
        
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
                if($tripId) {
                    http_response_code(200); // 200 OK
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Trip added successfully',
                        'id' => $tripId
                    ]);
                }
            
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
                
                //payment information

                $total_payment = $il_util->formatCurrency($trips['total_payment']);
                
                $starting_point = json_decode($trips['start_point'], true);
                $finishing_point = json_decode($trips['finishing_point'], true);
                
                $driver = new Driver();
                $avaiable_driver = $driver->getAvaiableDriverAndCar();
                
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
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap");
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../tailwind.config.js"></script>

    <title>iLalin</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

    </style>
    <title>Pembayaran</title>

</head>

<body>
    <div id="">
        <header>
            <div class="flex justify-between w-full bg-white p-3 border-b-2 border-black">
                <a href="" class="nav_logo">
                    <span class="nav_logo-name fw-bold text-3xl text-primary font-bold">iLalin</span>
                </a>
                <div class="flex gap-3 items-center">
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
            <h2 class="text-5xl font-bold ">Detail Perjalanan Anda</h2>
            <div class="flex w-full justify-between gap-8 mt-8">
                <!-- Bagian penumpang -->
                <div class="flex flex-col gap-4 flex-1">
                    <div class="border-2 border-black py-2 px-4 flex justify-between items-center rounded">
                        <span class="info-label"><strong class="font-light">Nama</strong></span>
                        <span class="info-value" data-user="fullname"><?= $userProfile['nama'] ?></span>
                    </div>
                    <div class="border-2 border-black py-2 px-4 flex justify-between items-center rounded">
                        <span class="info-label"><strong class="font-light">Nomor Telepon</strong></span>
                        <span class="info-value" data-user="fullname"><?= $userProfile['nomor_telepon'] ?></span>
                    </div>

                    <div class="border-2 border-black flex flex-col py-3 pl-8 pr-2 rounded gap-1 relative">
                        <span class="bg-yellow-500 absolute top-0 bottom-0 w-4 left-0 block"></span>
                        <span class="info-label"><strong class="font-light text-black/80">Titik Jemput</strong></span>
                        <span class="text-xl"><?= $starting_point['name'] ?></span>
                        <span class="text-black/80"
                            data-user="start_point text-sm"><?= $starting_point['formatted_address'] ?></span>
                    </div>
                    <div class="border-2 border-black flex flex-col py-3 pl-8 pr-2 rounded gap-1 relative">
                        <span class="bg-primary absolute top-0 bottom-0 w-4 left-0 block"></span>
                        <span class="info-label"><strong class="font-light text-black/80">Tujuan</strong></span>
                        <span class="text-xl"><?= $finishing_point['name'] ?></span>
                        <span class="text-black/80 text-sm"
                            data-user="end_point"><?= $finishing_point['formatted_address'] ?></span>
                    </div>
                    <div class="flex justify-end gap-6">
                        <div class="flex justify-center items-center flex-col">
                            <div>
                                <i class="ri-pin-distance-line"></i>
                                <span class="info-label"><strong class="font-normal">Jarak</strong></span>
                            </div>
                            <span class="mt-1 text-xl font-bold" data-user="length"><?= $trips['distance'] ?> Km</span>
                        </div>
                        <div class="flex justify-center items-center flex-col">
                            <div class="">
                                <i class="ri-timer-line"></i>
                                <span class="info-label"><strong class="font-normal">Durasi</strong></span>
                            </div>
                            <span class="mt-1 text-xl font-bold" data-user="length"><?= $trips['time'] ?>min</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Supir -->
                <div class="flex flex-col gap-4 flex-1">
                    <div class=" flex justify-between rounded">
                        <div class="flex flex-col gap-4 py-3 px-5 border-2 border-black flex-1 bg-emerald-300 rounded">
                            <p class="px-2 bg-slate-200 text-primary text-md w-fit rounded">Driver</p>
                            <div class="">
                                <p class="font-bold text-3xl" data-user="fullname_driver">
                                    <?= $avaiable_driver['name'] ?>
                                </p>
                                <a target="_blank"
                                    href="https://wa.me/<?= $avaiable_driver['phone_number']?>?text=Saya%20ingin%20melakukan%20perjalanan"
                                    data-user="phone_driver" class="mt-1 font-medium text-primary">

                                    <i class="ri-whatsapp-line mr-1"> </i><?= $avaiable_driver['phone_number'] ?>
                                </a>
                            </div>
                            <div class="">
                                <p class="font-light text-xl text-emerald-800"><?= $driver_vehicle['vehicle_name'] ?>
                                </p>
                                <p class="font-bold text-xl text-primary">
                                    <?= $driver_vehicle['plate_number'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="aspect-square h-full ">

                            <img src="<?= strpos($avaiable_driver['profile_image'], 'data:image') === 0 ? $avaiable_driver['profile_image'] : 'data:image/jpeg;base64,' . $avaiable_driver['profile_image'] ?>"
                                alt="Foto Sopir" class="h-full aspect-square">
                        </div>
                    </div>
                    <div class="border-black border-2 pb-2 pr-4 flex justify-between  rounded">
                        <div class="flex flex-col justify-end p-4">
                            <div class="flex items-center gap-2 text-primary">
                                <i class="ri-wallet-line"></i>
                                <span>Status</span>
                            </div>
                            <span
                                class="text-xl text-yellow-500 bg-slate-200 rounded py-1 font-semibold px-4 mt-1"><?=$trips['status']?></span>
                        </div>
                        <div class="min-h-[100px] flex flex-col items-end justify-end mb-3">
                            <h3 class="text-xl font-normal text-black/80">Total Pembayaran</h3>
                            <p class="total-payment text-4xl text-primary font-bold mt-2" id="payment_amount">
                                <?= $total_payment ?></p>
                        </div>
                    </div>

                    <div class="flex gap-2 w-full justify-end">
                        <?php if($trips['status'] === 'ongoing'): ?>
                        <button type="button"
                            class="py-2 px-5 bg-rose-500 text-white hover:bg-rose-300 hover:text-rose-600 rounded"
                            id="cancelBtn" data-order_id>Kembali</button>
                        <?php else: ?>
                        <button type="button"
                            class="py-2 px-5 bg-rose-500 text-white hover:bg-rose-300 hover:text-rose-600 rounded"
                            id="cancelBtn" data-order_id>Kembali</button>
                        <button type="button"
                            class="py-2 px-5 bg-primary text-white hover:bg-emerald-300 hover:text-emerald-600 rounded"
                            id="pay-button">Bayar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>




        </div>
    </div>

    <input type="hidden" id="trip_id" value="<?= $_POST['trip_id'] ?>">
    <input type="hidden" id="order_id" value="<?= $trips['order_id'] ?>">
    <input type="hidden" id="gross_amount" value="<?= $trips['total_payment'] ?>">
    <input type="hidden" id="passenger_id" value="<?= $userProfile['username'] ?>">
    <input type="hidden" id="passenger_email" value="<?= $userProfile['email'] ?>">
    <input type="hidden" id="passenger_fullname" value="<?= $userProfile['nama'] ?>">
    <input type="hidden" id="passenger_phone" value="<?= $userProfile['nomor_telepon'] ?>">
    <input type="hidden" id="passenger_address" value="<?= $userProfile['alamat'] ?>">
    <input type="hidden" id="driver_id" value="<?= $avaiable_driver['driver_id'] ?>">
    <input type="hidden" id="driver_email" value="<?= $avaiable_driver['email'] ?>">
    <input type="hidden" id="driver_fullname" value="<?= $avaiable_driver['name'] ?>">
    <input type="hidden" id="driver_phone" value="<?= $avaiable_driver['phone_number'] ?>">
    <input type="hidden" id="vehicle_name" value="<?= $driver_vehicle['vehicle_name'] ?>">
    <input type="hidden" id="vehicle_plate_number" value="<?= $driver_vehicle['plate_number'] ?>">


    <!-- PopUp Alert -->


    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-75iUAElAx67168zX"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');

    const cancelBtn = document.getElementById('cancelBtn');

    function initialCancelBtn(e) {
        window.location.href =
            "../index.php"
        console.log("awd")
    }
    cancelBtn.addEventListener("click", initialCancelBtn)

    let token = null;
    async function handlePayment() {
        //check if current user is already had pending payment or not


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
                            "address": document.getElementById("passenger_address")
                                .value,
                        },
                        "driver_details": {
                            "name": document.getElementById("driver_fullname").value,
                            "email": document.getElementById("driver_email").value,
                            "phone": document.getElementById("driver_phone").value,
                        },
                        "vehicle_details": {
                            "vehicle_name": document.getElementById("vehicle_name")
                                .value,
                            "plate_number": document.getElementById(
                                    "vehicle_plate_number")
                                .value,
                        }
                    }


                })
            })


            token = await getToken.text();
        }
        const snapContainer = document.getElementById('snap-container');
        snapContainer.style.display = 'grid';

        function enableCancelPayment(result) {

            async function handleCancelPayment() {
                const response = await fetch(
                    `../../controller/php/payment/prosesMidtrans.php?order_id=${result.order_id}`
                )
                if (response.ok) {
                    const data = await response
                        .json(); // Use json() since the response is a JSON object

                    if (data.status_code === '200') {
                        fetch("gateway.php?token=" + token).then(async function(
                            response) {
                            const trip_id = document.getElementById(
                                "trip_id").value
                            const updatePaymentStatus = await fetch(
                                `gateway.php`, {
                                    method: 'POST',
                                    body: JSON.stringify({
                                        trip_id: trip_id,
                                        status: "cancelled",
                                        driver_id: document
                                            .getElementById(
                                                "driver_id"
                                            )
                                            .value
                                    })
                                })

                            const paymentStatusRespons =
                                await updatePaymentStatus
                                .json()

                            if (paymentStatusRespons.status ==
                                'success') {


                                document.body.innerHTML += `
                                    <div class="bg-red-50 border-s-4 border-red-500 p-4 dark:bg-red-800/30 fixed bottom-0 mb-4 ml-4" role="alert"
                                        tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <!-- Icon -->
                                                <span
                                                    class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M18 6 6 18"></path>
                                                        <path d="m6 6 12 12"></path>
                                                    </svg>
                                                </span>
                                                <!-- End Icon -->
                                            </div>
                                            <div class="ms-3">
                                                <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold dark:text-white">
                                                    Berhasil!
                                                </h3>
                                                <p class="text-sm text-gray-700 dark:text-neutral-400">
                                                    Proses Pembayaran Dibatalkan.
                                                </p>
                                            </div>
                                        </div>
                                    </div>                      
                                    `

                                setTimeout(() => {
                                    window.location.href =
                                        "../index.php"
                                }, 3000)
                            }
                        })
                    }
                } else {
                    console.error('HTTP Error:', response.statusText);
                }
                cancelBtn.setAttribute('disabled', true);
            }

            cancelBtn.removeEventListener("click", initialCancelBtn)

            cancelBtn.innerText = "Batalkan Perjalanan"
            cancelBtn.dataset.order_id = result.order_id;
            cancelBtn.addEventListener('click', handleCancelPayment)

        }

        window.snap.embed(token, {
            embedId: 'snap-container',
            onSuccess: async function(result) {
                token = null;
                //Clear previous payments using token
                const clearToken = await fetch(`gateway.php?token=${token}action=clear`)
                if (clearToken.status == 200) {
                    const trip_id = document.getElementById("trip_id").value

                    // Update database by adding driver information
                    const updatePaymentStatus = await fetch(
                        `gateway.php`, {
                            method: 'POST',
                            body: JSON.stringify({
                                trip_id: trip_id,
                                status: "ongoing",
                                driver_id: document.getElementById("driver_id")
                                    .value
                            })
                        })

                    const paymentStatusRespons = await updatePaymentStatus.json()

                    console.log(paymentStatusRespons)
                    if (paymentStatusRespons.status == 'success') {
                        window.location.href = "../index.php"
                    }

                }
            },
            onPending: function(result) {
                const urlParams = new URLSearchParams(result)
                const url = "pembayaran.php?" + urlParams.toString();
                fetch(url)

                snapContainer.style.display = 'none';

                enableCancelPayment(result)

            },
            onError: function(result) {
                alert("payment failed!");
                alert(result);
                window.location.href =
                    "../index.php"
            },
            onClose: function(e) {
                console.log("close")
                fetch("gateway.php?token=" + token);
                snapContainer.style.display = 'none';
            }
        });
    }
    payButton.addEventListener('click', handlePayment);
    </script>



</body>

</html>

<?php
            }
        }
        
    }
       
    
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        if(isset($_GET['action']) && isset($_GET['token'])) {
            switch ($_GET['action']) {
                case 'clear':
                    $_SESSION['snapToken'] = null;
                    break;
                case 'set_token':
                    $_SESSION['snapToken'] = null;
                    break;
                default:
                    echo 'Failed to call action: ' . $_GET['action'] ;
                    break;
            }
            exit();
        }
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