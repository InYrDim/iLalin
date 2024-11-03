<?php
session_start();

include_once '../controller/php/ilalin.php';

$auth = new Auth();

$referer = $_SERVER['HTTP_REFERER'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Checkcropper.toStringf the file is uploaded
    if(isset($_POST['update_profile'])) {
        $driverId = $_POST['driver_id'];
        $dEmail = $_POST['email'];
        $dName = $_POST['name'];
        $dPhone = $_POST['phone_number'];

        $resp = $driver->updateDriverProfile($driverId, $dName, $dEmail, $dPhone);
        
        if($resp) {
            echo "<script>alert('Succesfuly Updating Driver Data')</script>";
            echo "<script>location.href='$referer'</script>";
            exit();
        }

    }
    elseif(isset($_POST['update_password'])) {
    
        // Password Handling
        $password_saat_ini = filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_STRING);
        $password_baru = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $konfirmasi_password_baru = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
        
        $driverId = $_POST['driver_id'];

        if ($driverId && password_verify($password_saat_ini,  $driverData['password_hash'])) {
                    
            // Check if new password matches confirmation
            if ($password_baru === $konfirmasi_password_baru) {
            
                // Hash the new password
                $hashedPassword = password_hash($password_baru, PASSWORD_DEFAULT);
                
                // Prepare the update query
                $updateDb = $driver->updateDriverPassword($driverId, $hashedPassword);

                if ($updateDb) {
                    echo "<script>alert('Update Password Succesfuly')</script>";
                    echo "<script>location.href='$referer'</script>";
                    exit();
                } else {
                    echo "<script>alert('Failed to update profile.')</script>";
                }
            } else {
                echo "<script>alert('New password and confirmation do not match.')</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect.')</script>";
        }
        
    }
    elseif(isset($_POST['update_vehicle'])) {
        
        $driverId = $_POST['driver_id'];
        $vehicle_name = $_POST['vehicle_name'];
        $plat_number = $_POST['plate_number'];

        // Handle vehicle update
        // if driver had vehicle update it, if not insert it

        // first select the vehicle where driver_id, if result is not empty that means driver has vehicle, then updateit
        // else insert it.
        

        $vehicle = new Vehicle();

        $vehicleWithDriver = $vehicle->getVehicleType($driverId);


        if($vehicleWithDriver) {
            $updateVehicle = $vehicle->updateVehicle($driverId, $vehicle_name, $plat_number);

            if($updateVehicle) {
                echo "<script>alert('Succesfuly Updating Driver Data')</script>";
                echo "<script>location.href='$referer'</script>";
                exit();
            }

        } else {
            $insertVehicle = $vehicle->insertVehicle($driverId, $vehicle_name, $plat_number);

            if($insertVehicle) {
                echo "<script>alert('Succesfuly Updating Driver Data')</script>";
                echo "<script>location.href='$referer'</script>";
                exit();
            }
        }

        
        exit();
    } else {
        $json_data = json_decode(file_get_contents('php://input'), true);
        $imageString = $json_data['image'];
        $driver->replaceImage($driverData['email'], $imageString, 'Drivers');
        exit();
    }

}

$vehicleObj = new Vehicle();

$vehicleData = $vehicleObj->getVehicleType($driverData['driver_id']);
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
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.css">

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
                        <a href="driver/profile.php"
                            class="text-sm font-medium text-como-700 py-2 px-2 hover:bg-como-500 hover:text-white hover:text-base rounded-md transition duration-150 ease-in-out">
                            <i class="ri-profile-line text-xl me-2"></i>
                            <span class="">Profile</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full h-screen  overflow-y-scroll">
            <div class="bg-como-800 w-full p-2 fixed z-[99]">
                <h1 class="p-2 text-2xl font-medium text-como-200">Profile</h1>
            </div>

            <!--  -->
            <div class="mt-16 p-4 gap-4 flex flex-col">

                <!-- Tabs -->
                <div x-data="{ selectedTab: 'general' }" class="w-full">

                    <!-- Tabs Button -->
                    <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()"
                        class="flex gap-2 overflow-x-auto border-b border-neutral-300 " role="tablist"
                        aria-label="tab options">
                        <button @click="selectedTab = 'general'" :aria-selected="selectedTab === 'general'"
                            :tabindex="selectedTab === 'general' ? '0' : '-1'"
                            :class="selectedTab === 'general' ? 'font-bold text-como-700 border-b-2 border-como-800 ' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelgeneral">
                            <i class="ri-user-line"></i>
                            General
                        </button>
                        <button @click="selectedTab = 'security'" :aria-selected="selectedTab === 'security'"
                            :tabindex="selectedTab === 'security' ? '0' : '-1'"
                            :class="selectedTab === 'security' ? 'font-bold text-como-700 border-b-2 border-como-800 ' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelsecurity">
                            <i class="ri-key-fill"></i>
                            Password
                        </button>

                        <button @click="selectedTab = 'vehicle'" :aria-selected="selectedTab === 'vehicle'"
                            :tabindex="selectedTab === 'vehicle' ? '0' : '-1'"
                            :class="selectedTab === 'vehicle' ? 'font-bold text-como-700 border-b-2 border-como-800 ' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelsecurity">
                            <i class="ri-steering-fill"></i>
                            Vehicle
                        </button>
                    </div>

                    <!-- Tabs Data -->
                    <div class="px-2 py-4 text-neutral-600">

                        <!-- General Info Tab Content -->

                        <div x-show="selectedTab === 'general'" id="tabpanelgeneral" role="tabpanel"
                            aria-label="general">

                            <div class="flex gap-4">

                                <div class="bg-como-100 p-4 rounded">
                                    <div class="flex flex-col items-center gap-2">
                                        <img id="profileImage"
                                            src="<?= strpos($driverData['profile_image'], 'data:image') === 0 ? $driverData['profile_image'] : 'data:image/jpeg;base64,' . $driverData['profile_image'] ?>"
                                            alt="Avatar user" class="w-48 mx-auto" />
                                        <div class="w-fit">
                                            <input type="file" id="fileInput" style="display: none;"
                                                onchange="changePhoto(event)">
                                            <!-- Modal toggle -->
                                            <button onclick="document.getElementById('fileInput').click();"
                                                data-modal-target="cropImage" data-modal-toggle="cropImage"
                                                class="block text-white bg-como-700 hover:bg-como-800 focus:ring-4 focus:outline-none focus:ring-como-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center"
                                                type="button">
                                                <i class="ri-upload-cloud-2-fill me-2"></i>Change Picture
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-como-100 p-4 rounded flex-1">
                                    <form action="" method="POST">
                                        <input type="hidden" name="driver_id" value="<?=$driverData['driver_id']?>">
                                        <div class="w-full">
                                            <div class="mb-6">
                                                <label for="name"
                                                    class="block mb-2 text-sm font-medium text-como-900">Nama</label>
                                                <input type="name" id="name" name="name"
                                                    class="focus:outline-como-300 border border-como-300 text-como-900 text-sm rounded-lg  block w-full p-2.5"
                                                    value="<?=$driverData['name']?>" required />
                                            </div>
                                            <div class="mb-6">
                                                <label for="email"
                                                    class="block mb-2 text-sm font-medium text-como-900">Email
                                                    address</label>
                                                <input type="email" id="email" name="email"
                                                    class="focus:outline-como-300 bg-como-50 border border-como-300 text-como-900 text-sm rounded-lg block w-full p-2.5"
                                                    value="<?=$driverData['email']?>" required />
                                            </div>
                                            <div class="mb-6">
                                                <label for="telp" name="phone_number"
                                                    class="block mb-2 text-sm font-medium text-como-900">No.
                                                    Telepon</label>
                                                <input type="text" id="telp" name="phone_number"
                                                    class="focus:outline-como-300 bg-como-50 border border-como-300 text-como-900 text-sm rounded-lg block w-full p-2.5"
                                                    value="<?=$driverData['phone_number']?>" required />
                                            </div>


                                        </div>
                                        <button type="submit" name="update_profile"
                                            class="text-white bg-como-700 hover:bg-como-800 focus:ring-4 focus:outline-none focus:ring-como-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update
                                            Profil</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <!-- Password Tab Content -->
                        <div x-show="selectedTab === 'security'" id="tabpanelsecurity" role="tabpanel"
                            aria-label="security">
                            <div class="bg-como-100 p-4 rounded">
                                <form action="" method="POST">
                                    <input type="hidden" name="driver_id" value="<?=$driverData['driver_id']?>">
                                    <div>
                                        <h3 class="mb-4 text-xl text-como-700 font-semibold">Ganti Password</h3>
                                        <div class="relative mb-6">
                                            <input type="text" id="floating_outlined" name="current_password"
                                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-como-600 peer"
                                                placeholder=" " />
                                            <label for="floating_outlined"
                                                class="absolute text-sm text-gray-500 rounded-lg  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-como-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Password
                                                Saat Ini</label>
                                        </div>
                                        <div class="relative mb-6">
                                            <input type="text" id="floating_outlined" name="new_password"
                                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-como-600 peer"
                                                placeholder=" " />
                                            <label for="floating_outlined"
                                                class="absolute text-sm text-gray-500 rounded-lg  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-como-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Password
                                                Baru</label>
                                        </div>
                                        <div class="relative mb-6">
                                            <input type="text" id="floating_outlined" name="confirm_password"
                                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-como-600 peer"
                                                placeholder=" " />
                                            <label for="floating_outlined"
                                                class="absolute text-sm text-gray-500 rounded-lg  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-como-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Konfirmasi
                                                Password Baru</label>
                                        </div>
                                        <button type="submit" name="update_password"
                                            class="text-white bg-como-700 hover:bg-como-800 focus:ring-4 focus:outline-none focus:ring-como-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update
                                            Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Vehicle Tab Content -->
                        <div x-show="selectedTab === 'vehicle'" id="tabpanelComments" role="tabpanel"
                            aria-label="comments">
                            <form action="" method="POST">
                                <input type="hidden" name="driver_id" value="<?=$driverData['driver_id']?>">
                                <div class="flex gap-4 flex-col">
                                    <div class="w-full">
                                        <div class="mb-4">
                                            <label for="name" class="block mb-2 text-sm font-medium text-como-900">Nama

                                                Mobil</label>
                                            <input type="name" id="name" name="vehicle_name"
                                                class="focus:outline-como-300 border border-como-300 text-como-900 text-sm rounded-lg  block w-full p-2.5"
                                                placeholder="<?=isset($vehicleData['vehicle_name']) ? $vehicleData['vehicle_name']: 'masukkan nama mobil anda'?>"
                                                required />
                                        </div>
                                        <div class="mb-4">
                                            <label for="name" class="block mb-2 text-sm font-medium text-como-900">Plat
                                                Mobil</label>
                                            <input type="name" id="name" name="plate_number"
                                                class="focus:outline-como-300 border border-como-300 text-como-900 text-sm rounded-lg  block w-full p-2.5"
                                                placeholder="<?=isset($vehicleData['plate_number']) ? $vehicleData['plate_number']: 'masukkan nomor plat mobil anda'?>"
                                                required />
                                        </div>
                                        <button type="submit" name="update_vehicle"
                                            class="text-white bg-como-700 hover:bg-como-800 focus:ring-4 focus:outline-none focus:ring-como-300 font-medium rounded-lg text-sm w-fit sm:w-auto px-5 py-2.5 text-center">Update
                                            Data Mobil</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--  -->


            </div>
        </div>

        <!-- Main modal -->
        <div id="cropImage" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-como-900 ">
                            Picture
                        </h3>
                        <button type="button"
                            class="text-como-400 bg-transparent hover:bg-como-200 hover:text-como-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="cropImage">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div id="croppieContaier">

                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-como-200 rounded-b">
                        <button data-modal-hide="cropImage" id="cropBtn"
                            class="text-white bg-como-700 hover:bg-como-800 focus:ring-4 focus:outline-none focus:ring-como-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Save</button>
                        <button data-modal-hide="cropImage" id="cropBtnDismis" onclick="c.destroy();"
                            class="py-2.5 px-5 ms-3 text-sm font-medium tex border border-como-200 hover:bg-como-100 hover:text-como-700 focus:z-10 focus:ring-4 focus:ring-como-100 ">Cancel</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Vendor -->

        <!-- 1. Flowbite -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.js"
            integrity="sha256-noEeBltqVSH78NQZV6+oF9BnLEtCY7cKc0U90dQVF6c=" crossorigin="anonymous">
        </script>

        <script>
        var c = new Croppie(document.getElementById("croppieContaier"), {
            viewPort: {
                width: 400,
                height: 400,
                type: "square"
            },
            boundary: {
                width: 200,
                height: 200
            },
            enableOrientation: true,
            enableExif: true,
        });

        function changePhoto(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const base64String = e.target.result;

                const image_container = document.getElementById("profileImage");

                c.bind({
                    url: base64String,
                });

                const cropbtn = document.getElementById("cropBtn");
                const cropImage = document.getElementById("cropImage");

                cropbtn.addEventListener("click", function() {
                    c.result({
                        type: "html",
                        size: {
                            width: 600,
                            height: 600
                        }
                    }).then(
                        (res) => {

                            const base64String = res.children[0].src

                            image_container.src = base64String

                            fetch("profile.php", {
                                method: "POST",
                                body: JSON.stringify({
                                    image: base64String,
                                    btn: "crop",
                                }),
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            }).then((response) => {
                                if (response.status === 200) {
                                    window.location.reload();
                                }
                            });
                        }
                    );
                });

                cropImage.addEventListener("hide.bs.modal", function() {
                    c.destroy();
                });

                // Send fetch request to the PHP script
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        </script>
</body>

</html>