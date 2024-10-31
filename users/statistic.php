<?php session_start(); 
$active_page="statistic" ; 
$email=$_SESSION['email'];
    include_once '../controller/php/ilalin.php' ; 
    if(isset($email)) { 
        $ilalin = new ProfileController(); 
        $userProfile=$ilalin->getUserProfile($email);

        $trips = new TripController();
        $userTrips = $trips->getTripsByEmail($email);
        

    ?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="../images/logo/logo-ilalin.ico" />

    <meta name="description" content="" />

    <!-- Vendor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.4.0/remixicon.min.css"
        integrity="sha512-6sfYTBLNjOZhwJ5g/J0529qHqIdXxO1BycUHd1LIJjEzVCzX8cHtoXDgd+ylrqCl/OZM/RMDgkn2Dd41lJsJjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./css/sidebar.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../tailwind.config.js"></script>

    <!-- Bootstrap CSS -->
    <link href="../assets/css/style.css" rel="stylesheet" />

    <!-- custom css -->
    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">
        <!-- Header Main start-->
        <div>
            <header class="header border-bottom shadow-sm" id="header" style="z-index: 999999;">
                <div class="header_toggle">
                    <i class="ri-menu-fold-4-line" id="header-toggle"></i>
                </div>
                <div class="flex gap-3 items-center">
                    <span class="ts-uppper text-primary font-bold"><?= $userProfile['username'] ?></span>
                    <div class="header_img">
                        <img src="<?= strpos($userProfile['profile_image'], 'data:image') === 0 ? $userProfile['profile_image'] : 'data:image/jpeg;base64,' . $userProfile['profile_image'] ?>"
                            alt="<?= $userProfile["nama"] ?>">
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
                            <a href="index.php" class="nav_link">
                                <i class="ri-dashboard-horizontal-line nav_icon"></i>
                                <span class="nav_name ">Dashboard</span>
                            </a>
                            <a href="profile.php" class="nav_link">
                                <i class="ri-user-line nav_icon"></i>
                                <span class="nav_name">Users</span>
                            </a>
                            <a href="statistic.php" class="nav_link active">
                                <i class="ri-bar-chart-grouped-line"></i>
                                <span class="nav_name">Statistic</span>
                            </a>
                            <a href="user_settings.php" class="nav_link ">
                                <i class="ri-settings-5-line nav_icon"></i>
                                <span class="nav_name">Settings</span>
                            </a>
                        </div>
                    </div>
                    <div>

                    </div>

                    <div>
                        <a href="../controller/php/utils/session.destroy.php?home=../../../auth/login.php"
                            class="nav_link">
                            <i class="ri-switch-line nav_icon"></i>
                            <span class="nav_name">Switch Role</span>
                        </a>

                        <!-- Redirect To Login Form -->
                        <a href="../controller/php/utils/session.destroy.php?home=../../../auth/login.php"
                            class="nav_link">
                            <i class="ri-logout-box-line nav_icon"></i>
                            <span class="nav_name">SignOut</span>
                        </a>
                    </div>
                </nav>
            </aside>
        </div>

        <!--Container Main start-->
        <div class="mt-20 p-5 flex flex-col">
            <!-- Code Start Here -->

            <h1 class="my-2 text-primary opacity-50">Statistik</h1>

            <div>
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <caption
                                        class="py-2 text-start text-primary dark:text-neutral-500 text-xl font-semibold mb-1">
                                        Transaksi Anda</caption>
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Titik Awal</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Tujuan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Driver</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Phone</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Jarak (KM)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Tanggal</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">

                                        <?php                             
                                        if(is_array($userTrips)) {
                                            foreach($userTrips as $trip) {
                                                $startData = json_decode($trip['start_point'], true);
                                                $endData = json_decode($trip['finishing_point'], true);
                                                
                                                $driver = new Driver();
                                                $driverDetails = $driver->getDriverById($trip['driver_id']);
                                                ?>
                                        <tr>
                                            <!-- Starting Point -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                <?= $startData['name'] ?></td>

                                            <!-- Finsihing Point -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                <?= $endData['name'] ?></td>

                                            <!-- Driver name, if empty pass '-' symbol -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                <?= !empty($driverDetails['name']) ? $driverDetails['name'] : '-' ?>
                                            </td>

                                            <!-- Phone number, if empty pass '-' symbol -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                <?php if(!empty($driverDetails['phone_number'])): ?>
                                                <a target="_blank" class="underline"
                                                    href="https://wa.me/<?= $driverDetails['phone_number']?>?">
                                                    <i class="ri-whatsapp-line"></i>
                                                    <?=$driverDetails['phone_number']?>
                                                </a>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>

                                            <!-- Distance, in km -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                <?= number_format(floatval($trip['distance']), 0, '.', '') ?></td>
                                            </td>

                                            <!-- Trip Status -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                <p
                                                    class="w-fit px-2 py-1 rounded sm
                                                            <?= $trip['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' ?>
                                                            <?= $trip['status'] === 'ongoing' ? 'bg-blue-100 text-blue-700' : '' ?>
                                                            <?= $trip['status'] === 'completed' ? 'bg-green-100 text-green-700' : '' ?>
                                                            <?= $trip['status'] === 'cancelled' ? 'bg-red-100 text-red-700' : '' ?>">
                                                    <?= $trip['status'] ?>
                                                </p>
                                            </td>

                                            <!-- Trip Date -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                <?= $trip['created_at'] ?></td>

                                            <!-- Trip Action -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">

                                                <span class="flex gap-2">

                                                    <!-- Ongoing status:
                                                     - Passenger can canceling trip, without refunding
                                                    -->
                                                    <?php if ($trip['status'] === 'ongoing'):?>
                                                    <button
                                                        onclick="cancelProcessingTrip('<?= $trip['order_id']?>', '<?= $trip['trip_id']?>', '<?= $trip['driver_id']?>')"
                                                        class="text-red-100 px-3 py-1 bg-red-500 rounded">Batal</button>
                                                    <!-- Script for above button -->
                                                    <script>
                                                    async function cancelProcessingTrip(order_id, trip_id, driver_id) {

                                                        const userConfirm = confirm(
                                                            'Yakin membatalkan perjalanan?');
                                                        if (!userConfirm) return;

                                                        // 1. Get The Transaction First
                                                        // 2. Refunding the Transaction using transaction id that was previously get from transaction
                                                        // 3. Update the Transaction status on database
                                                        try {

                                                            const refundResponse = await fetch(
                                                                `../controller/php/paymentHandler.php`, {
                                                                    method: 'POST',
                                                                    body: JSON.stringify({
                                                                        action: 'refundPayment',
                                                                        order_id: order_id,
                                                                    })
                                                                }
                                                            )
                                                            const refundData = await refundResponse.json();
                                                            console.log(refundResponse);

                                                            // using || refundResponse.status == "200" to hanlder just for sanbox midtrans
                                                            // for production, remove it
                                                            if (refundData.status_code === '200' || refundResponse
                                                                .status == "200") {
                                                                // refund successful
                                                                alert('Pembatalan trip berhasil');

                                                                // Update canceling on databse then update trip status in database
                                                                const updatePaymentStatus = fetch(
                                                                        `../controller/php/tripsHandler.php`, {
                                                                            method: 'POST',
                                                                            body: JSON.stringify({
                                                                                action: 'updateTripStatus',
                                                                                trip_id: trip_id,
                                                                                status: "cancelled",
                                                                                clearToken: "yes"
                                                                            })
                                                                        })
                                                                    .then(resp => resp.json())
                                                                    .then(data => {

                                                                        document.body.innerHTML += `    <!-- Cancel Alert Componet -->
    <div id="alert-modal" tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="py-10 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Trip Cancelled Succesfully
                    </h3>
                </div>
            </div>
        </div>
    </div>`

                                                                        setTimeout(() => {
                                                                            location.reload();
                                                                        }, 3000)
                                                                    })

                                                            } else {
                                                                // refund failed
                                                                alert('Pembatalan trip gagal');
                                                            }
                                                        } catch (error) {
                                                            console.log(error)
                                                        }

                                                    }
                                                    </script>

                                                    <!-- Pending status:
                                                    - User can process the payment, moving it to payment gateway page 
                                                    - or canceling payment:
                                                      *> canceling process had two possible scenarios:
                                                       - When payment gateway is set
                                                       - When payment gateway is not set
                                                    -->
                                                    <?php elseif ($trip['status'] === 'pending'):
                                               
                                                        include_once '../controller/php/payment/getPaymentStatus.php';
                                                        $getPaymentStatusFromMidtrans = paymentStatus($trip['order_id']);
                                                        $getPaymentStatusFromMidtrans = json_decode($getPaymentStatusFromMidtrans, true);
                                                     

                                                    if(isset($getPaymentStatusFromMidtrans['transaction_status']) &&
                                                    $getPaymentStatusFromMidtrans['transaction_status'] ==='pending'):
                                                    ?>
                                                    <!-- if payment status is getting any value that mean payment gateway is set on midtrans -->
                                                    <button
                                                        onclick="cancelProcessingTrip('<?= $trip['order_id']?>', '<?= $trip['trip_id']?>', '<?= $trip['driver_id']?>')"
                                                        class="text-red-100 px-3 py-1 bg-red-500 rounded">Batal</button>
                                                    <button onclick="continueProcessingTrip('<?= $trip['trip_id']?>')"
                                                        class="bg-emerald-500 px-3 py-1 rounded text-white">Proses</button>
                                                    <!-- Script for above button -->
                                                    <script>
                                                    async function cancelProcessingTrip(order_id, trip_id, driver_id) {
                                                        const userConfirm = confirm(
                                                            'Yakin membatalkan perjalanan?');
                                                        if (!userConfirm) return;
                                                        // clearing the transaction on midtrans
                                                        const cancelPaymentResponse = await fetch(
                                                            `../controller/php/paymentHandler.php`, {
                                                                method: 'POST',
                                                                body: JSON.stringify({
                                                                    action: 'cancelPayment',
                                                                    order_id: order_id,
                                                                })
                                                            }
                                                        )

                                                        if (cancelPaymentResponse.ok) {
                                                            const data = await cancelPaymentResponse.json();

                                                            // if clearing the transaction on midtrans is successful, next canceling on databse
                                                            if (data.status_code === '200') {
                                                                const updatePaymentStatus = fetch(
                                                                        `../controller/php/tripsHandler.php`, {
                                                                            method: 'POST',
                                                                            body: JSON.stringify({
                                                                                action: 'updateTripStatus',
                                                                                trip_id: trip_id,
                                                                                status: "cancelled",
                                                                                clearToken: "yes"
                                                                            })
                                                                        })
                                                                    .then(resp => resp.json())
                                                                    .then(data => {

                                                                        document.body.innerHTML += `    <!-- Cancel Alert Componet -->
                                                    <div id="alert-modal" tabindex="-1"
                                                        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
                                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                <div class="py-10 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Trip Cancelled Succesfully
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`

                                                                        setTimeout(() => {
                                                                            location.reload();
                                                                        }, 3000)
                                                                    })
                                                            }
                                                        } else {
                                                            console.error('HTTP Error:', response.statusText);
                                                        }
                                                    }
                                                    </script>

                                                    <?php else: ?>
                                                    <!-- handle when payment is not set on midtrans, that mean paymet gateway is set only on database php -->
                                                    <button onclick="cancelProcessingTrip('<?= $trip['trip_id']?>')"
                                                        class="bg-rose-500 px-3 py-1 rounded text-white">Batal</button>
                                                    <button onclick="continueProcessingTrip('<?= $trip['trip_id']?>')"
                                                        class="bg-emerald-500 px-3 py-1 rounded text-white">Proses</button>
                                                    <script>
                                                    // cancel button for processing in datbase not in midtrans function
                                                    function cancelProcessingTrip(trip_id) {
                                                        const userConfirm = confirm(
                                                            'Yakin membatalkan perjalanan?');

                                                        if (!userConfirm) return;

                                                        const updatePaymentStatus = fetch(
                                                                `../controller/php/tripsHandler.php`, {
                                                                    method: 'POST',
                                                                    body: JSON.stringify({
                                                                        action: 'updateTripStatus',
                                                                        trip_id: trip_id,
                                                                        status: "cancelled",
                                                                        clearToken: "yes"
                                                                    })
                                                                })
                                                            .then(resp => resp.json())
                                                            .then(data => {

                                                                document.body.innerHTML += `    <!-- Cancel Alert Componet -->
                                                    <div id="alert-modal" tabindex="-1"
                                                        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
                                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                <div class="py-10 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Trip Cancelled Succesfully
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`

                                                                setTimeout(() => {
                                                                    location.reload();
                                                                }, 3000)
                                                            })

                                                    }
                                                    </script>
                                                    <?php endif; ?>
                                                    <!-- Other state: (Cancelled / Completed), do nothing. Just pass "-" symbol -->
                                                    <?php else: ?>
                                                    -
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                        </tr>

                                        <?php }
                                        } else { ?>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                -</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                -</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                -
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 underline"> -
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"> -</td>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"> - </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"> -</td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Metadata -->
    <input type="hidden" name="email" value="<?= $userProfile['email'] ?>">
    <input type="hidden" name="username" value="<?= $userProfile['username'] ?>">

    <!-- Custom Script -->
    <script src="script/sidebar.js"></script>
    <script>
    function continueProcessingTrip(trip_id) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "action/gateway.php";

        const tripIdInput = document.createElement("input");
        tripIdInput.type = "hidden";
        tripIdInput.name = "trip_id";
        tripIdInput.value = trip_id;
        form.appendChild(tripIdInput);

        document.body.appendChild(form);

        form.submit();
    }
    </script>




</body>

</html>

<?php 
} else {
    header("Location: ../auth/login.php");
    exit();
}
?>