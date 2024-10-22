<?php
session_start();

include '../../controller/php/database.php';
$email = $_SESSION['email'];

if(isset($email)) {
    $db = new Database();
    $profile = $db->fetch('users', '*', 'email = ?',[$email]);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        function prosesJumlahPembayaran() {
        }
        
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Should Destroy the session
        if(isset($_SESSION['snapToken']) && isset($_GET['token'])) {
            $snapToken = $_SESSION['snapToken'];
            $_SESSION['snapToken'] = null;
    
            echo $snapToken;
            exit();
        } else if (isset($_GET['order_id'])) {
            exit();
        }
    
    }
?>
<!DOCTYPE html>
<html lang="id">


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
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/profile.css">
    <title>iLalin</title>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>

</head>

<body>
    <div id="">
        <header>
            <div class="d-flex justify-content-between bg-white p-3">
                <a href="" class="nav_logo">
                    <span class="nav_logo-name fw-bold fs-3">iLalin</span>
                </a>
                <div class="d-flex flex gap-3 align-items-center">
                    <span class="text-primary fw-bold "><?= $profile['nama'] ?></span>
                    <div class="header_img">
                        <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                            alt="<?= $profile["nama"] ?>" style="width: 36px; border-radius: 100%; aspect-ratio: 1/1;">
                    </div>

                </div>
            </div>
        </header>
        <div id="snap-container"
            style="display: none; position: fixed; z-index: 9999; inset: 0px; place-items: center;backdrop-filter: brightness(50%);">
        </div>
        <div
            style="display: flex; flex-direction: column; justify-content: center; padding-top: 40px; max-width: 1000px; margin-inline: auto;">
            <h2>Detail Perjalanan Anda</h2>
            <div style="display: flex; justify-content:space-between; gap: 40px; margin-top: 40px;">
                <!-- Bagian kiri -->
                <div
                    style="width: 50%; line-height: 0.7; border: 1px solid black; display: flex; flex-direction: column; gap: 1rem; padding: 1rem; border-radius: 10px;">
                    <p class="info-row"><span class="info-label"><strong>Nama:</strong></span> <span class="info-value"
                            data-user="fullname">Muh. Dimas Januardi Nur</span></p>
                    <p class="info-row"><span class="info-label"><strong>Nomor Telepon:</strong></span> <span
                            class="info-value" data-user="no_telepon">081524606995</span></p>
                    <p class="info-row"><span class="info-label"><strong>Titik Jemput:</strong></span> <span
                            class="info-value" data-user="start_point">Makassar</span></p>
                    <p class="info-row"><span class="info-label"><strong>Tujuan:</strong></span> <span
                            class="info-value" data-user="end_point">Pinrang</span></p>
                    <p class="info-row"><span class="info-label"><strong>Jarak:</strong></span> <span class="info-value"
                            data-user="length">180km</span></p>
                </div>

                <!-- Bagian kanan -->
                <div
                    style="width: 50%; line-height: 0.7; border: 1px solid black; display: flex; gap: 1rem; padding: 1rem; border-radius: 10px;">
                    <div style="line-height: 0.5;">
                        <p style="font-weight: bold;">Supir</p>
                        <div style="margin-top: 2rem;">
                            <p style="font-size: 2em;" data-user="fullname_driver">Ardiansyah</p>
                            <p data-user="phone_driver">081524606995</p>
                        </div>
                        <div style="margin-top: 2rem;">
                            <p>Avanza</p>
                            <p>DD 1234 LL</p>
                        </div>
                    </div>
                    <div style="">
                        <img src="../../admin/assets/img/messages-2.jpg" alt="Foto Sopir" class="driver-photo">
                    </div>
                </div>
            </div>

            <div class="payment-section d-flex justify-content-between align-items-center"
                style="border: 1px solid black; border-radius: 10px; margin-top: 40px; padding: 10px;">
                <div>
                    <h3>Total Pembayaran</h3>
                    <p class="total-payment" id="payment_amount">Rp. 180.000</p> <!-- Ukuran font diperbesar -->
                </div>
            </div>

            <div class="btn-container d-flex justify-content-end mt-3 gap-2">
                <button type="button" class="btn btn-danger" style="border-radius: 10px;" id="cancelBtn" data-order_id
                    disabled>Batal</button>
                <button type="button" class="btn btn-success" style="border-radius: 10px;"
                    id="pay-button">Bayar</button>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-75iUAElAx67168zX"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', async function() {

        let parameter = {
            "transaction_details": {
                "order_id": "YOUR-ORDERID-123456",
                "gross_amount": 10000
            },
            "credit_card": {
                "secure": true
            },

        };
        console.log(payment_amount);
        const getToken = await fetch('../../controller/php/payment/prosesMidtrans.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "customer_details": {
                    "first_name": "ahmad",
                    "last_name": "pratama",
                    "email": "budi.pra@example.com",
                    "phone": "08111222333"
                }
            })
        })
        const snapContainer = document.getElementById('snap-container');
        snapContainer.style.display = 'grid';

        const cancelBtn = document.getElementById('cancelBtn');

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

                snapContainer.style.display = 'none';

                cancelBtn.removeAttribute('disabled')
                cancelBtn.dataset.order_id = result.order_id;
                cancelBtn.addEventListener('click', async function() {
                    const response = await fetch(
                        `../../controller/php/payment/prosesMidtrans.php?order_id=${result.order_id}`
                    )
                    if (response.ok) {
                        const data = await response
                            .json(); // Use json() since the response is a JSON object

                        console.log(data);
                        if (data.status_code === '200') {
                            alert("Payment cancelled!");
                            fetch("gateway.php?token=" + token).then(function(
                                response) {
                                window.location.href = "../index.php";
                            })
                        }
                    } else {
                        console.error('HTTP Error:', response.statusText);
                    }
                    cancelBtn.setAttribute('disabled', true);
                })
            },
            onError: function(result) {
                alert("payment failed!");
                console.log(result);
            },
            onClose: function(e) {
                fetch("gateway.php?token=" + token);
                snapContainer.style.display = 'none';
            }
        });
    });
    </script>



</body>

</html>

<?php 
} else {
    header(header: "Location: ../auth/login.php");
    exit();
}
?>