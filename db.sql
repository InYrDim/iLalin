-- Membuat database
CREATE DATABASE ilalin;

-- Menggunakan database
USE ilalin;

-- Membuat tabel Users
CREATE TABLE Users (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    nomor_telepon VARCHAR(15),
    password VARCHAR(255),
    peran ENUM('penumpang', 'pengemudi')
);

-- Membuat tabel Vehicles
CREATE TABLE Vehicles (
    id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
    nomor_polisi VARCHAR(20),
    jenis_kendaraan VARCHAR(50),
    kapasitas INT,
    id_pengguna INT,
    FOREIGN KEY (id_pengguna) REFERENCES Users(id_pengguna)
);

-- Membuat tabel Trips
CREATE TABLE Trips (
    id_perjalanan INT AUTO_INCREMENT PRIMARY KEY,
    rute VARCHAR(255),
    tanggal_berangkat DATE,
    waktu_berangkat TIME,
    harga DECIMAL(10, 2),
    status_perjalanan ENUM('menunggu', 'sedang berlangsung', 'selesai'),
    id_pengemudi INT,
    id_kendaraan INT,
    FOREIGN KEY (id_pengemudi) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_kendaraan) REFERENCES Vehicles(id_kendaraan)
);

-- Membuat tabel Bookings
CREATE TABLE Bookings (
    id_pemesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_penumpang INT,
    id_perjalanan INT,
    status_pembayaran ENUM('belum dibayar', 'dibayar'),
    tanggal_pemesanan DATE,
    FOREIGN KEY (id_penumpang) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_perjalanan) REFERENCES Trips(id_perjalanan)
);

-- Membuat tabel Payments
CREATE TABLE Payments (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pemesanan INT,
    metode_pembayaran VARCHAR(50),
    jumlah_pembayaran DECIMAL(10, 2),
    tanggal_pembayaran DATE,
    FOREIGN KEY (id_pemesanan) REFERENCES Bookings(id_pemesanan)
);


-- Membuat tabel Reviews
CREATE TABLE Reviews (
    id_ulasan INT AUTO_INCREMENT PRIMARY KEY,
    id_penumpang INT,
    id_perjalanan INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    komentar TEXT,
    FOREIGN KEY (id_penumpang) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_perjalanan) REFERENCES Trips(id_perjalanan)
);

-- Membuat tabel Admins
CREATE TABLE Admins (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    nomor_telepon VARCHAR(15),
    password VARCHAR(255) NOT NULL
);

-- Membuat tabel Kabupaten
CREATE TABLE Kabupaten (
    id_kabupaten INT PRIMARY KEY AUTO_INCREMENT,
    nama_kabupaten VARCHAR(100) NOT NULL
);

-- Membuat tabel Rute
CREATE TABLE Rute (
    id_rute INT PRIMARY KEY AUTO_INCREMENT,
    asal_kabupaten INT,
    tujuan_kabupaten INT,
    FOREIGN KEY (asal_kabupaten) REFERENCES Kabupaten(id_kabupaten),
    FOREIGN KEY (tujuan_kabupaten) REFERENCES Kabupaten(id_kabupaten)
);

-- Menambahkan kolom id_rute ke tabel Trips
ALTER TABLE Trips
ADD COLUMN id_rute INT,
ADD FOREIGN KEY (id_rute) REFERENCES Rute(id_rute);

-- Set Devault Value Mobil
ALTER TABLE vehicles
ALTER COLUMN jenis_kendaraan SET DEFAULT 'Mobil';

-- Add Image Profile Admin
ALTER TABLE Admins ADD COLUMN profile_image LONGBLOB;

-- Add Tanggal dan Wkatu ke Review
ALTER TABLE Reviews
ADD COLUMN tanggal DATE,
ADD COLUMN waktu TIME;

-- Add Image Profile Admin
ALTER TABLE Kabupaten ADD COLUMN logo_image LONGBLOB;

-- Tambah kolom kabupaten icon dengan tipedata LONGBLOB dan kolom apakah terjangkau atau belum

ALTER TABLE Kabupaten 
 ADD COLUMN icon_kabupaten LONGBLOB
 ADD COLUMN is_terjangkau BOOLEAN DEFAULT TRUE;

-- Tambah kolom status_kabupaten ke Kabupaten


-- Tambah kolom status_kabupaten ke Kabupaten



INSERT INTO Kabupaten (nama_kabupaten) VALUES
('Makassar'),
('Gowa'),
('Takalar'),
('Maros'),
('Pangkep'),
('Bone'),
('Sinjai'),
('Soppeng'),
('Wajo'),
('Enrekang'),
('Luwu'),
('Luwu Utara'),
('Luwu Timur'),
('Selayar'),
('Bantaeng'),
('Jeneponto'),
('Bulukumba'),
('Tana Toraja'),
('Toraja Utara'),
('Pinrang');

INSERT INTO Users (nama, email, nomor_telepon, password, peran) VALUES
('Andi', 'andi@example.com', '081234567890', 'password123', 'penumpang'),
('Budi', 'budi@example.com', '081234567891', 'password123', 'pengemudi'),
('Cici', 'cici@example.com', '081234567892', 'password123', 'penumpang'),
('Dedi', 'dedi@example.com', '081234567893', 'password123', 'pengemudi'),
('Eka', 'eka@example.com', '081234567894', 'password123', 'penumpang'),
('Fani', 'fani@example.com', '081234567895', 'password123', 'pengemudi'),
('Gita', 'gita@example.com', '081234567896', 'password123', 'penumpang'),
('Hadi', 'hadi@example.com', '081234567897', 'password123', 'pengemudi'),
('Ika', 'ika@example.com', '081234567898', 'password123', 'penumpang'),
('Joni', 'joni@example.com', '081234567899', 'password123', 'pengemudi');

INSERT INTO Vehicles (nomor_polisi, jenis_kendaraan, kapasitas, id_pengguna) VALUES
('DD 1234 AB', 'Mobil Sedan', 4, 2),
('DD 5678 CD', 'Mobil SUV', 7, 2),
('DD 9012 EF', 'Mobil MPV', 8, 2),
('DD 3456 GH', 'Mobil', 2, 2),
('DD 7890 IJ', 'Mobil Pickup', 5, 3),
('DD 1234 KL', 'Mobil Hatchback', 4, 3),
('DD 5678 MN', 'Mobil Station Wagon', 6, 4),
('DD 9012 OP', 'Mobil Convertible', 2, 4),
('DD 3456 QR', 'Mobil Van', 9, 5),
('DD 7890 ST', 'Motor Sport', 2, 5);

INSERT INTO Rute (asal_kabupaten, tujuan_kabupaten) VALUES
(1, 2),  -- Makassar to Gowa
(2, 3),  -- Gowa to Takalar
(3, 4),  -- Takalar to Maros
(4, 5),  -- Maros to Pangkep
(5, 6),  -- Pangkep to Bone
(6, 7),  -- Bone to Sinjai
(7, 8),  -- Sinjai to Soppeng
(8, 9),  -- Soppeng to Wajo
(9, 10), -- Wajo to Enrekang
(10, 11);-- Enrekang to Luwu

INSERT INTO Trips (rute, tanggal_berangkat, waktu_berangkat, harga, status_perjalanan, id_pengemudi, id_kendaraan, id_rute) VALUES
('Makassar - Gowa', '2024-09-10', '08:00:00', 100000, 'sedang berlangsung', 2, 1, 1),
('Gowa - Takalar', '2024-09-11', '09:00:00', 120000, 'sedang berlangsung', 2, 2, 2),
('Takalar - Maros', '2024-09-12', '10:00:00', 150000, 'menunggu', 2, 3, 3),
('Maros - Pangkep', '2024-09-13', '11:00:00', 130000, 'menunggu', 3, 4, 4),
('Pangkep - Bone', '2024-09-14', '12:00:00', 140000, 'sedang berlangsung', 3, 5, 5),
('Bone - Sinjai', '2024-09-15', '13:00:00', 160000, 'menunggu', 4, 6, 6),
('Sinjai - Soppeng', '2024-09-16', '14:00:00', 110000, 'sedang berlangsung', 4, 7, 7),
('Soppeng - Wajo', '2024-09-17', '15:00:00', 120000, 'sedang berlangsung', 5, 8, 8),
('Wajo - Enrekang', '2024-09-18', '16:00:00', 125000, 'menunggu', 5, 9, 9),
('Enrekang - Luwu', '2024-09-19', '17:00:00', 135000, 'sedang berlangsung', 6, 10, 10);

INSERT INTO Bookings (id_penumpang, id_perjalanan, status_pembayaran, tanggal_pemesanan) VALUES
(1, 1, 'belum dibayar', '2024-09-01'),
(3, 2, 'dibayar', '2024-09-02'),
(5, 3, 'dibayar', '2024-09-03'),
(7, 4, 'belum dibayar', '2024-09-04'),
(9, 5, 'dibayar', '2024-09-05'),
(1, 6, 'belum dibayar', '2024-09-06'),
(3, 7, 'dibayar', '2024-09-07'),
(5, 8, 'belum dibayar', '2024-09-08'),
(7, 9, 'dibayar', '2024-09-09'),
(9, 10, 'belum dibayar', '2024-09-10');

INSERT INTO Payments (id_pemesanan, metode_pembayaran, jumlah_pembayaran, tanggal_pembayaran) VALUES
(2, 'Kartu Kredit', 120000, '2024-09-03'),
(3, 'Transfer Bank', 150000, '2024-09-04'),
(5, 'Kartu Debit', 140000, '2024-09-05'),
(7, 'E-Wallet', 160000, '2024-09-06'),
(9, 'Kartu Kredit', 110000, '2024-09-07'),
(1, 'Transfer Bank', 130000, '2024-09-08'),
(3, 'E-Wallet', 120000, '2024-09-09'),
(5, 'Kartu Debit', 140000, '2024-09-10'),
(7, 'Kartu Kredit', 125000, '2024-09-11'),
(9, 'Transfer Bank', 135000, '2024-09-12');

INSERT INTO Reviews (id_penumpang, id_perjalanan, rating, komentar, tanggal, waktu) VALUES
(1, 1, 5, 'Perjalanan sangat nyaman!', '2024-09-01', '08:00:00'),
(3, 2, 4, 'Pelayanan bagus, tapi sedikit terlambat.', '2024-09-02', '09:00:00'),
(5, 3, 3, 'Rata-rata, tidak terlalu istimewa.', '2024-09-03', '10:00:00'),
(7, 4, 4, 'Pengalaman yang baik.', '2024-09-04', '11:00:00'),
(9, 5, 5, 'Layanan sangat memuaskan!', '2024-09-05', '12:00:00'),
(1, 6, 2, 'Kurang memuaskan, banyak keterlambatan.', '2024-09-06', '13:00:00'),
(3, 7, 4, 'Bagus, tapi ada beberapa masalah kecil.', '2024-09-07', '14:00:00'),
(5, 8, 3, 'Rata-rata, bisa lebih baik.', '2024-09-08', '15:00:00'),
(7, 9, 5, 'Sangat bagus, akan menggunakan lagi.', '2024-09-09', '16:00:00'),
(9, 10, 4, 'Baik, tetapi ada ruang untuk perbaikan.', '2024-09-10', '17:00:00');


INSERT INTO Admins (nama, email, nomor_telepon, password) VALUES
-- admin123
('Izzaturrahman', 'izzat@ilalin.com', '081234567894', '$2y$10$RXmbZ7xl7DS9SAJ0imLYfufvei.CnCZx4SMMXiaq7sRZJe9m12RLa'),
('Nurul Ilmi', 'ilmi@ilalin.com', '081234567894', '$2y$10$RXmbZ7xl7DS9SAJ0imLYfufvei.CnCZx4SMMXiaq7sRZJe9m12RLa'),
('Muh. Dimas Januardi Nur', 'dimas@ilalin.com', '081234567894', '$2y$10$RXmbZ7xl7DS9SAJ0imLYfufvei.CnCZx4SMMXiaq7sRZJe9m12RLa'),
('Alisa Zahra Syahdia', 'alisa@ilalin.com', '081234567894', '$2y$10$RXmbZ7xl7DS9SAJ0imLYfufvei.CnCZx4SMMXiaq7sRZJe9m12RLa'),


CREATE VIEW DetailPerjalananBerlangsung AS
SELECT 
    t.id_perjalanan AS id_perjalanan,
    CONCAT(u.nama, ' (', v.nomor_polisi, ')') AS pengemudi,
    t.rute AS rute,
    t.tanggal_berangkat AS tanggal_berangkat,
    t.waktu_berangkat AS waktu_berangkat,
    t.harga AS harga,
    t.status_perjalanan AS status_perjalanan,
    r.asal_kabupaten AS asal_kabupaten,
    r.tujuan_kabupaten AS tujuan_kabupaten
FROM 
    Trips t
JOIN 
    Users u ON t.id_pengemudi = u.id_pengguna
JOIN 
    Vehicles v ON t.id_kendaraan = v.id_kendaraan
JOIN 
    Rute r ON t.id_rute = r.id_rute
WHERE 
    t.status_perjalanan = 'sedang berlangsung';

CREATE VIEW KabupatenTerkunjungi AS
SELECT 
    k.id_kabupaten,
    k.nama_kabupaten,
    COALESCE(SUM(r.jumlah_kunjungan), 0) AS jumlah_kunjungan
FROM 
    Kabupaten k
LEFT JOIN (
    SELECT 
        asal_kabupaten AS id_kabupaten, 
        COUNT(*) AS jumlah_kunjungan
    FROM 
        Rute
    GROUP BY 
        asal_kabupaten

    UNION ALL

    SELECT 
        tujuan_kabupaten AS id_kabupaten, 
        COUNT(*) AS jumlah_kunjungan
    FROM 
        Rute
    GROUP BY 
        tujuan_kabupaten
) r ON k.id_kabupaten = r.id_kabupaten
GROUP BY 
    k.id_kabupaten, k.nama_kabupaten
ORDER BY 
    jumlah_kunjungan DESC;


CREATE VIEW TripGroupedByDate AS
SELECT 
    t.tanggal_berangkat,
    COUNT(t.id_perjalanan) AS jumlah_trip,
    GROUP_CONCAT(
        CONCAT(
            'Rute: ', t.rute, 
            ', Harga: ', t.harga,
            ', Pengemudi: ', u.nama,
            ', Kendaraan: ', v.nomor_polisi
        ) SEPARATOR '; '
    ) AS detail_trip
FROM 
    Trips t
JOIN 
    Users u ON t.id_pengemudi = u.id_pengguna
JOIN 
    Vehicles v ON t.id_kendaraan = v.id_kendaraan
GROUP BY 
    t.tanggal_berangkat
ORDER BY 
    t.tanggal_berangkat;

