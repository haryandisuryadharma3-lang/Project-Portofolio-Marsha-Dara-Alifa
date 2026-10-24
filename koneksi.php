<?php
declare(strict_types=1);

$host = 'localhost';
$db   = 'db_portfolio_marsha';
$user = 'root';
$pass = ''; // Default XAMPP. Isi jika MySQL Anda memakai password.

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Pastikan MySQL aktif dan database db_portfolio_marsha sudah diimpor.');
}
