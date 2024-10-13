<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukungan Pelanggan - Transportasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link Font Awesome -->
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('https://example.com/your-car-background.jpg');
        /* Ganti dengan URL gambar mobil */
        background-size: cover;
        background-position: center;
        color: white;
        /* Warna teks untuk kontras dengan latar belakang */
    }

    .container {
        max-width: 1600px;
        /* Ukuran maksimum kontainer diperbesar */
        margin: auto;
        padding: 60px 40px;
        /* Padding lebih besar untuk kesan lebar */
        background-color: rgba(59, 93, 80, 0.9);
        /* Latar belakang lebih gelap */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        /* Tambahkan bayangan untuk kedalaman */
    }

    header {
        text-align: center;
        padding: 40px;
        /* Padding lebih besar */
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    h1 {
        margin: 0;
        font-size: 3.5em;
        /* Ukuran font lebih besar */
    }

    .search-bar {
        width: 80%;
        /* Lebar pencarian lebih besar */
        padding: 15px;
        /* Padding lebih besar */
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        outline: none;
        font-size: 1.2em;
        /* Ukuran font lebih besar */
    }

    .support-options {
        margin-top: 40px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        /* Ukuran minimum diperbesar */
        gap: 30px;
        /* Gap lebih besar antar item */
    }

    .support-item {
        background-color: white;
        color: #3b5d50;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 40px;
        /* Padding lebih besar */
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .support-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .support-item h3 {
        margin: 10px 0;
        /* Tambahkan margin untuk jarak */
        color: #3b5d50;
        font-size: 1.8em;
        /* Ukuran font lebih besar untuk judul item */
    }

    .icon {
        font-size: 50px;
        /* Ukuran ikon Font Awesome */
        margin-bottom: 15px;
        color: #3b5d50;
        /* Warna ikon */
    }

    button {
        background-color: #3b5d50;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 15px 25px;
        /* Padding lebih besar */
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        margin-top: 15px;
        font-size: 1.3em;
        /* Ukuran font lebih besar untuk tombol */
    }

    button:hover {
        background-color: #2a3d40;
        transform: scale(1.05);
    }

    footer {
        text-align: center;
        margin-top: 40px;
        color: #fff;
    }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Dukungan Pelanggan</h1>
            <input type="text" placeholder="Cari bantuan..." class="search-bar">
        </header>

        <section class="support-options">
            <div class="support-item">
                <i class="fas fa-question-circle icon"></i> <!-- Ikon untuk Pertanyaan Umum -->
                <h3>Pertanyaan Umum</h3>
                <p>Temukan jawaban untuk pertanyaan yang sering diajukan.</p>
                <button onclick="showMessage('Anda memilih Pertanyaan Umum')">Pelajari lebih lanjut</button>
            </div>
            <div class="support-item">
                <i class="fas fa-headset icon"></i> <!-- Ikon untuk Hubungi Kami -->
                <h3>Hubungi Kami</h3>
                <p>Butuh bantuan langsung? Hubungi tim dukungan kami.</p>
                <button onclick="showMessage('Anda memilih Hubungi Kami')">Hubungi Sekarang</button>
            </div>
            <div class="support-item">
                <i class="fas fa-exclamation-triangle icon"></i> <!-- Ikon untuk Laporkan Masalah -->
                <h3>Laporkan Masalah</h3>
                <p>Laporkan masalah yang Anda hadapi saat menggunakan layanan kami.</p>
                <button onclick="showMessage('Anda memilih Laporkan Masalah')">Laporkan Sekarang</button>
            </div>
            <div class="support-item">
                <i class="fas fa-comment-dots icon"></i> <!-- Ikon untuk Berikan Umpan Balik -->
                <h3>Berikan Umpan Balik</h3>
                <p>Kami menghargai pendapat Anda. Berikan umpan balik untuk perbaikan layanan.</p>
                <button onclick="showMessage('Anda memilih Berikan Umpan Balik')">Berikan Umpan Balik</button>
            </div>
        </section>

        <footer>
            <p>&copy; 2024 iLALIN. Semua hak dilindungi.</p>
        </footer>
    </div>

    <script>
    function showMessage(message) {
        alert(message);
    }
    </script>
</body>

</html>