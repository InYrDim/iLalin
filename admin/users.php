<?php
session_start();

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
                            class="flex items-center p-2 text-como-50 rounded-lg dark:text-como-200 hover:bg-como-600 dark:hover:bg-gray-700 group">
                            <i class="ri-group-fill text-xl"></i>
                            <span class="ms-3">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="trips.php"
                            class="flex items-center p-2 text-como-200 rounded-lg dark:text-como-200 hover:bg-como-600 dark:hover:bg-gray-700 group">
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
                <a href="index.php"
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
                    <h1 class=" text-4xl font-bold text-como-900">Users</h1>

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
                                        class="ms-1 text-sm text-como-700 hover:text-orange-peel-600 md:ms-2 dark:text-como-400 dark:hover:text-white">Users</a>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <div class="flex gap-4">
                        <div
                            class="flex flex-col flex-1 min-h-24 border-2 border-como-500 p-4 rounded-lg transition-all bg-como-50 hover:shadow-[5px_5px_0px_0px_#3b5d50]">
                            <h3 class="text-como-600 text-xl">Total Users</h3>
                            <span class="text-orange-peel-500 font-bold text-4xl mt-2">189</span>
                            <div class="text-como-600 mt-4"><span>18%</span> Peningkatan</div>
                        </div>
                        <div
                            class="flex flex-col flex-1 min-h-24 border-2 border-como-500 p-4 rounded-lg transition-all bg-como-50 hover:shadow-[5px_5px_0px_0px_#3b5d50]">
                            <h3 class="text-como-600 text-xl">Total Driver</h3>
                            <span class="text-orange-peel-500 font-bold text-4xl mt-2">86</span>
                            <div class="text-como-600 mt-4"><span>18%</span> Peningkatan</div>
                        </div>
                    </div>

                    <!-- Driver Content -->
                    <div class="mt-4 relative border-2 border-como-500 overflow-auto h-96 rounded-lg ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                            <caption
                                class="p-5 text-lg font-semibold text-left rtl:text-right text-como-700 bg-white dark:text-white dark:bg-gray-800">
                                Driver
                                <p class="mt-1 text-sm font-normal text-como-300 dark:text-como-400">List driver ilalin
                                </p>
                            </caption>
                            <thead
                                class="text-xs text-como-700 uppercase bg-como-100 dark:bg-como-700 dark:text-como-400">
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
                                <tr class="bg-white border-b dark:bg-como-800 dark:border-como-700"
                                    data-driver-id="<?= $driver['driver_id'] ?>">
                                    <td class="px-6 py-4 font-medium text-como-900 whitespace-nowrap dark:text-white">
                                        <a href=""><?= $driver['name'] ?></a>
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Passenger Content -->
                    <div class="mt-4 relative border-2 border-como-500 overflow-x-auto rounded-lg ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                            <caption
                                class="p-5 text-lg font-semibold text-left rtl:text-right text-como-700 bg-white dark:text-white dark:bg-gray-800">
                                Pengguna Kita
                                <p class="mt-1 text-sm font-normal text-como-300 dark:text-como-400">List pengguna
                                    ilalin selain driver
                                </p>
                            </caption>
                            <thead
                                class="text-xs text-como-700 uppercase bg-como-100 dark:bg-como-700 dark:text-como-400">
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
                                <tr class="bg-white border-b dark:bg-como-800 dark:border-como-700"
                                    data-passenger-id="<?= $passenger['id_pengguna'] ?>">
                                    <td class="px-6 py-4 font-medium text-como-900 whitespace-nowrap dark:text-white">
                                        <a href=""><?= $passenger['username'] ?></a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['alamat'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['nama'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['email'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $passenger['nomor_telepon'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
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

</body>

</html>