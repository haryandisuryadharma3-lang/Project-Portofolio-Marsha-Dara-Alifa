<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . base_url('admin/proyek.php')); exit;
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT gambar FROM proyek WHERE id=?');
$stmt->execute([$id ?: 0]);
$item = $stmt->fetch();
if ($item) {
    $del = $pdo->prepare('DELETE FROM proyek WHERE id=?');
    $del->execute([$id]);
    delete_uploaded_file($item['gambar']);
}
header('Location: ' . base_url('admin/proyek.php?status=hapus'));
exit;
