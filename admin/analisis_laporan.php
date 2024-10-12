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

        <div class="pagetitle">
            <h1>Analisis dan Laporan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="col-12">
            <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                    <h5 class="card-title lh-1 fs-3">Laporan Kinerja</h5>
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">No Hp</th>
                                <th scope="col">Rating</th>
                                <th scope="col">Jumalah Perjalanan</th>
                                <th scope="col">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Fachrul</td>
                                <td>08123456789</td>
                                <td>4.5/5</td>
                                <td>10</td>
                                <td>Rp 100.000</td>
                            </tr>
                            <tr>
                                <td>Adam</td>
                                <td>08123457000</td>
                                <td>4.2/5</td>
                                <td>8</td>
                                <td>Rp 80.000</td>
                            </tr>
                            <tr>
                                <td>Johan</td>
                                <td>08123454369</td>
                                <td>4.8/5</td>
                                <td>12</td>
                                <td>Rp 120.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
        .table thead th {
            background-color: #6b8f6c;
            /* Warna hijau pada header */
            color: white;
            /* Warna teks putih */
            text-align: center;
            /* Teks berada di tengah */
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Warna latar belakang abu-abu untuk baris genap */
        }

        .table tbody tr:hover {
            background-color: #ddd;
            /* Warna saat baris di hover */
            cursor: pointer;
        }

        .table td,
        .table th {
            padding: 12px 15px;
            /* Padding pada sel */
            text-align: center;
            /* Teks berada di tengah */
        }

        .table tbody td:nth-child(5) {
            font-weight: bold;
            /* Menonjolkan kolom Pendapatan */
            color: #000;
            /* Warna teks Pendapatan */
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan pada card */
            border-radius: 10px;
            /* Sudut yang melengkung */
        }

        .card-body {
            background-color: #fff;
            /* Latar belakang putih */
            padding: 20px;
            /* Padding untuk body */
        }

        h5.card-title {
            font-size: 24px;
            /* Ukuran font judul */
            font-weight: 700;
            /* Ketebalan font */
            margin-bottom: 5px;
            /* Jarak bawah judul */
            color: #333;
            /* Warna teks */
        }
        </style>

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