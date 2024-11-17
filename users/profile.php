<?php
session_start();



// include '../controller/php/database.php';
include '../controller/php/ilalin.php';

// validate is user logged in
include('../controller/php/utils/validation/session_validator.php');

$active_page = "users";
$email = $_SESSION['email'];


    $ilalin = new IlalinApp();
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Checkcropper.toStringf the file is uploaded
        $json_data = json_decode(file_get_contents('php://input'), true);
        $imageString = $json_data['image'];
        
        // update/replace image
        $ilalin->replaceImage($email, $imageString);
        
    }
    
    $userProfile = $ilalin->getUserProfile($email);
    $profile = $userProfile;
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
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
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
    <link href="../assets/css/tiny-slider.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/sidebar.css">

    <!-- Custom -->
    <link rel="stylesheet" href="./css/profile.css">

    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">

        <?php include_once './components/header.php'; ?>

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

            <div style="">
                <div
                    style="background-color: #23321F; height: 230px; position: absolute; bottom:90%; left:0; right:0; z-index: -100;">
                </div>
                <div style="margin-top: 200px;">
                    <img id="profileImage"
                        src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                        style="border-radius:100%;overflow:hidden; widht:160px; height:160px;" alt="">
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:30px;">
                    <div>
                        <h3 style="line-height:0.70; font-weight:700; color:black;"><?= $profile["username"] ?></h3>
                        <span><?= $profile["email"] ?></span>
                    </div>
                    <div>
                        <input type="file" id="fileInput" style="display: none;" onchange="changePhoto(event)">
                        <a onclick="document.getElementById('fileInput').click();" data-bs-toggle="modal"
                            data-bs-target="#cropImage"
                            style="background-color:#D9D9D9; color: black; border-radius:10px; padding-inline:20px; padding-block:12px;">Edit
                            Foto</a>
                    </div>
                </div>
                <div style="margin-top:20px;">
                    <div style="display:flex; gap:90px;border-bottom:3px solid #3B5D50; padding-bottom: 2px;">
                        <a href="profile.php" style="color:black; font-weight:400;">Profile</a>
                        <a href="keamanan.php">Password</a>
                        <a href="pembayaran.php">Pembayaran</a>
                    </div>
                    <div
                        style="margin-top:20px; display:flex; flex-direction:column; gap:30px; color:black; padding-left: 30px;">
                        <div
                            style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                            <div style="font-weight:500;">Nama Lengkap</div>
                            <div><?= $profile["nama"] ?></div>
                        </div>
                        <div
                            style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                            <div style="font-weight:500;">Nama Pengguna</div>
                            <div><?= $profile["username"] ?></div>
                        </div>
                        <div
                            style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                            <div style="font-weight:500;">Email</div>
                            <div><?= $profile["email"] ?></div>
                        </div>
                        <div
                            style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                            <div style="font-weight:500;">Nomor Telepon</div>
                            <div><?= $profile["nomor_telepon"] ?></div>
                        </div>
                        <div
                            style="display:flex; justify-content: space-between; border-bottom: 2px solid #4D7767; padding-bottom: 10px;">
                            <div style="font-weight:500;">Alamat</div>
                            <div><?= $profile["alamat"] ?></div>
                        </div>

                    </div>
                    <div style="display:flex; justify-content: end; margin-top: 20px;">
                        <a href="profile_edit.php"
                            style="background-color:#37574B; color: white; border-radius:10px; padding-inline:20px; padding-block:10px;">Edit
                            Profile</a>
                    </div>
                </div>
            </div>

            <div class="row gutters-sm pt-5">
                <!-- <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                                    alt="User" id="profileImage">
                                <div class="mt-3">

                                    <h4><?= $profile['nama'] ?></h4>
                                    <p class="text-secondary mb-1"><?= $profile['email'] ?></p>
                                    <p class="text-muted font-size-sm">Sulawesi Selatan, Indonesia</p>
                                    <button class="btn btn-primary"
                                        onclick="document.getElementById('fileInput').click();" data-bs-toggle="modal"
                                        data-bs-target="#cropImage"><i class="ri-edit-box-line"></i> Edit Foto</button>
                                    <input type="file" id="fileInput" style="display: none;"
                                        onchange="changePhoto(event)">
                                </div>

                            </div>
                        </div>
                    </div>
                </div> -->


            </div>


        </div>
    </div>


    <!-- Metadata -->
    <input type="hidden" name="id_pengguna" value="<?= $userProfile['id_pengguna'] ?>">
    <input type="hidden" name="email" value="<?= $userProfile['email'] ?>">
    <input type="hidden" name="username" value="<?= $userProfile['username'] ?>">
    <!-- vendor -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.js"
        integrity="sha256-noEeBltqVSH78NQZV6+oF9BnLEtCY7cKc0U90dQVF6c=" crossorigin="anonymous">
    </script>
    <!-- Sidebar -->
    <script src="script/sidebar.js"></script>

    <!-- Custom -->
    <script src="./script/profile/custom.js"></script>
</body>

</html>