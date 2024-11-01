<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #3b5d50; /* Warna latar belakang halaman */
        }
        .wallet-column {
            background-color: #3b82f6; /* Warna latar belakang untuk saldo dompet */
        }
        .income-column {
            background-color: #22c55e; /* Warna latar belakang untuk pemasukkan */
        }
        .order-data-column {
            background-color: #ffffff; /* Warna latar belakang untuk data pesanan */
        }
        .status-batal {
            background-color: #ef4444; /* Warna latar belakang untuk status batal */
        }
        .status-proses {
            background-color: #3b82f6; /* Warna latar belakang untuk status proses */
        }
        .status-selesai {
            background-color: #22c55e; /* Warna latar belakang untuk status selesai */
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex flex-col">
    <!-- Wrapper untuk Dompet dan Data Pesanan -->
    <div class="w-full h-full p-6 flex flex-col">
        <!-- Dompet Section -->
        <div class="flex justify-center mb-6 flex-grow">
            <div class="grid grid-cols-2 gap-4 w-full"> <!-- Tambahkan w-full untuk mengatur lebar grid -->
                <div class="wallet-column text-white p-4 rounded shadow-md flex-1"> <!-- Tambahkan flex-1 -->
                    <div class="flex items-center">
                        <i class="fas fa-wallet text-3xl mr-4"></i>
                        <div>
                            <div>Saldo dompet</div>
                            <div class="text-2xl font-semibold">Rp. 2.480.000</div>
                        </div>
                    </div>
                </div>
                <div class="income-column text-white p-4 rounded shadow-md flex-1"> <!-- Tambahkan flex-1 -->
                    <div class="flex items-center">
                        <i class="fas fa-hand-holding-usd text-3xl mr-4"></i>
                        <div>
                            <div>Pemasukkan</div>
                            <div class="text-2xl font-semibold">Rp. 2.500.000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Data Pesanan Section -->
        <div class="order-data-column p-4 rounded shadow flex-grow">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-center w-full">Data Pesanan</h1>
            </div>
            <div>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Perjalanan</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">No WhatsApp</th>
                        <th class="py-2 px-4 border-b">Waktu</th>
                        <th class="py-2 px-4 border-b">Harga</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b">Makassar | Maros</td>
                        <td class="py-2 px-4 border-b">Siti Badriah</td>
                        <td class="py-2 px-4 border-b">085709876543</td>
                        <td class="py-2 px-4 border-b">02-05-2021 13:57</td>
                        <td class="py-2 px-4 border-b">Rp. 45.000</td>
                        <td class="py-2 px-4 border-b"><span class="status-batal text-white px-2 py-1 rounded">Batal</span></td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Makassar | Pangkep</td>
                        <td class="py-2 px-4 border-b">Nassar</td>
                        <td class="py-2 px-4 border-b">081233445566</td>
                        <td class="py-2 px-4 border-b">02-05-2021 13:53</td>
                        <td class="py-2 px-4 border-b">Rp. 70.000</td>
                        <td class="py-2 px-4 border-b"><span class="status-proses text-white px-2 py-1 rounded">Proses</span></td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Makassar | Barru</td>
                        <td class="py-2 px-4 border-b">Iis Dahlia</td>
                        <td class="py-2 px-4 border-b">081233445566</td>
                        <td class="py-2 px-4 border-b">01-05-2021 10:12</td>
                        <td class="py-2 px-4 border-b">Rp. 85.000</td>
                        <td class="py-2 px-4 border-b"><span class="status-proses text-white px-2 py-1 rounded">Proses</span></td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Makassar | Pare-pare</td>
                        <td class="py-2 px-4 border-b">Inul Daratista</td>
                        <td class="py-2 px-4 border-b">081233445846</td>
                        <td class="py-2 px-4 border-b">01-05-2021 10:12</td>
                        <td class="py-2 px-4 border-b">Rp. 120.000</td>
                        <td class="py-2 px-4 border-b"><span class="status-selesai text-white px-2 py-1 rounded">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
            </div>
            
        </div>
        
        <!-- Footer -->
        <footer class="mt-4 text-center text-gray-500">
            2024 © iLalin.
        </footer>
    </div>
</body>
</html>
