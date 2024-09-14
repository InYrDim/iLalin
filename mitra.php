<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
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
    <link href="admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="css/tiny-slider.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <title>iLalin</title>
</head>

<body>
    <!-- Start Header/Navigation -->
    <?php include_once './components/header.php' ?>
    <!-- End Header/Navigation -->

    <!-- Start Hero Section -->
    <div class="hero bg-mitra">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Bergabung Sebagai Mitra</h1>
                        <p class="mb-4">
                            Bergabunglah dengan komunitas pengemudi iLalin dan nikmati
                            berbagai keuntungan. Kami menyediakan platform yang mudah
                            digunakan, dukungan 24/7, dan peluang penghasilan yang menarik
                        </p>
                        <a href="auth/login.html" class="btn btn-secondary me-2 shadow-sm">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section shadow">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <h2 class="section-title">Langkah-Langkah Bergabung</h2>
                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="ri-survey-line text-dark fs-1"></i>
                                </div>
                                <h3>1. Daftar Online</h3>
                                <p>
                                    Isi formulir pendaftaran online dengan data diri dan dokumen
                                    yang diperlukan.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="ri-file-check-line text-dark fs-1"></i>
                                </div>
                                <h3>2. Verifikasi Dokumen</h3>
                                <p>Nikmati kemudahan dan keamanan dalam setiap transaksi</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="ri-graduation-cap-line text-dark fs-1"></i>
                                </div>
                                <h3>3. Pelatihan dan Orientasi</h3>
                                <p>
                                    Ikuti pelatihan online untuk memahami cara kerja dan standar
                                    layanan iLalin.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <i class="ri-check-double-fill text-dark fs-1"></i>
                                </div>
                                <h3>4. Aktivasi Akun</h3>
                                <p>
                                    Setelah verifikasi dan pelatihan selesai, akun Anda akan
                                    diaktifkan dan siap menerima pesanan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Apa Kata Pengemudi Kami?</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">
                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider" id="our_mitra">
                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>
                                                    &ldquo;iLalin memberikan nilai tambah yang
                                                    signifikan bagi saya, terutama dalam hal pengaturan
                                                    waktu kerja yang mandiri. Skema kerja fleksibel yang
                                                    ditawarkan memungkinkan saya mengoptimalkan
                                                    produktivitas sambil memperoleh pendapatan tambahan
                                                    yang potensial.&rdquo;
                                                </p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="images/Supir/tr-profile-1.jpg" alt="Setyadi"
                                                        class="img-fluid" />
                                                </div>
                                                <h3 class="font-weight-bold">Setyadi</h3>
                                                <span class="position d-block mb-3">Mitra Asal Makassar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->

    <!-- Start Footer Section -->
    <?php include_once './components/footer.php'; ?>
    <!-- End Footer Section -->

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>