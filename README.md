# Project Website Portofolio 

Aplikasi berbasis web sederhana menggunakan HTML, CSS, dan PHP untuk menampilkan portofolio, project, serta Formulir Kontak.

## Fitur Utama
- Login Admin & Logout
- Beranda
- About Us
- Portofolio
- Formulir Kontak / Tautan Media Sosial
- Desain Responsif (Tampilan HP & Desktop)

### Tools:
- PHP native (disarankan PHP 8+)
- MySQL/MariaDB
- Bootstrap 5.3.3 melalui CDN
- XAMPP dan VS Code

INSTALASI
1. Ekstrak folder portfolio_marsha ke C:\xampp\htdocs\
2. Buka XAMPP Control Panel, Start Apache dan MySQL.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import, pilih file database.sql dari folder project, lalu klik Import/Go.
   Alternatif: buka tab SQL, lalu salin isi database.sql dan jalankan.
5. Periksa config/koneksi.php. Default XAMPP: user root, password kosong.
6. Buka http://localhost/portfolio_marsha/
7. Buka http://localhost/portfolio_marsha/admin/buat_admin.php untuk membuat akun admin.
8. Setelah akun berhasil dibuat, hapus file admin/buat_admin.php dari project.
9. Login di http://localhost/portfolio_marsha/admin/login.php
10. Dashboard admin menyediakan Kelola Proyek dan Edit Profil.

CATATAN
- Email dan nomor WhatsApp pada profil adalah contoh; ubah lewat menu Edit Profil.
- 3 proyek awal adalah data contoh tugas. Ganti dengan karya yang benar-benar dimiliki.
- Form kontak menyimpan pesan di tabel pesan_kontak. Pesan terbaru dapat dilihat di dashboard.
- Upload gambar dibatasi 3 MB dan format JPG, PNG, WEBP.
- Jika nama folder di htdocs bukan portfolio_marsha, sesuaikan fungsi base_url() di config/helpers.php.
- Untuk hosting publik, gunakan kredensial database yang aman, HTTPS, dan hapus semua file setup.
