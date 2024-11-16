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
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap");
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../tailwind.config.js"></script>

    <title>iLalin</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

    </style>
    <title>Pembayaran</title>

</head>

<body>
    <div id="">
        <header>
            <div class="flex justify-between w-full bg-white p-3 border-b-2 border-black">
                <a href="" class="nav_logo">
                    <span class="nav_logo-name fw-bold text-3xl text-primary font-bold">iLalin</span>
                </a>
                <div class="flex gap-3 items-center">
                    <span class="text-primary fw-bold "><?= $profile['username'] ?></span>
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
            <h2 class="text-5xl font-bold ">Detail Perjalanan Anda</h2>
            <div class="flex w-full justify-between gap-8 mt-8">
                <!-- Bagian penumpang -->
                <div class="flex flex-col gap-4 flex-1">
                    <div class="border-2 border-black py-2 px-4 flex justify-between items-center rounded">
                        <span class="info-label"><strong class="font-light">Nama</strong></span>
                        <span class="info-value"
                            data-user="fullname"><?= isset($userProfile['nama']) ? $userProfile['nama'] : $userProfile['username'] ?></span>
                    </div>
                    <div class="border-2 border-black py-2 px-4 flex justify-between items-center rounded">
                        <span class="info-label"><strong class="font-light">Nomor Telepon</strong></span>
                        <span class="info-value" data-user="fullname"><?= $userProfile['nomor_telepon'] ?></span>
                    </div>

                    <div class="border-2 border-black flex flex-col py-3 pl-8 pr-2 rounded gap-1 relative">
                        <span class="bg-yellow-500 absolute top-0 bottom-0 w-4 left-0 block"></span>
                        <span class="info-label"><strong class="font-light text-black/80">Titik Jemput</strong></span>
                        <span class="text-xl"><?= $starting_point['name'] ?></span>
                        <span class="text-black/80"
                            data-user="start_point text-sm"><?= $starting_point['formatted_address'] ?></span>
                    </div>
                    <div class="border-2 border-black flex flex-col py-3 pl-8 pr-2 rounded gap-1 relative">
                        <span class="bg-primary absolute top-0 bottom-0 w-4 left-0 block"></span>
                        <span class="info-label"><strong class="font-light text-black/80">Tujuan</strong></span>
                        <span class="text-xl"><?= $finishing_point['name'] ?></span>
                        <span class="text-black/80 text-sm"
                            data-user="end_point"><?= $finishing_point['formatted_address'] ?></span>
                    </div>
                    <div class="flex justify-end gap-6">
                        <div class="flex justify-center items-center flex-col">
                            <div>
                                <i class="ri-pin-distance-line"></i>
                                <span class="info-label"><strong class="font-normal">Jarak</strong></span>
                            </div>
                            <span class="mt-1 text-xl font-bold" data-user="length"><?= $trips['distance'] ?> Km</span>
                        </div>
                        <div class="flex justify-center items-center flex-col">
                            <div class="">
                                <i class="ri-timer-line"></i>
                                <span class="info-label"><strong class="font-normal">Durasi</strong></span>
                            </div>
                            <span class="mt-1 text-xl font-bold" data-user="length"><?= $trips['time'] ?>min</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Supir -->
                <div class="flex flex-col gap-4 flex-1">
                    <div class=" flex justify-between rounded">
                        <div class="flex flex-col gap-4 py-3 px-5 border-2 border-black flex-1 bg-emerald-300 rounded">
                            <p class="px-2 bg-slate-200 text-primary text-md w-fit rounded">Driver</p>
                            <div class="">
                                <p class="font-bold text-3xl" data-user="fullname_driver">
                                    <?= $avaiable_driver['name'] ?>
                                </p>
                                <a target="_blank"
                                    href="https://wa.me/<?= $avaiable_driver['phone_number']?>?text=Saya%20ingin%20melakukan%20perjalanan"
                                    data-user="phone_driver" class="mt-1 font-medium text-primary">

                                    <i class="ri-whatsapp-line mr-1"> </i><?= $avaiable_driver['phone_number'] ?>
                                </a>
                            </div>
                            <div class="">
                                <p class="font-light text-xl text-emerald-800"><?= $driver_vehicle['vehicle_name'] ?>
                                </p>
                                <p class="font-bold text-xl text-primary">
                                    <?= $driver_vehicle['plate_number'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="aspect-square h-full ">

                            <img src="<?= strpos($avaiable_driver['profile_image'], 'data:image') === 0 ? $avaiable_driver['profile_image'] : 'data:image/jpeg;base64,' . $avaiable_driver['profile_image'] ?>"
                                alt="Foto Sopir" class="h-full aspect-square">
                        </div>
                    </div>
                    <div class="border-black border-2 pb-2 pr-4 flex justify-between  rounded">
                        <div class="flex flex-col justify-end p-4">
                            <div class="flex items-center gap-2 text-primary">
                                <i class="ri-wallet-line"></i>
                                <span>Status</span>
                            </div>
                            <span
                                class="text-xl text-yellow-500 bg-slate-200 rounded py-1 font-semibold px-4 mt-1"><?=$trips['status']?></span>
                        </div>
                        <div class="min-h-[100px] flex flex-col items-end justify-end mb-3">
                            <h3 class="text-xl font-normal text-black/80">Total Pembayaran</h3>
                            <p class="total-payment text-4xl text-primary font-bold mt-2" id="payment_amount">
                                <?= $total_payment ?></p>
                        </div>
                    </div>

                    <div class="flex gap-2 w-full justify-end">
                        <?php if($trips['status'] === 'ongoing'): ?>
                        <button type="button"
                            class="py-2 px-5 bg-rose-500 text-white hover:bg-rose-300 hover:text-rose-600 rounded"
                            id="cancelBtn" data-order_id>Kembali</button>
                        <?php else: ?>
                        <button type="button"
                            class="py-2 px-5 bg-rose-500 text-white hover:bg-rose-300 hover:text-rose-600 rounded"
                            id="cancelBtn" data-order_id>Kembali</button>
                        <button type="button"
                            class="py-2 px-5 bg-primary text-white hover:bg-emerald-300 hover:text-emerald-600 rounded"
                            id="pay-button">Bayar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>




        </div>
    </div>

    <input type="hidden" id="trip_id" value="<?= $_POST['trip_id'] ?>">
    <input type="hidden" id="order_id" value="<?= $trips['order_id'] ?>">
    <input type="hidden" id="gross_amount" value="<?= $trips['total_payment'] ?>">
    <input type="hidden" id="passenger_id" value="<?= $userProfile['username'] ?>">
    <input type="hidden" id="passenger_email" value="<?= $userProfile['email'] ?>">
    <input type="hidden" id="passenger_fullname" value="<?= $userProfile['nama'] ?>">
    <input type="hidden" id="passenger_phone" value="<?= $userProfile['nomor_telepon'] ?>">
    <input type="hidden" id="passenger_address" value="<?= $userProfile['alamat'] ?>">
    <input type="hidden" id="driver_id" value="<?= $avaiable_driver['driver_id'] ?>">
    <input type="hidden" id="driver_email" value="<?= $avaiable_driver['email'] ?>">
    <input type="hidden" id="driver_fullname" value="<?= $avaiable_driver['name'] ?>">
    <input type="hidden" id="driver_phone" value="<?= $avaiable_driver['phone_number'] ?>">
    <input type="hidden" id="vehicle_name" value="<?= $driver_vehicle['vehicle_name'] ?>">
    <input type="hidden" id="vehicle_plate_number" value="<?= $driver_vehicle['plate_number'] ?>">


    <!-- PopUp Alert -->


    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-75iUAElAx67168zX"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    const cancelBtn = document.getElementById('cancelBtn');

    function initialCancelBtn(e) {
        window.location.href =
            "../index.php"
    }
    cancelBtn.addEventListener("click", initialCancelBtn)

    async function handlePayment() {
        async function clearToken() {
            const clearToken = await fetch(
                '/controller/php/payment/tokenHandler.php', {
                    method: "POST",
                    body: JSON.stringify({
                        action: "delete"
                    })
                }
            )
            return await clearToken.json()
        }

        async function getToken() {
            const getTokenBody = {
                "transaction_details": {
                    "order_id": document.getElementById("order_id").value,
                    "gross_amount": Math.max(1000, parseInt(document.getElementById("gross_amount")
                        .value))
                },
                "credit_card": {
                    "secure": true
                },
                "customer_details": {
                    "passenger_details": {
                        "usernames": document.getElementById("passenger_id").value,
                        "name": document.getElementById("passenger_fullname").value,
                        "email": document.getElementById("passenger_email").value,
                        "phone": document.getElementById("passenger_phone").value,
                        "address": document.getElementById("passenger_address")
                            .value,
                    },
                    "driver_details": {
                        "name": document.getElementById("driver_fullname").value,
                        "email": document.getElementById("driver_email").value,
                        "phone": document.getElementById("driver_phone").value,
                    },
                    "vehicle_details": {
                        "vehicle_name": document.getElementById("vehicle_name")
                            .value,
                        "plate_number": document.getElementById(
                                "vehicle_plate_number")
                            .value,
                    }
                }
            }
            const token = await fetch('/controller/php/payment/tokenHandler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(getTokenBody)
            })
            return await token.json();
        }
        //check if current user is already had pending payment or not
        const token = await getToken();

        const snapContainer = document.getElementById('snap-container');
        snapContainer.style.display = 'grid';

        function enableCancelPayment(result) {

            async function handleCancelPayment() {

                const userConfirm = confirm(
                    'Yakin membatalkan perjalanan?');
                if (!userConfirm) return;

                // 1. Get The Transaction First
                // 2. Refunding the Transaction using transaction id that was previously get from transaction
                // 3. Update the Transaction status on database
                try {

                    const cancelPayment = await fetch(
                        `../../controller/php/paymentHandler.php`, {
                            method: 'POST',
                            body: JSON.stringify({
                                action: 'cancelPayment',
                                order_id: document.getElementById("order_id").value,
                            })
                        }
                    )
                    const refundData = await cancelPayment.json();

                    // using || cancelPayment.status == "200" to hanlder just for sanbox midtrans
                    // for production, remove it
                    if (refundData.status_code === '200' || cancelPayment
                        .status == "200") {
                        // refund successful
                        const clearTokenResponse = await clearToken();
                        if (clearTokenResponse.status !== "success") {
                            throw new Error("Failed to clear token");
                        }

                        // Update canceling on databse then update trip status in database
                        const updatePaymentStatus = fetch(
                                `../../controller/php/tripsHandler.php`, {
                                    method: 'POST',
                                    body: JSON.stringify({
                                        action: 'updateTripStatus',
                                        trip_id: document.getElementById("trip_id").value,
                                        status: "cancelled",
                                        clearToken: "yes"
                                    })
                                })
                            .then(resp => resp.json())
                            .then(data => {

                                document.body.innerHTML += `    <!-- Cancel Alert Componet -->
    <div id="alert-modal" tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="py-10 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Trip Cancelled Succesfully
                    </h3>
                </div>
            </div>
        </div>
    </div>`


                                setTimeout(() => {
                                    location.href = "../index.php";
                                }, 3000)
                            })

                    } else {
                        // refund failed
                        alert('Pembatalan trip gagal');
                    }
                } catch (error) {
                    console.log(error)
                }

            }

            cancelBtn.removeEventListener("click", initialCancelBtn)

            cancelBtn.innerText = "Batalkan Perjalanan"
            cancelBtn.dataset.order_id = result.order_id;
            cancelBtn.addEventListener('click', handleCancelPayment)

        }

        const snapOptions = {
            embedId: 'snap-container',
            onSuccess: async function(result) {
                // clear token
                const clearTokenResponse = await clearToken();

                if (clearTokenResponse.status !== 'success') {
                    console.log("Failed To Clear Token");
                    return;
                }

                const trip_id = document.getElementById("trip_id").value

                // Update database by adding driver information
                const updatePaymentStatus = await fetch(
                    `__test_gateway.php`, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            trip_id: trip_id,
                            status: "ongoing",
                            driver_id: document.getElementById("driver_id")
                                .value
                        })
                    })

                const paymentStatusRespons = await updatePaymentStatus.json()

                console.log(paymentStatusRespons)
                if (paymentStatusRespons.status == 'success') {
                    window.location.href = "../index.php"
                }


            },
            onPending: function(result) {
                // const urlParams = new URLSearchParams(result);
                // const url = "pembayaran.php?" + urlParams.toString();
                // fetch(url)
                snapContainer.style.display = 'none';

                enableCancelPayment(result)

            },
            onError: function(result) {
                alert("payment failed!");
                alert(result);
                window.location.href =
                    "../index.php"
            },
            onClose: function(result) {
                // get payment status on midtrans


                snapContainer.style.display = 'none';
            }
        }

        console.log(token)
        window.snap.embed(token.token, snapOptions);
    }
    payButton.addEventListener('click', handlePayment);
    </script>



</body>

</html>