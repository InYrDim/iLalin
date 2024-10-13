<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Perjalanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="">
    <style>
        body {
           
            background-size: cover;
        }
        .overlay {
            background-color: rgba(255 255 255);
            height: 100vh;
            padding: 50px;
        }
        .form-container {
            background-color: rgba(104 172 120);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(17 133 37);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <h2 class="text-center text-dark mb-4">Proses Pemesanan</h2>
                    <form action="pembayaran.php" method="post">
                        <!-- Tujuan -->
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Perjalanan</label>
                            <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                        </div>

                        <!-- Tanggal dan Waktu -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Perjalanan</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label for="waktu" class="form-label">Waktu Perjalanan</label>
                            <input type="time" class="form-control" id="waktu" name="waktu" required>
                        </div>

                        <!-- Opsi Transportasi -->
                        <div class="justify-content-center">
                            <div class="mb-3 form-control d-flex align-items-center">
                                <img src="../images/mobil/avanza_merah.png" alt="" width="50px" height="50px" class="me-3">
                                <div class="info">
                                    <span id="nama">Ahmad Dahlan</span>
                                    <br>
                                    <span id="nohp">081234567890</span>
                                    <br>
                                    <span id="nokendaraan">DD1945KL</span>
                                    <br>
                                    <div class=" bg-success p-2 text-white bg-opacity-75">
                                        <span id="jumlahpembayaran">Rp 125.000</span>
                                    </div>
                                </div>
                                <input type="radio" name="pilihan" id="pilihan1" class="ms-auto">
                                <label for="pilihan1" class="ms-2">Pilih</label>
                            </div>
                        </div>

                        <div class="justify-content-center">
                            <div class="mb-3 form-control d-flex align-items-center">
                                <img src="../images/mobil/avanza_silver.jpg" alt="" width="50px" height="50px" class="me-3">
                                <div class="info">
                                    <span id="nama">Suprianto</span>
                                    <br>
                                    <span id="nohp">0859036488</span>
                                    <br>
                                    <span id="nokendaraan">DD2018AF</span>
                                    <br>
                                    <div class=" bg-success p-2 text-white bg-opacity-75">
                                        <span id="jumlahpembayaran">Rp 130.000</span>
                                    </div>
                                </div>
                                <input type="radio" name="pilihan" id="pilihan2" class="ms-auto">
                                <label for="pilihan2" class="ms-2">Pilih</label>
                            </div>
                        </div>

                        <div class="justify-content-center">
                            <div class="mb-3 form-control d-flex align-items-center">
                                <img src="../images/mobil/avanza_biru.png" alt="" width="50px" height="50px" class="me-3">
                                <div class="info">
                                    <span id="nama">Dahlan</span>
                                    <br>
                                    <span id="nohp">08254897659</span>
                                    <br>
                                    <span id="nokendaraan">DP5784NR</span>
                                    <br>
                                    <div class=" bg-success p-2 text-white bg-opacity-75">
                                        <span id="jumlahpembayaran">Rp 128.000</span>
                                    </div>
                                </div>
                                <input type="radio" name="pilihan" id="pilihan3" class="ms-auto">
                                <label for="pilihan3" class="ms-2">Pilih</label>
                            </div>
                        </div>
                        

                        <!-- ... (rest of the code remains the same) ... -->

                    <!-- Tombol Kirim -->
                    <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#paymentModal">Pesan Sekarang</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>