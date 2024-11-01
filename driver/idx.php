<?php
session_start();

include_once '../controller/php/ilalin.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    
    header('Location:/ilalin/auth/login.php');
    exit();
    
}

$driver = new Driver();

$driverData = $driver->getDriverById($_SESSION['driver_id']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver</title>
    <!-- Vendor -->
    <!-- 1. Remix Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.4.0/remixicon.min.css"
        integrity="sha512-6sfYTBLNjOZhwJ5g/J0529qHqIdXxO1BycUHd1LIJjEzVCzX8cHtoXDgd+ylrqCl/OZM/RMDgkn2Dd41lJsJjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- 2. TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../tailwind.config.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- 3. AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- 4. Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Mine -->
    <link href="../assets/css/global.css" rel="stylesheet" />
</head>


<body class="font-outfit">
    <div id="view" class="h-full w-screen flex flex-row" x-data="{ sidenav: true }">
        <button @click="sidenav = true"
            class="ms-2 mt-2 p-2 border-2 bg-white rounded-md border-como-200 shadow-lg text-como-500 focus:bg-como-500 focus:outline-none focus:text-white absolute top-0 left-0 sm:hidden">
            <svg class="w-5 h-5 fill-current" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Sidebar -->
        <div id="sidebar"
            class="bg-white h-screen md:block border-r-2 border-como-500 px-3 w-30 md:w-60 lg:w-60 overflow-x-hidden transition-transform duration-300 ease-in-out"
            x-show="sidenav">
            <div class="space-y-6 md:space-y-5 mt-10">
                <div class=" font-bold text-xl text-center flex items-center w-fit mx-auto">
                    <img src="../assets/images/logo/logo-ilalin.png" class="h-6 sm:h-12" alt="Ilalin Logo" />
                    <p>Ilalin<span class="text-como-600">.</span></p>
                </div>
                <div id="profile" class="space-y-3">
                    <img src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80"
                        alt="Avatar user" class="w-10 md:w-16 rounded-full mx-auto" />
                    <div>
                        <h2 class="font-medium text-xs md:text-sm text-center text-como-500">
                            <?=$driverData['name']?>
                        </h2>
                        <p class="text-xs text-como-500 text-center"><?=$driverData['phone_number']?></p>
                        <a href="../controller/php/utils/session.destroy.php?home=../../../auth/login.php"
                            class="mx-auto mt-2 px-2 w-fit flex items-center text-como-500 rounded-lg dark:text-como-50 hover:text-como-50 hover:bg-como-600 dark:hover:bg-como-700">
                            <i class="ri-logout-box-r-line"></i>
                            <span class="ms-3">Logout</span>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="space-y-2">
                    <div id="menu" class="flex flex-col space-y-2">
                        <a href=""
                            class="text-sm font-medium text-como-700 py-2 px-2 hover:bg-como-500 hover:text-white hover:text-base rounded-md transition duration-150 ease-in-out">
                            <i class="ri-dashboard-horizontal-line text-xl me-2"></i>
                            <span class="">Dashboard</span>
                        </a>
                    </div>
                    <div id="menu" class="flex flex-col space-y-2">
                        <a href=""
                            class="text-sm font-medium text-como-700 py-2 px-2 hover:bg-como-500 hover:text-white hover:text-base rounded-md transition duration-150 ease-in-out">
                            <i class="ri-profile-line text-xl me-2"></i>
                            <span class="">Profile</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- MainContent -->
        <div class="w-full h-screen  overflow-y-scroll">
            <div class="bg-como-800 w-full p-2 fixed z-[99]">
                <h1 class="p-2 text-2xl font-medium text-como-200">Dashboard</h1>
            </div>

            <div class="mt-16 p-4 gap-4 flex justify-center h-full">
                <div class="flex-1">
                    <!-- Driver Status -->
                    <div class="">
                        <label for="driver_status"
                            class="flex block mb-2 text-sm font-medium text-como-900 dark:text-white">Driver
                            Status</label>
                        <select id="driver_status" data-driverId="<?= $driverData['driver_id']?>"
                            onchange="changeDriverStatus(this);"
                            class="w-24 bg-como-50 border border-como-300 text-como-900 text-sm rounded-lg focus:ring-orange-peel-500 focus:border-orange-peel-500 block p-1 dark:bg-como-700 dark:border-como-600 dark:placeholder-como-400 dark:text-white dark:focus:ring-orange-peel-500 dark:focus:border-orange-peel-500">
                            <option value="available" <?php echo $driverData['status'] == 'available' ? 'selected':''?>>
                                Tersedia
                            </option>
                            <option value="busy" <?php echo $driverData['status'] == 'busy' ? 'selected':''?>>Sibuk
                            </option>
                            <option value="not available"
                                <?php echo $driverData['status'] == 'not available' ? 'selected':''?>>
                                Offline
                            </option>
                        </select>
                    </div>

                    <!-- Map Of Driver -->
                    <div id="ilalinMap" class="mt-4 w-full min-h-60 rounded-lg border-2 border-como-500"></div>

                    <!-- Statistic Income -->
                    <div id="statisticIncome"></div>
                </div>
                <div class="flex-1">
                    <h2>Passenger: </h2>
                    <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg border-2 border-como-500 ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jarak
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Pemasukan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Handle</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get Trips by This Driver
                                $tripObj = new TripController();
                                $utils = new IlalinUtils();

                                

                                $tripsData = $tripObj->getTripsByDriverID($driverData["driver_id"]);
                                
                                if($tripsData != "User not found"):
                                    foreach ($tripsData as $trip) :
                                ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $trip['email'] ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $trip['distance'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $utils->formatCurrency($trip['driver_profit']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Handle</a>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
    import Navigator from './script/Navigator.js';

    const driverNavigator = new Navigator();

    // Util Function
    function formatDateTimeForSQL(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`; // For datetime
    }

    async function main() {
        const ilalinMap = L.map('ilalinMap');
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(ilalinMap);

        const driverPosMarker = L.marker()
        const driverId = document.querySelector("[data-driverid]")

        async function updateDriverPosition(latitude, longitude, timestamp) {
            const driverDataResponse = await fetch('../controller/php/driversHandler.php', {
                method: 'POST',
                body: JSON.stringify({
                    action: 'updateDriverPosition',
                    driver_id: driverId.dataset.driverid,
                    latitude: latitude,
                    longitude: longitude,
                    timestamp: timestamp,
                })
            })
        }

        function handleDriverPosition() {
            function success(data) {
                const {
                    latitude,
                    longitude,
                    accuracy
                } = data.coords
                const timestamp = new Date(data.timestamp)

                // Update Map HEREEE~~
                driverPosMarker.setLatLng([latitude, longitude]).addTo(ilalinMap)
                ilalinMap.setView([latitude, longitude], 13)

                // Update Driver Position On Database
                const formatTimeSql = formatDateTimeForSQL(timestamp);
                updateDriverPosition(latitude, longitude, formatTimeSql)
            }
            const watchPosition = driverNavigator.getWatchedPosition(success);
        }

        handleDriverPosition();
    }

    // Run Main Function
    main();
    </script>
    <script>
    async function changeDriverStatus(el) {
        console.log(el)
        const driverDataResponse = await fetch('../controller/php/driversHandler.php', {
            method: 'POST',
            body: JSON.stringify({
                action: 'updateDriverStatus',
                driver_id: el.dataset.driverid,
                status: el.value
            })
        })
    }
    </script>
</body>

</html>