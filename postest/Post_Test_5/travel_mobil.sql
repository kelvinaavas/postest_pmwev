-- Membuat Database
CREATE DATABASE IF NOT EXISTS travel_mobil;
USE travel_mobil;

-- Tabel Users (untuk login)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Armada (daftar mobil)
CREATE TABLE IF NOT EXISTS armada (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_mobil VARCHAR(100) NOT NULL,
    jenis VARCHAR(50) NOT NULL,
    kapasitas INT NOT NULL,
    harga_per_hari INT NOT NULL,
    status ENUM('Tersedia', 'Tidak Tersedia') DEFAULT 'Tersedia',
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Pemesanan (rental booking)
CREATE TABLE IF NOT EXISTS pemesanan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_penyewa VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nomor_telepon VARCHAR(15) NOT NULL,
    id_armada INT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    total_hari INT NOT NULL,
    total_harga INT NOT NULL,
    status ENUM('Pending', 'Dikonfirmasi', 'Selesai', 'Dibatalkan') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_armada) REFERENCES armada(id) ON DELETE CASCADE
);

-- Tabel Pembayaran (payment tracking)
CREATE TABLE IF NOT EXISTS pembayaran (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pemesanan INT NOT NULL,
    jumlah_bayar INT NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    status_pembayaran ENUM('Pending', 'Lunas', 'Gagal') DEFAULT 'Pending',
    tanggal_pembayaran DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pemesanan) REFERENCES pemesanan(id) ON DELETE CASCADE
);

-- Insert data user default
INSERT INTO users (username, password) VALUES ('admin', '123');

-- Insert data armada default
INSERT INTO armada (nama_mobil, jenis, kapasitas, harga_per_hari, deskripsi) VALUES
('Toyota Avanza', '7-Seater', 7, 500000, 'Nyaman untuk keluarga, AC dingin, power steering'),
('Honda Brio', 'City Car', 5, 300000, 'Hemat bahan bakar, cocok untuk kota'),
('Suzuki Ertiga', 'Minivan', 7, 450000, 'Nyaman untuk perjalanan jauh, interior luas'),
('Daihatsu Xenia', 'Minivan', 7, 400000, 'Cocok untuk tour keluarga'),
('Mitsubishi Pajero', 'SUV', 7, 750000, 'Mewah, off-road capable');