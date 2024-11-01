<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Sopir</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f4f8;
        color: #333;
    }

    header {
        background: linear-gradient(135deg, #3b5d50 0%, #2a4c3b 100%);
        color: white;
        text-align: center;
        padding: 2.5em 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    header h1 {
        font-size: 2.5em;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    main {
        display: flex;
        flex-wrap: wrap;
        width: 90%;
        margin: 20px auto;
        padding: 20px;
        gap: 20px;
    }

    .car-image {
        flex: 1 1 40%;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        position: relative;
        transition: transform 0.3s;
    }

    .car-image:hover {
        transform: translateY(-5px);
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s;
    }

    .car-image img:hover {
        transform: scale(1.05);
    }

    .upload-button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #3b5d50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .upload-button:hover {
        background-color: #2a4c3b;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .info-container {
        flex: 1 1 40%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-box {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .info-box h3 {
        margin: 0;
        color: #3b5d50;
        font-size: 1.8em;
    }

    .info-box p {
        font-size: 16px;
        color: #666;
        margin: 5px 0;
    }

    .rating {
        margin-top: 10px;
        font-size: 20px;
        color: #FFD700;
    }

    .driver-photo {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .driver-photo img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #3b5d50;
        margin-bottom: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    footer {
        text-align: center;
        margin: 30px 0;
        color: #777;
        font-size: 16px;
    }

    .edit-button {
        background-color: #3b5d50;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 18px;
        transition: background-color 0.3s;
        width: fit-content;
        align-self: flex-start;
    }

    .edit-button:hover {
        background-color: #2a4c3b;
    }

    @media (max-width: 768px) {
        main {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>
    <header>
        <h1>Dasbor Sopir</h1>
    </header>

    <main>
        <div class="car-image">
            <img id="carImage" src="https://example.com/car-image.jpg" alt="Mobil">
            <!-- Ganti dengan URL gambar mobil yang menarik -->
            <input type="file" id="carPhotoInput" style="display: none;" accept="image/*"
                onchange="previewCarPhoto(event)">
            <button class="upload-button" onclick="document.getElementById('carPhotoInput').click()">Unggah Foto
                Mobil</button>
        </div>

        <div class="info-container">
            <div class="info-box">
                <h3>Informasi Kendaraan</h3>
                <p><strong>Model:</strong> Toyota Camry</p>
                <p><strong>Plat Nomor:</strong> ABC1234</p>
                <p><strong>Status:</strong> Tersedia</p>
                <div class="rating">
                    <strong>Rating:</strong> ★★★★☆ (4.5)
                </div>
            </div>
            <div class="info-box driver-photo">
                <h3>Informasi Sopir</h3>
                <img id="driverImage" src="https://example.com/driver-photo.jpg" alt="Sopir">
                <input type="file" id="driverPhotoInput" style="display: none;" accept="image/*"
                    onchange="previewDriverPhoto(event)">
                <p><strong>Nama:</strong> John Doe</p>
                <p><strong>Telepon:</strong> 081234567890</p>
                <p><strong>Pengalaman:</strong> 5 tahun</p>
                <button class="edit-button" onclick="document.getElementById('driverPhotoInput').click()">Edit Foto
                    Profil</button>
            </div>
            <div class="info-box">
                <h3>Informasi Pemasukan</h3>
                <p><strong>Total Pendapatan:</strong> $1500</p>
                <p><strong>Rata-rata Harian:</strong> $50</p>
                <p><strong>Pembayaran Tertunda:</strong> $200</p>
                <p><strong>Perjalanan Selesai:</strong> 150</p>
                <p><strong>Umpan Balik:</strong> "Pendapatan konsisten setiap minggu."</p>
            </div>
        </div>
    </main>

    <footer>
        <p>Hubungi penumpang untuk informasi lebih lanjut.</p>
    </footer>

    <script>
    function previewCarPhoto(event) {
        const carImage = document.getElementById('carImage');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                carImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function previewDriverPhoto(event) {
        const driverImage = document.getElementById('driverImage');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                driverImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>

</html>