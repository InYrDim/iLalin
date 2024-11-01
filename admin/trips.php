<?php
session_start();

include_once '../controller/php/ilalin.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    
    header('Location:/ilalin/auth/admin-login.php');
    exit();
    
}

include_once '../controller/php/ilalin.php';


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
    <!-- 1. Remix Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.4.0/remixicon.min.css"
        integrity="sha512-6sfYTBLNjOZhwJ5g/J0529qHqIdXxO1BycUHd1LIJjEzVCzX8cHtoXDgd+ylrqCl/OZM/RMDgkn2Dd41lJsJjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- 2. TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 3. Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Mine -->
    <link href="../assets/css/global.css" rel="stylesheet" />
    <script src="../tailwind.config.js"></script>

    <title>Trips - iLalin</title>
</head>

<body class="font-outfit ">

    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only ">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-mineral-green-500 "
        aria-label="Sidebar">
        <div class="h-full pt-4 overflow-y-auto bg-como-500 dark:bg-gray-800 flex flex-col justify-between">
            <div class=" px-3">
                <a href="" class="flex items-center ps-2.5 mb-5 border-b-2 border-como-700">
                    <img src="../assets/images/logo/logo-ilalin.png" class="h-6 me-3 sm:h-12" alt="Ilalin Logo" />
                    <span
                        class="self-center text-xl font-semibold whitespace-nowrap text-como-100 dark:text-como-100">Ilalin
                        Admin</span>
                </a>
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="index.php"
                            class="flex items-center p-2 text-como-200 rounded-lg dark:text-como-50 hover:bg-como-600 dark:hover:bg-gray-700 group">
                            <i class="ri-dashboard-fill text-xl"></i>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="users.php"
                            class="flex items-center p-2 text-como-200 rounded-lg dark:text-como-200 hover:bg-como-600 dark:hover:bg-gray-700 group">
                            <i class="ri-group-fill text-xl"></i>
                            <span class="ms-3">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="trips.php"
                            class="flex items-center p-2 text-como-50 rounded-lg dark:text-como-200 hover:bg-como-600 dark:hover:bg-gray-700 group">
                            <i class="ri-steering-2-line text-xl"></i>
                            <span class="ms-3">Trips</span>
                        </a>
                    </li>
                    <li>
                        <a href="analytics.php"
                            class="flex items-center p-2 text-como-200 rounded-lg dark:text-como-200 hover:bg-como-600 dark:hover:bg-gray-700 group">
                            <i class="ri-bubble-chart-fill text-xl"></i>
                            <span class="ms-3">Analytics</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bg-como-700 px-3 py-5">
                <div class="flex items-center gap-2">
                    <div class="relative aspect-square w-8 rounded-full overflow-hidden"><img class="inset-0 absolute "
                            src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_image'])?>"
                            alt="Profile <?php echo $_SESSION['nama']; ?>" class="rounded-circle"></div>
                    <span class="text-como-100"><?php echo $_SESSION['nama']; ?></span>

                </div>
                <a href="../controller/php/utils/session.destroy.php?home=../../../auth/admin-login.php"
                    class="mt-2 flex items-center p-2 text-como-50 rounded-lg dark:text-como-50 hover:bg-como-600 dark:hover:bg-gray-700 group">
                    <i class="ri-logout-box-r-line"></i>
                    <span class="ms-3">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="sm:ml-64 p-4 h-screen ">
        <div class="rounded h-full p-4 bg-como-100 border-2 border-como-600  overflow-scroll ">
            <!-- Content Main -->
            <div>
                <!-- Heading -->
                <div>
                    <h1 class=" text-4xl font-bold text-como-900">Trips</h1>

                    <!-- Breadcrumb Nav -->
                    <nav class="flex mt-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href=""
                                    class="inline-flex items-center text-sm font-medium text-como-300 hover:text-orange-peel-600 dark:text-como-400 dark:hover:text-white">
                                    iLalin Admin
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-como-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <a href=""
                                        class="ms-1 text-sm text-como-700 hover:text-orange-peel-600 md:ms-2 dark:text-como-400 dark:hover:text-white">Trips</a>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div>
                    <div class="mt-4 relative border-2 border-como-500 overflow-auto h-96 rounded-lg ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                            <caption
                                class="p-5 text-lg font-semibold text-left rtl:text-right text-como-700 bg-white dark:text-white dark:bg-gray-800">
                                Semua Perjalanan
                                <p class="mt-1 text-sm font-normal text-como-300 dark:text-como-400">List Semua
                                    Perjalanan
                                </p>
                            </caption>
                            <thead
                                class="text-xs text-como-700 uppercase bg-como-100 dark:bg-como-700 dark:text-como-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Perjalanan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email Penumpang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Perkiraan Waktu
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jarak
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status Pembayaran
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Pembayaran
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $tripsObj = new TripController();
                                $utils = new IlalinUtils();
                                $trips = $tripsObj->getAllTrips();

                                $passengerProfile = new ProfileController();
                                $driverProfile = new Driver();


                                
                                ?>
                                <?php if(is_array($trips)):?>
                                <?php foreach($trips as $trip):?>
                                <tr class="bg-white border-b dark:bg-como-800 dark:border-como-700"
                                    data-trip-Id="<?= $trip['trip_id'] ?>">
                                    <td class="px-6 py-4 font-medium text-como-900 whitespace-nowrap dark:text-white underline cursor-pointer"
                                        data-modal-target="<?= $trip['trip_id'] ?>"
                                        data-modal-toggle="<?= $trip['trip_id'] ?>">
                                        <i class="ri-links-line"></i> <?= $trip['name'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $trip['email'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $trip['time'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $trip['distance'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($trip['status'] == 'cancelled'): ?>
                                        <div class="px-2 py-1 w-fit rounded-lg text-rose-500 border border-rose-500">
                                            <?=$trip['status']?>
                                        </div>
                                        <?php elseif($trip['status'] == 'pending'): ?>
                                        <div
                                            class="px-2 py-1 w-fit rounded-lg text-orange-peel-500 border border-orange-peel-500">
                                            <?=$trip['status']?>
                                        </div>
                                        <?php else: ?>
                                        <div class="px-2 py-1 w-fit rounded-lg text-como-500 border border-como-500">
                                            <?=$trip['status']?>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $utils->formatCurrency($trip['total_payment'])  ?>
                                    </td>
                                    <td class="px-6 py-4" onClick="editUser(this)">
                                        <span
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</span>
                                    </td>
                                </tr>


                                <div id="<?= $trip['trip_id'] ?>" data-modal-backdrop="static" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white border-2 border-como-500 rounded-lg shadow dark:bg-como-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-como-600 gap-2">
                                                <i class="ri-route-line text-3xl text-orange-peel-500"></i>
                                                <div>
                                                    <h3 class="text-xl font-semibold text-como-900 dark:text-white"
                                                        id="trip-name">
                                                        <?= $trip['name'] ?>
                                                    </h3>
                                                    <span class="inline-block text-como-300 text-sm italic">TripID:
                                                        <?= $trip['trip_id'] ?></span>
                                                </div>

                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="<?= $trip['trip_id'] ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5 space-y-4">

                                                <div>

                                                    <?php if($trip['status'] == 'cancelled'): ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-rose-500 border border-rose-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php elseif($trip['status'] == 'pending'): ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-orange-peel-500 border border-orange-peel-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php else: ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-como-500 border border-como-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="border-b-2 border-como-700 pb-4 mt-2 flex gap-4">
                                                        <div class="bg-como-200 py-2 px-3 rounded-lg">
                                                            <?php                                                                                                      
                                                                $passengerData = $passengerProfile->getUserProfile($trip['email']);
                                                            ?>
                                                            <h3
                                                                class="text-sm text-como-500 bg-como-100 w-fit px-2 rounded-lg">
                                                                <i class="ri-map-pin-user-line me-2"></i>Penumpang
                                                            </h3>
                                                            <div class="flex gap-2 items-center mt-2">
                                                                <div
                                                                    class="relative aspect-square w-12 h-12 rounded-full overflow-hidden">
                                                                    <img class="inset-0 absolute "
                                                                        src="<?= strpos($passengerData['profile_image'], 'data:image') === 0 ? $passengerData['profile_image'] : 'data:image/jpeg;base64,' . $passengerData['profile_image'] ?>"
                                                                        alt="Profile <?php echo $passengerData['nama']; ?>"
                                                                        class="rounded-circle">
                                                                </div>
                                                                <div class="flex flex-col">
                                                                    <span
                                                                        class="text-como-600 font-medium"><?php echo $passengerData['nama']; ?></span>
                                                                    <span
                                                                        class="text-como-400 text-sm"><?php echo $passengerData['nomor_telepon']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if($trip['driver_id'] != '0'): ?>
                                                        <div
                                                            class="border border-como-200 bg-como-50 py-2 px-3 rounded-lg">
                                                            <?php                                                                                                      
                                                                $driver = $driverProfile->getDriverById($trip['driver_id']);

                                                            ?>
                                                            <h3
                                                                class="text-sm text-como-500 bg-como-100 w-fit px-2 rounded-lg">
                                                                <i class="ri-steering-2-line me-2"></i>Pengemudi
                                                            </h3>
                                                            <div class="flex gap-2 items-center mt-2">
                                                                <div
                                                                    class="relative aspect-square w-12 h-12 rounded-full overflow-hidden">
                                                                    <img class="inset-0 absolute "
                                                                        src="<?= strpos($driver['profile_image'], 'data:image') === 0 ? $driver['profile_image'] : 'data:image/jpeg;base64,' . $driver['profile_image'] ?>"
                                                                        alt="Profile <?php echo $driver['nama']; ?>"
                                                                        class="rounded-circle">
                                                                </div>
                                                                <div class="flex flex-col">
                                                                    <span
                                                                        class="text-como-600 font-medium"><?php echo $driver['name']; ?></span>
                                                                    <span
                                                                        class="text-como-400 text-sm"><?php echo $driver['phone_number']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="flex gap-2 mt-4">
                                                        <!-- Start -->
                                                        <?php
                                                            $point = json_decode($trip['start_point'], true);
                                                            $formated_address = $point['formatted_address'];
                                                            $name =  $point['name'];
                                                            $lat = $point['lat'];
                                                            $lng = $point['lng']; 
                                                        ?>
                                                        <div>
                                                            <div class="mb-2">
                                                                <h4><span class="text-como-500">Titik Awal:
                                                                    </span><?=$name?></h4>
                                                                <p
                                                                    class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                                                    <?= $formated_address ?>
                                                                </p>
                                                            </div>
                                                            <iframe
                                                                src="//maps.google.com/maps?q=<?=$lat?>,<?=$lng?>&z=15&output=embed"></iframe>
                                                        </div>

                                                        <!-- End -->
                                                        <?php
                                                            $point = json_decode($trip['finishing_point'], true);
                                                            $formated_address = $point['formatted_address'];
                                                            $name =  $point['name'];
                                                            $lat = $point['lat'];
                                                            $lng = $point['lng']; 
                                                        ?>
                                                        <div>
                                                            <div class="mb-2">
                                                                <h4><span class="text-como-500">Tujuan:
                                                                    </span><?=$name?></h4>
                                                                <p
                                                                    class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                                                    <?= $formated_address ?>
                                                                </p>
                                                            </div>
                                                            <iframe
                                                                src="//maps.google.com/maps?q=<?=$lat?>,<?=$lng?>&z=15&output=embed"></iframe>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Vendor -->
        <!-- 1. Flowbite -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        <!-- Custom -->
        <!-- <script>
        function showTripDetails(el) {
            const tripId = el.parentNode.dataset.tripId;

            const tripNameEl = document.getElementById('trip-name');
            tripNameEl.textContent = 'Trip details for ID' + tripId;
        }
        </script> -->

</body>

</html>