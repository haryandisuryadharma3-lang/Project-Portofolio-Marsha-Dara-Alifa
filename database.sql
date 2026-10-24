CREATE DATABASE IF NOT EXISTS db_portfolio_marsha
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_portfolio_marsha;

CREATE TABLE IF NOT EXISTS admin (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS profil (
  id TINYINT UNSIGNED PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jurusan VARCHAR(100) NOT NULL,
  bio TEXT NOT NULL,
  email VARCHAR(150) NOT NULL,
  whatsapp VARCHAR(25) NOT NULL,
  foto VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

INSERT INTO profil (id, nama, jurusan, bio, email, whatsapp, foto)
VALUES (1, 'Marsha Dara Alifa', 'Mahasiswa Manajemen',
'Mahasiswa Manajemen yang tertarik pada pengelolaan bisnis, perencanaan, dan pengembangan ide kreatif. Saya senang belajar, bekerja sama, dan mengembangkan keterampilan baru.',
'marsha@example.com', '6281234567890', NULL)
ON DUPLICATE KEY UPDATE id=id;

CREATE TABLE IF NOT EXISTS proyek (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  kategori VARCHAR(100) NOT NULL,
  deskripsi TEXT NOT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  tautan VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pesan_kontak (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  whatsapp VARCHAR(25) NOT NULL,
  pesan TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO proyek (judul, kategori, deskripsi, gambar, tautan) VALUES
('Rencana Bisnis Sederhana', 'Manajemen Bisnis', 'Contoh proyek akademik untuk menyusun ide bisnis, target pasar, strategi promosi, dan gambaran biaya. Ganti konten ini dengan proyek asli Anda.', NULL, NULL),
('Perencanaan Kegiatan', 'Perencanaan', 'Contoh dokumentasi perencanaan kegiatan yang mencakup tujuan, pembagian tugas, jadwal, dan evaluasi. Ganti konten ini dengan proyek asli Anda.', NULL, NULL);
