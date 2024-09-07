CREATE DATABASE db_ilalin;

USE db_ilalin;

CREATE TABLE Users (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100),
    nomor_telepon VARCHAR(15),
    password VARCHAR(255),
    peran ENUM('penumpang', 'pengemudi')
);

CREATE TABLE Routes (
    id_rute INT AUTO_INCREMENT PRIMARY KEY,
    asal VARCHAR(255),
    tujuan VARCHAR(255),
    koordinat_asal VARCHAR(255),
    koordinat_tujuan VARCHAR(255)
);


CREATE TABLE Vehicles (
    id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
    nomor_polisi VARCHAR(20),
    jenis_kendaraan VARCHAR(50) DEFAULT 'mobil',
    kapasitas INT,
    id_pengguna INT,
    FOREIGN KEY (id_pengguna) REFERENCES Users(id_pengguna)
);


CREATE TABLE Trips (
    id_perjalanan INT AUTO_INCREMENT PRIMARY KEY,
    id_rute INT,
    tanggal_keberangkatan DATE,
    waktu_keberangkatan TIME,
    harga DECIMAL(10, 2),
    status_perjalanan ENUM('menunggu', 'sedang berlangsung', 'selesai'),
    id_pengemudi INT,
    id_kendaraan INT,
    FOREIGN KEY (id_rute) REFERENCES Routes(id_rute),
    FOREIGN KEY (id_pengemudi) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_kendaraan) REFERENCES Vehicles(id_kendaraan)
);


CREATE TABLE Bookings (
    id_pemesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_penumpang INT,
    id_perjalanan INT,
    status_pembayaran ENUM('belum dibayar', 'dibayar'),
    tanggal_pemesanan DATE,
    FOREIGN KEY (id_penumpang) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_perjalanan) REFERENCES Trips(id_perjalanan)
);

CREATE TABLE Payments (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pemesanan INT,
    metode_pembayaran VARCHAR(50),
    jumlah_pembayaran DECIMAL(10, 2),
    tanggal_pembayaran DATE,
    FOREIGN KEY (id_pemesanan) REFERENCES Bookings(id_pemesanan)
);

CREATE TABLE Reviews (
    id_ulasan INT AUTO_INCREMENT PRIMARY KEY,
    id_penumpang INT,
    id_perjalanan INT,
    rating INT,
    komentar TEXT,
    FOREIGN KEY (id_penumpang) REFERENCES Users(id_pengguna),
    FOREIGN KEY (id_perjalanan) REFERENCES Trips(id_perjalanan)
);

-- Tambahkan data sample untuk table Users
INSERT INTO Users (nama, email, nomor_telepon, password, peran)
VALUES
('John Doe', 'john@example.com', '081234567890', 'password123', 'penumpang'),
('Jane Doe', 'jane@example.com', '081234567891', 'password123', 'penumpang'),
('Pengemudi 1', 'pengemudi1@example.com', '081234567892', 'password123', 'pengemudi'),
('Pengemudi 2', 'pengemudi2@example.com', '081234567893', 'password123', 'pengemudi');

-- Tambahkan data sample untuk table Routes
INSERT INTO Routes (asal, tujuan, koordinat_asal, koordinat_tujuan)
VALUES
('Jakarta', 'Bandung', '-6.175394, 106.827153', '-6.914744, 107.609810'),
('Bandung', 'Jakarta', '-6.914744, 107.609810', '-6.175394, 106.827153'),
('Surabaya', 'Malang', '-7.257471, 112.752088', '-7.979709, 112.630880'),
('Malang', 'Surabaya', '-7.979709, 112.630880', '-7.257471, 112.752088');

-- Tambahkan data sample untuk table Vehicles
INSERT INTO Vehicles (nomor_polisi, jenis_kendaraan, kapasitas, id_pengguna)
VALUES
('B 1234 CD', 'mobil', 4, 3),
('B 5678 EF', 'mobil', 4, 4),
('B 9012 GH', 'mobil', 20, 3),
('B 3456 IJ', 'mobil', 20, 4);

-- Tambahkan data sample untuk table Trips
INSERT INTO Trips (id_rute, tanggal_keberangkatan, waktu_keberangkatan, harga, status_perjalanan, id_pengemudi, id_kendaraan)
VALUES
(1, '2023-07-01', '08:00:00', 50000.00, 'menunggu', 3, 1),
(2, '2023-07-02', '08:00:00', 50000.00, 'selesai', 4, 2),
(3, '2023-07-03', '08:00:00', 100000.00, 'sedang berlangsung', 3, 3),
(4, '2023-07-04', '08:00:00', 100000.00, 'menunggu', 4, 4);

-- Tambahkan data sample untuk table Bookings
INSERT INTO Bookings (id_penumpang, id_perjalanan, status_pembayaran, tanggal_pemesanan)
VALUES
(1, 1, 'belum dibayar', '2023-06-25'),
(2, 1, 'belum dibayar', '2023-06-26'),
(1, 3, 'belum dibayar', '2023-06-27'),
(2, 4, 'belum dibayar', '2023-06-28');

-- Tambahkan data sample untuk table Payments
INSERT INTO Payments (id_pemesanan, metode_pembayaran, jumlah_pembayaran, tanggal_pembayaran)
VALUES
(1, 'cash', 50000.00, '2023-06-30'),
(2, 'transfer bank', 50000.00, '2023-06-30'),
(3, 'transfer bank', 100000.00, '2023-07-01'),
(4, 'transfer bank', 100000.00, '2023-07-01');

-- Tambahkan data sample untuk table Reviews
INSERT INTO Reviews (id_penumpang, id_perjalanan, rating, komentar)
VALUES
(1, 1, 5, 'Perjalanan yang sangat nyaman dan aman'),
(2, 1, 4, 'Perjalanan yang nyaman, tetapi sedikit terlambat'),
(1, 3, 5, 'Perjalanan yang sangat nyaman dan aman'),
(2, 4, 4, 'Perjalanan yang nyaman, tetapi sedikit terlambat');