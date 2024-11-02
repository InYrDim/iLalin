<?php
session_start();

include_once '../controller/php/ilalin.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    
    header('Location:/ilalin/auth/login.php');
    exit();
    
}

$driver = new Driver();

$driverData;
if(isset($_SESSION['driver_id']) && $_SESSION['driver_id']) {
    $driverData = $driver->getDriverById($_SESSION['driver_id']);
} elseif (isset($_SESSION['email']) && $_SESSION['email']) {
    $driverData = $driver->getDriverByEmail($_SESSION['email']);
}
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
                    <img src="<?= strpos($driverData['profile_image'], 'data:image') === 0 ? $driverData['profile_image'] : 'data:image/jpeg;base64,' . $driverData['profile_image'] ?>"
                        alt="Avatar user" class="w-10 md:w-16 rounded-full mx-auto" />
                    <div>
                        <h2 class="font-medium text-xs md:text-sm text-center text-como-500">
                            <?=$driverData['name']?>
                        </h2>
                        <p class="text-xs text-como-500 text-center"><?=$driverData['phone_number']?></p>
                        <a href="../controller/php/utils/session.destroy.php?home=../../../auth/login.php"
                            class="mx-auto mt-2 px-2 w-fit flex items-center text-como-500 rounded-lg hover:text-como-50 hover:bg-como-600 ">
                            <i class="ri-logout-box-r-line"></i>
                            <span class="ms-3">Logout</span>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="space-y-2">
                    <div id="menu" class="flex flex-col space-y-2">
                        <a href="index.php"
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
                        <label for="driver_status" class="flex block mb-2 text-sm font-medium text-como-900">Driver
                            Status</label>
                        <select id="driver_status" data-driverId="<?= $driverData['driver_id']?>"
                            onchange="changeDriverStatus(this);"
                            class="w-24 bg-como-50 border border-como-300 text-como-900 text-sm rounded-lg focus:ring-orange-peel-500 focus:border-orange-peel-500 block p-1">
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
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50f">
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
                                
                                $tripsData = $tripObj->getTripsByDriverIdWithIsAccepted($driverData["driver_id"]);
                                
                                if($tripsData != "User not found"):
                                    foreach ($tripsData as $trip) :
                                ?>
                                <!-- Add Handler On Click this handle button -->
                                <!-- 1. Decline Trip -->
                                <!-- 2. Chat With Pessanger Over WhatsApp -->
                                <tr class="bg-white hover:bg-gray-50 ">

                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <?= $trip['email'] ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $trip['distance'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $utils->formatCurrency($trip['driver_profit']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="#" class="font-medium text-blue-600 hover:underline"
                                            data-modal-target="<?= $trip['trip_id'] ?>"
                                            data-modal-toggle="<?= $trip['trip_id'] ?>">Handle</a>
                                    </td>

                                    <div id="<?= $trip['trip_id'] ?>" data-modal-backdrop="static" tabindex="-1"
                                        aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full z-[9999]">
                                        <div class="fixed z-[9999] inset-0 backdrop-blur"></div>
                                        <div class="relative p-4 w-full max-w-2xl max-h-full z-[99999]">
                                            <!-- Modal content -->
                                            <div class="relative bg-white border-2 border-como-500 rounded-lg shadow 
                                            ">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t gap-2">
                                                    <i class="ri-route-line text-3xl text-orange-peel-500"></i>
                                                    <div>
                                                        <h3 class="text-xl font-semibold text-como-90"
                                                            id=" <?= $trip['name'] ?>">
                                                            <?= $trip['name'] ?>
                                                        </h3>
                                                        <span class="inline-block text-como-300 text-sm italic">TripID:
                                                            <?= $trip['trip_id'] ?></span>
                                                    </div>

                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
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
                                                    <?php if($trip['status'] == 'cancelled'){ ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-rose-500 border border-rose-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php }elseif($trip['status'] == 'pending'){ ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-orange-peel-500 border border-orange-peel-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div
                                                        class="px-2 py-1 w-fit rounded-lg text-como-500 border border-como-500">
                                                        <?=$trip['status']?>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="border-b-2 border-como-700 pb-4 mt-2 flex gap-4">
                                                        <div class="bg-como-200 py-2 px-3 rounded-lg">
                                                            <?php                                                    
                                                                $passengerProfile = new Passenger();
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
                                                                <p class="text-sm leading-relaxed text-gray-500">
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
                                                                <p class="text-sm leading-relaxed text-gray-500">
                                                                    <?= $formated_address ?>
                                                                </p>
                                                            </div>
                                                            <iframe
                                                                src="//maps.google.com/maps?q=<?=$lat?>,<?=$lng?>&z=15&output=embed"></iframe>
                                                        </div>
                                                    </div>


                                                    <div class="w-full flex justify-betwwen">
                                                        <div class="flex gap-2 items-center">
                                                            <div class="font-bold text-xl">Pemasukan:</div>
                                                            <span><?= $utils->formatCurrency( $trip['driver_profit'])?></span>
                                                        </div>
                                                        <button data-driver-id="<?= $trip['driver_id']?>"
                                                            data-trip-id="<?= $trip['trip_id']?>"
                                                            onclick="updateTripsByDriverWithIsAccepted(this);"
                                                            class="text-black bg-red-500 py-2 px-4 rounded-lg text-red-100 ml-auto">Decline</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


    <!-- Vendor -->
    <!-- 1. Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
    function updateTripsByDriverWithIsAccepted(el) {
        const driver_id = el.dataset.driverId;
        const trip_id = el.dataset.tripId;

        fetch("../controller/php/tripsHandler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    action: "updateTripsByDriverWithIsAccepted",
                    driver_id: driver_id,
                    trip_id: trip_id,
                    is_accepted: 'cancelled',
                }),
            }).then(response => response.json())
            .then(data => {
                alert(`${data.message}`)
                location.reload();
            })
    }
    </script>
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