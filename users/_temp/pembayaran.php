<?php

session_start();

include '../controller/php/database.php';

$userId = [];

$db = new Database();
// Midtrans Snap Methods
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    function prosesJumlahPembayaran() {
    }
    
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Should Destroy the session
    if(isset($_SESSION['snapToken']) && isset($_GET['token'])) {
        $snapToken = $_SESSION['snapToken'];
        $_SESSION['snapToken'] = null;

        
        //data token mau dikirim ke database
        echo $snapToken;
        exit();
    } else if (isset($_GET['order_id'])) {
        // $queries = array();
        // parse_str($_SERVER['QUERY_STRING'], $queries);
        // var_dump($queries);
        

        // // Update Data Pembayaran Database
        // $checkTransactionId = $db->fetch('payments', "id_pembayaran", "id_pembayaran = ?", [$queries['transaction_id']]);

        // if($checkTransactionId) {
        //     //transaction already exist, redirect to home page or error page
        //     $updateTransactionStatus = $db->update('payments', ['transaction_status' => $queries['transaction_status']], 'id_pembayaran = ?', [$queries['transaction_id']]);


        //     echo "Transaction ID already exist";
        //     exit();
        // }
        // $data = [
        //     'id_pembayaran ' => $queries['transaction_id'],
        //     'id_pemesanan' => $queries['order_id'],
        //     'metode_pembayaran' => $queries['payment_type'],
        //     'jumlah_pembayaran' => $queries['gross_amount'],
        //     'tanggal_pembayaran' => $queries['transaction_time'],
        //     'token_pembayaran' => $_SESSION['snapToken'],
        //     'transaction_status' => $queries['transaction_status'],
        // ];
        // $updateTransactionStatus = $db->insert('payments', $data);

        exit();
    }

}
?>
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
        <div>
            <h4>Total Pembayaran</h4>
            <div id="jumlahTotalPembayaran">Rp. 150.000</div>
        </div>
        <br>
        <div id="snap-container"></div>
        <!-- Tombol Bayar -->
        <button type="submit" class="btn btn-primary w-100" id="pay-button">Bayar Sekarang</button>

    </div>

    <!-- Vendor -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-75iUAElAx67168zX"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', async function() {
        const getToken = await fetch('../controller/php/payment/prosesMidtrans.php', {
            method: 'POST'
        })
        const token = await getToken.text();
        window.snap.embed(token, {
            embedId: 'snap-container',
            onSuccess: function(result) {
                fetch("pembayaran.php?token=" + token);
            },
            onPending: function(result) {
                const urlParams = new URLSearchParams(result)
                const url = "pembayaran.php?" + urlParams.toString();
                fetch(url)
            },
            onError: function(result) {
                alert("payment failed!");
                console.log(result);
            },
            onClose: function(e) {
                fetch("pembayaran.php?token=" + token);
                alert('you closed the popup without finishing the payment');
            }
        });
    });
    </script>
</body>

</html>