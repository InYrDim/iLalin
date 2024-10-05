<?php
session_start();

include '../php/database.php'  ;

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
    
    $profile = $db->fetch('users', "id_pengguna, nama, email nomor_telepon, peran, profile_image", 'email = ?', [$email]);

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
    <link href="../admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
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
    <link href="../css/tiny-slider.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/sidebar.css">

    <!-- Custom -->
    <link rel="stylesheet" href="./css/profile.css">

    <title>iLalin</title>
</head>

<body>

    <div id="body-pd">

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


        <header class="header border-bottom shadow-sm" id="header" style="z-index: 999999;">
            <div class="header_toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="d-flex flex gap-3 align-items-center">
                <span class="ts-uppper"><?= $profile['nama'] ?></span>
                <div class="header_img">
                    <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                        alt="">
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
                            <span class="nav_name">Dashboard</span>
                        </a>
                        <a href="profile.php" class="nav_link active">
                            <i class="ri-user-line nav_icon"></i>
                            <span class="nav_name">Users</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class="ri-message-2-line nav_icon"></i>
                            <span class="nav_name">Messages</span>
                        </a>
                        <a href="#" class="nav_link">
                            <i class="ri-settings-5-line nav_icon"></i>
                            <span class="nav_name">Settings</span>
                        </a>
                    </div>
                </div>
                <div>

                </div>
                <div>
                    <a href="../php/utils/session.destroy.php?home=../../auth/login.php" class="nav_link">
                        <i class="ri-switch-line nav_icon"></i>
                        <span class="nav_name">Switch Role</span>
                    </a>
                    <a href="../php/utils/session.destroy.php?home=../../auth/login.php" class="nav_link">
                        <i class="ri-logout-box-line nav_icon"></i>
                        <span class="nav_name">SignOut</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!--Container Main start-->
        <div class="container">

            <div class="row gutters-sm pt-5">
                <div class="col-md-4 mb-3">
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
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Saldo Dompet Digital</h6>
                                <span class="text-secondary">Rp 500,000</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Status Akun</h6>
                                <span class="text-secondary">Aktif</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-8">

                    <div>
                        <div class="mb-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nama Lengkap</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $profile['nama'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $profile['email'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $profile['nomor_telepon'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Alamat</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            Sulawesi Selatan, Indonesia
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">

                                <h6 class="d-flex align-items-center mb-3"><i
                                        class="material-icons text-info mr-2"></i>Riwayat Perjalanan</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h6>Makassar - Bulukumba</h6>
                                        <span class="text-secondary">12 Sep 2024, 10:00 AM - Rp 200,000</span>
                                    </li>
                                    <li class="list-group-item">
                                        <h6>Pinrang - Toraja</h6>
                                        <span class="text-secondary">15 Sep 2024, 2:00 PM - Rp 350,000</span>
                                    </li>
                                    <li class="list-group-item">
                                        <h6>Parepare - Makassar</h6>
                                        <span class="text-secondary">20 Sep 2024, 8:00 AM - Rp 250,000</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Profile Details Section -->
                <div class="card mt-3">
                    <div class="card-body">
                        <!-- Verifikasi Akun -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Status Verifikasi</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Terverifikasi (KTP)
                            </div>
                        </div>
                        <hr>

                        <!-- Poin Pengguna -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Poin Pengguna</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                450 Poin (Gold Member)
                            </div>
                        </div>
                        <hr>

                        <!-- Ulasan dan Rating -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Rating Pengguna</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                ★★★★★ 4.8 (Based on 50 reviews)
                            </div>
                        </div>
                        <hr>

                        <!-- Keamanan Akun (2FA) -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Keamanan</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Autentikasi Dua Faktor Aktif
                            </div>
                        </div>
                        <hr>

                        <!-- Riwayat Transaksi -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Riwayat Transaksi</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <a href="transaction-history.html">Lihat semua transaksi Anda di sini.</a>
                            </div>
                        </div>
                        <hr>

                        <!-- Preferensi Kendaraan -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Preferensi Kendaraan</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Mobil dengan AC, Mobil Ramah Lingkungan
                            </div>
                        </div>
                        <hr>

                        <!-- Kontak Darurat -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Kontak Darurat</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                +62 812-3456-7890 (Ibu)
                            </div>
                        </div>
                        <hr>

                        <!-- Metode Pembayaran -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Metode Pembayaran</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Kartu Kredit, OVO, DANA
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- vendor -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    < <script src="https://cdn.jsdelivr.net/npm/croppie@2.6.5/croppie.min.js"
        integrity="sha256-noEeBltqVSH78NQZV6+oF9BnLEtCY7cKc0U90dQVF6c=" crossorigin="anonymous">
        </script>
        <!-- Sidebar -->
        <script src="script/sidebar.js"></script>

        <!-- Custom -->
        <script src="./script/profile/custom.js"></script>
</body>

</html>


<?php
} else {
    echo "ss";
    exit();
}
?>