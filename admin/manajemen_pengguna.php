<?php
include '../php/middleware.php';
include '../php/connection.php';
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Ilalin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../images/logo/logo-ilalin.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <?php include_once './components/header.php' ?>

    <main id="main" class="main">


        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </nav>
        </div><!-- End Page Title -->
        <style>
        .order-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
        }

        .user-info {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-info i {
            margin-right: 5px;
        }

        .order-time,
        .order-location,
        .order-price {
            display: flex;
            align-items: center;
        }

        .order-time,
        .order-location {
            color: #555;
        }

        .order-price {
            color: #28a745;
            font-weight: bold;
        }

        .btn-small {
            font-size: 12px;
            padding: 5px 10px;
        }
        </style>


        <!-- Kartu Riwayat Pemesanan 1 -->
        <div class="order-card" id="order1">
            <div class="user-info">
                Jennie | 081234567890
            </div>
            <div class="order-info">
                <div class="order-time">
                    <i class="fas fa-clock"></i> 12:30
                </div>
                <div class="order-location">
                    <i class="fas fa-map-marker-alt"></i> Makassar
                    <i class="fas fa-arrow-right mx-2"></i> Gowa
                </div>
                <div class="order-price">
                    Rp 200.000
                </div>
            </div>
            <div class="order-action">
                <button class="btn btn-warning btn-small" onclick="editOrder('order1')"><i class="fas fa-edit"></i>
                    Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteOrder('order1')"><i class="fas fa-trash"></i>
                    Delete</button>
                <button class="btn btn-success btn-small" onclick="updateOrder('order1')"><i class="fas fa-check"></i>
                    Update</button>
            </div>
        </div>

        <!-- Kartu Riwayat Pemesanan 2 -->
        <div class="order-card" id="order2">
            <div class="user-info">
                Justin Bieber | 082345678901
            </div>
            <div class="order-info">
                <div class="order-time">
                    <i class="fas fa-clock"></i> 14:00
                </div>
                <div class="order-location">
                    <i class="fas fa-map-marker-alt"></i> Gowa
                    <i class="fas fa-arrow-right mx-2"></i> Takalar
                </div>
                <div class="order-price">
                    Rp 100.000
                </div>
            </div>
            <div class="order-action">
                <button class="btn btn-warning btn-small" onclick="editOrder('order2')"><i class="fas fa-edit"></i>
                    Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteOrder('order2')"><i class="fas fa-trash"></i>
                    Delete</button>
                <button class="btn btn-success btn-small" onclick="updateOrder('order2')"><i class="fas fa-check"></i>
                    Update</button>
            </div>
        </div>

        <!-- Kartu Riwayat Pemesanan 3 -->
        <div class="order-card" id="order3">
            <div class="user-info">
                Ariana Grande | 083456789012
            </div>
            <div class="order-info">
                <div class="order-time">
                    <i class="fas fa-clock"></i> 08:00
                </div>
                <div class="order-location">
                    <i class="fas fa-map-marker-alt"></i> Bulukumba
                    <i class="fas fa-arrow-right mx-2"></i> Sinjai
                </div>
                <div class="order-price">
                    Rp 250.000
                </div>
            </div>
            <div class="order-action">
                <button class="btn btn-warning btn-small" onclick="editOrder('order3')"><i class="fas fa-edit"></i>
                    Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteOrder('order3')"><i class="fas fa-trash"></i>
                    Delete</button>
                <button class="btn btn-success btn-small" onclick="updateOrder('order3')"><i class="fas fa-check"></i>
                    Update</button>
            </div>
        </div>
        </div>

        <!-- Kartu Riwayat Pemesanan 4 -->
        <div class="order-card" id="order3">
            <div class="user-info">
                P.diddy | 083456789012
            </div>
            <div class="order-info">
                <div class="order-time">
                    <i class="fas fa-clock"></i> 08:00
                </div>
                <div class="order-location">
                    <i class="fas fa-map-marker-alt"></i> Pinrang
                    <i class="fas fa-arrow-right mx-2"></i> Makassar
                </div>
                <div class="order-price">
                    Rp 150.000
                </div>
            </div>
            <div class="order-action">
                <button class="btn btn-warning btn-small" onclick="editOrder('order3')"><i class="fas fa-edit"></i>
                    Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteOrder('order3')"><i class="fas fa-trash"></i>
                    Delete</button>
                <button class="btn btn-success btn-small" onclick="updateOrder('order3')"><i class="fas fa-check"></i>
                    Update</button>
            </div>
        </div>
        </div>


        <script>
        // Fungsi Edit Pesanan
        function editOrder(orderId) {
            alert("Edit Pesanan untuk " + orderId);
            // Di sini, Anda bisa menambahkan logika untuk membuka modal atau form pengeditan
        }

        // Fungsi Delete Pesanan
        function deleteOrder(orderId) {
            var orderCard = document.getElementById(orderId);
            orderCard.remove();
            alert("Pesanan " + orderId + " telah dihapus.");
        }

        // Fungsi Update Pesanan
        function updateOrder(orderId) {
            alert("Pesanan " + orderId + " telah diperbarui.");
            // Di sini, Anda bisa menambahkan logika untuk menyimpan perubahan pesanan
        }
        </script>



    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>