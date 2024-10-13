<!-- payment.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-size: cover;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center text-dark mb-4">Pembayaran</h2>
    <form action="#" method="post">
        <!-- Metode Pembayaran -->
        <div class="mb-3">
            <label for="metodepembayaran" class="form-label">Metode Pembayaran</label>
            <select class="form-select" id="metodepembayaran" name="metodepembayaran" required>
                <option value="">Pilih</option>
                <option value="COD">COD</option>
                <option value="BCA">BCA</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
                <option value="Mandiri">Mandiri</option>
                <option value="OVO">OVO</option>
                <option value="Dana">Dana</option>
                <option value="Gopay">Gopay</option>
            </select>
        </div>

        <!-- Tombol Bayar -->
        <button type="submit" class="btn btn-primary w-100">Bayar Sekarang</button>
    </form>
</div>

</body>
</html>