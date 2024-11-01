<?php
session_start();

include '../../controller/php/database.php';

$email = $_SESSION['email'];

if(isset($email)) {
    
    
    $db = new Database();
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Checkcropper.toStringf the file is uploaded
        $json_data = json_decode(file_get_contents('php://input'), true);

        $imageString = $json_data['image'];
        
        $updateDb = $db->update('users', [
            'profile_image' => $imageString,
        ], 'email = ?', [$email] );
            
    }

    $profile = $db->fetch('users', "*", 'email = ?', [$email]);
?>

<!DOCTYPE html>
<html lang="en">

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
    <!-- Leafet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <!-- Bootstrap CSS -->
    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="../../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/sidebar.css">


    <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 
    <!-- Custom -->
    <link rel="stylesheet" href="./css/profile.css">

    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">

        <header class=" header border-bottom shadow-sm" id="header" style="z-index: 999999;">
            <div class="header_toggle">
                <i class="ri-menu-fold-4-line" id="header-toggle"></i>
            </div>
            <div class="d-flex flex gap-3 align-items-center">
                <span class="ts-uppper text-primary fw-bold"><?= $profile['nama'] ?></span>
                <div class="header_img">
                    <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                        alt="<?= $profile["nama"] ?>">
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
                        <a href="index.php" class="nav_link ">
                            <i class="ri-dashboard-horizontal-line nav_icon"></i>
                            <span class="nav_name ">Dashboard</span>
                        </a>
                        <a href="profil_pengemudi.php" class="nav_link active ">
                            <i class="ri-user-line nav_icon"></i>
                            <span class="nav_name">Users</span>
                        </a>
                        <a href="informasi_pemesanan.php" class="nav_link ">
                            <i class="ri-notification-line nav_icon"></i>
                            <span class="nav_name">Messages</span>
                        </a>
                        <a href="proses_perjalanan.php" class="nav_link ">
                            <i class="ri-map-pin-user-fill nav_icon"></i>
                            <span class="nav_name">Messages</span>
                        </a>
                       
                    </div>
                </div>
                <div>

                </div>

                <div>
                    <a href="../../controller/php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                        <i class="ri-switch-line nav_icon"></i>
                        <span class="nav_name">Switch Role</span>
                    </a>

                    <!-- Redirect To Login Form -->
                    <a href="../../controller/php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                        <i class="ri-logout-box-line nav_icon"></i>
                        <span class="nav_name">SignOut</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!--Container Main start-->
        <div class="container">

            <!-- Modal -->
            <div class="modal fade" id="cropImage" tabindex="-1" aria-labelledby="cropImage" aria-hidden="true"
                style="width: 100vw !important; ">
                <div class="modal-dialog modal-dialog-centered mt-3">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cropImage">Edit Gambar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="croppieContaier">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cropBtnDismis"
                                onclick="">Close</button>
                            <button type="button" class="btn btn-primary" id="cropBtn">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        <div class="flex-1 flex flex-col">
        
        <!-- Header -->
        <div class="bg-white-900 h-24">
        </div>
        
        <div class="bg-white flex-1 p-8">
            <div class="flex items-center space-x-4">
            <img alt="Profile picture of a person" class="w-24 h-24 rounded-full object-cover" height="100" src="https://storage.googleapis.com/a1aa/image/jezXiyYMvwVSYCBPMcDonb3iMnNvbyTCNsjOcj3sLrnZAfpTA.jpg" width="100"/>
            <div>
            <h1 class="text-2xl font-bold">
                inYrDim
            </h1>
            <p class="text-gray-600">
                inyrdim@ilalin.com
            </p>
            </div>
            <button> 
            <input type="file" id="fileInput" style="display: none;"
                                onchange="changePhoto(event)">
                                <a onclick="document.getElementById('fileInput').click();" data-bs-toggle="modal"
                                data-bs-target="#cropImage" style="background-color:#D9D9D9; color: black; border-radius:10px; padding-inline:20px; padding-block:12px;">Edit Foto</a>
                            </div>
                            
        </button>
    
        
                
            </li>
        
        </ul>
        <div style="margin-top:20px;">
                        <div style="display:flex; gap:90px;border-bottom:3px solid #3B5D50; padding-bottom: 2px;">
                            <a href="edit_profil_pengemudi.php" style="color:black; font-weight:400;">Profile</a>
                            <a href="password_pengemudi.php">Password</a>
                        
                        </div>
        <div style="margin-top:20px; display:flex; flex-direction:column; gap:30px; color:black; padding-left: 30px;">
                            <div style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                                <div style="font-weight:500;">Nama Lengkap</div>
                                <div><?= $profile["nama"] ?></div>
                            </div>
                            <div style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                                <div style="font-weight:500;">Nama Pengguna</div>
                                <div><?= $profile["username"] ?></div>
                            </div>
                            <div style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                                <div style="font-weight:500;">Email</div>
                                <div><?= $profile["email"] ?></div>
                            </div>
                            <div style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                                <div style="font-weight:500;">Nomor Telepon</div>
                                <div><?= $profile["nomor_telepon"] ?></div>
                            </div>
                            <div style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                                <div style="font-weight:500;">Alamat</div>
                                <div><?= $profile["alamat"] ?></div>
                            </div>
                            <div style="display:flex; justify-content: end; margin-top: 20px;">
                            <a href="edit_profil_pengemudi.php" style="background-color:#37574B; color: white; border-radius:10px; padding-inline:20px; padding-block:10px;">Edit Profile</a>
                        </div>
        </div>
        

            </div>
    </div>

    <!-- vendor -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
        <script src="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.js"
        integrity="sha256-noEeBltqVSH78NQZV6+oF9BnLEtCY7cKc0U90dQVF6c=" crossorigin="anonymous">
        </script>
        <!-- Sidebar -->
        <script src="../script/sidebar.js"></script>

        <!-- Custom -->
        <script src="../script/profile/custom.js"></script>
</body>

</html>


<?php
} else {
    echo "ss";
    exit();
}
?>