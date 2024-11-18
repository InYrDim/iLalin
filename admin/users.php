<?php
session_start();

include_once '../controller/php/ilalin.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    
    header('Location:/ilalin/auth/admin-login.php');
    exit();
    
}

include_once '../controller/php/ilalin.php';

if(isset($_SESSION['email'])) {
    $driverObj = new Driver();
    $allDriver = $driverObj->getAllDrivers();
    
}

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

    <title>Users - iLalin</title>
</head>

<body class="font-outfit ">

    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
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
        <div class="h-full pt-4 overflow-y-auto bg-como-500  flex flex-col justify-between">
            <div class=" px-3">
                <a href="" class="flex items-center ps-2.5 mb-5 border-b-2 border-como-700">
                    <img src="../assets/images/logo/logo-ilalin.png" class="h-6 me-3 sm:h-12" alt="Ilalin Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-como-100 ">Ilalin
                        Admin</span>
                </a>
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="index.php"
                            class="flex items-center p-2 text-como-200 rounded-lg hover:bg-como-600 group">
                            <i class="ri-dashboard-fill text-xl"></i>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="users.php"
                            class="flex items-center p-2 text-como-50 rounded-lg hover:bg-como-600 group">
                            <i class="ri-group-fill text-xl"></i>
                            <span class="ms-3">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="trips.php"
                            class="flex items-center p-2 text-como-200 rounded-lg hover:bg-como-600 group">
                            <i class="ri-steering-2-line text-xl"></i>
                            <span class="ms-3">Trips</span>
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
                    class="mt-2 flex items-center p-2 text-como-50 rounded-lg hover:bg-como-600 group">
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
                    <h1 class=" text-4xl font-bold text-como-900">Users</h1>

                    <!-- Breadcrumb Nav -->
                    <nav class="flex mt-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href=""
                                    class="inline-flex items-center text-sm font-medium text-como-300 hover:text-orange-peel-600">
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
                                        class="ms-1 text-sm text-como-700 hover:text-orange-peel-600 md:ms-2">Users</a>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <div class="flex gap-4">
                        <?php
                    $db = new Database();

                    $countUsers = $db->query("SELECT COUNT(id_pengguna) as users_count from users");
                    $usersCount = $countUsers->get_result()->fetch_assoc();

                    $countDriver = $db->query("SELECT COUNT(driver_id) as driver_count from drivers");
                    $driversCount = $countDriver->get_result()->fetch_assoc();
                    ?>
                        <div
                            class="flex flex-col flex-1 min-h-24 border-2 border-como-500 p-4 rounded-lg transition-all bg-como-50 hover:shadow-[5px_5px_0px_0px_#3b5d50]">
                            <h3 class="text-como-600 text-xl">Total Users</h3>
                            <span
                                class="text-orange-peel-500 font-bold text-4xl mt-2"><?=$usersCount['users_count'] ?></span>
                        </div>
                        <div
                            class="flex flex-col flex-1 min-h-24 border-2 border-como-500 p-4 rounded-lg transition-all bg-como-50 hover:shadow-[5px_5px_0px_0px_#3b5d50]">
                            <h3 class="text-como-600 text-xl">Total Driver</h3>
                            <span
                                class="text-orange-peel-500 font-bold text-4xl mt-2"><?=$driversCount['driver_count'] ?></span>
                        </div>
                    </div>

                    <!-- Driver Content -->
                    <div class="mt-4 relative border-2 border-como-500 overflow-auto h-96 rounded-lg ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-como-700 bg-white ">
                                Driver
                                <p class="mt-1 text-sm font-normal text-como-300">List driver ilalin
                                </p>
                            </caption>
                            <thead class="text-xs text-como-700 uppercase bg-como-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telepon
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal Daftar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($allDriver)):?>
                                <?php foreach($allDriver as $driver):?>
                                <tr class="bg-white " data-driver-id="<?= $driver['driver_id'] ?>">
                                    <td class="px-6 py-4 font-medium text-como-900 whitespace-nowrap>
                                        <a href=""><?= $driver['name'] ?></a>
                                    </td>
                                    <td class=" px-6 py-4">
                                        <?= $driver['email'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $driver['phone_number'] ?>
                                    </td>
                                    <td
                                        class="px-6 py-4 <?= $driver['status'] == 'available' ? 'text-como-400'  : 'text-orange-peel-500' ?>">
                                        <?= $driver['status'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $driver['created_at'] ?>
                                    </td>
                                    <td class="px-6 py-4" onClick="editUser(this)">
                                        <span class="font-medium text-red-600 hover:underline">Delete</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Passenger Content -->
                    <div class="mt-4 relative border-2 border-como-500 overflow-x-auto rounded-lg ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-como-700 bg-white ">
                                Pengguna Kita
                                <p class="mt-1 text-sm font-normal text-como-300">List pengguna
                                    ilalin selain driver
                                </p>
                            </caption>
                            <thead class="text-xs text-como-700 uppercase bg-como-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telepon
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usersObj = new Passenger();
                                $allPassengers = $usersObj->getAllPassengers();

                                ?>
                                <?php if(is_array($allPassengers)):?>
                                <?php foreach($allPassengers as $passenger):?>
                                <tr class="bg-white border-b" data-passenger-id="<?= $passenger['id_pengguna'] ?>"
                                    data-passenger-email="<?= $passenger['email'] ?>">
                                    <td class="px-6 py-4 font-medium text-como-900 whitespace-nowrap>">
                                        <a href=""><?= $passenger['username'] ?></a>
                                    </td>
                                    <td class=" px-6 py-4">
                                        <?= $passenger['nama'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['alamat'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['email'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['nomor_telepon'] ?>
                                    </td>
                                    <td class="px-6 py-4" onClick="editUser(this)">
                                        <span class="font-medium text-red-600 hover:underline">Delete</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
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

    <!-- Custom -->
    <script>
    function editUser(el) {
        const thisElement = el;

        const parentElement = thisElement.parentElement;


        const dataset = parentElement.dataset

        // Check if it passenger or user
        if (dataset.hasOwnProperty('passengerId')) {
            const email = dataset.passengerEmail;

            const confirmDelete = confirm(`Anda yakin ingin menghapus data penumpang dengan email ${email}?`);

            if (!confirmDelete) {
                return;
            }

            fetch("../controller/php/passengerHandler.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        action: "deletePassengerById",
                        passenger_email: email
                    }),
                }).then(response => response.json())
                .then(data => {
                    alert(`${data.message}`)
                    location.reload();
                })

        } else if (dataset.hasOwnProperty('driverId')) {
            const id = dataset.driverId;

            const confirmDelete = confirm(`Anda yakin ingin menghapus data driver dengan id ${id}?`);

            if (!confirmDelete) {
                return;
            }


            fetch("../controller/php/driversHandler.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        action: "deleteDriverById",
                        driver_id: id
                    }),
                }).then(response => response.json())
                .then(data => {
                    alert(`${data.message}`)
                    location.reload();
                })

        } else {
            console.log("Unknown type");
        }
    }
    </script>
</body>

</html>