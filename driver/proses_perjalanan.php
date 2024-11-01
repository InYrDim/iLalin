<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Perjalanan - Pengemudi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #3b5d50; /* Warna latar belakang halaman */
        }
        .detail-column {
            background-color: #e0f7fa; /* Warna latar belakang untuk Detail Perjalanan */
        }
        .location-column {
            background-color: #fff3e0; /* Warna latar belakang untuk Lokasi Saat Ini */
        }
        .cost-column {
            background-color: #e8f5e9; /* Warna latar belakang untuk Estimasi Biaya Perjalanan */
        }
    </style>
</head>
<body class="h-screen flex flex-col">
    <div class="container mx-auto p-2 flex-grow">
        <h1 class="text-4xl font-bold text-center mb-6 text-white">Status Perjalanan</h1> <!-- Perubahan di sini -->
        
        <div class="flex space-x-4">
            <div class="bg-white p-6 rounded-lg shadow-lg flex-1 detail-column">
                <div class="mb-4">
                    <h2 class="text-3xl font-semibold text-gray-800">Detail Perjalanan</h2>
                    <div class="bg-gray-100 p-4 rounded-md">
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Pengemudi:</strong>
                            <span class="text-gray-700">Joni Supriadi</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Penumpang:</strong>
                            <span class="text-gray-700">Siti Badriah</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Tujuan:</strong>
                            <span class="text-gray-700">Makassar | Maros</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Waktu Berangkat:</strong>
                            <span class="text-gray-700">02-05-2021 14:00</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Estimasi Tiba:</strong>
                            <span class="text-gray-700">02-05-2021 14:38</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <strong class="text-black">Status:</strong>
                            <span class="bg-blue-500 text-white px-2 py-1 rounded">Dalam Proses</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <button class="bg-green-500 text-white px-5 py-3 rounded-md shadow-lg hover:bg-green-600 transition duration-300 transform hover:scale-105">
                        Selesai
                    </button>
                    <button class="bg-red-500 text-white px-5 py-3 rounded-md shadow-lg hover:bg-red-600 transition duration-300 transform hover:scale-105">
                        Batal
                    </button>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-lg flex-1 location-column">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Lokasi Saat Ini</h2>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-3xl text-red-500 mr-2"></i>
                    <p class="text-lg text-gray-700">Anda berada di Jl. Sudirman, Makassar</p>
                </div>
            </div>
        </div>

        <div class="flex space-x-4 mt-6">
            <div class="bg-white p-4 rounded-lg shadow-lg flex-1 cost-column">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Estimasi Biaya Perjalanan</h2>
                <div class="flex items-center justify-between">
                    <p class="text-lg text-gray-700">Biaya Total:</p>
                    <p class="text-xl font-bold text-green-600">Rp. 48.000</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p class="text-sm">2024 © iLalin. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
