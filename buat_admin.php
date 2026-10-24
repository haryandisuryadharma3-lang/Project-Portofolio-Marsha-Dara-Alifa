<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!preg_match('/^[a-zA-Z0-9_.-]{3,50}$/', $username)) {
        $message = 'Username harus 3–50 karakter, hanya huruf, angka, titik, garis bawah, atau tanda hubung.';
    } elseif (strlen($password) < 10) {
        $message = 'Password minimal 10 karakter.';
    } else {
        $check = $pdo->prepare('SELECT id FROM admin WHERE username=?');
        $check->execute([$username]);
        if ($check->fetch()) {
            $message = 'Username sudah digunakan. Pilih username lain.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO admin (username,password) VALUES (?,?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            $message = 'Admin berhasil dibuat. Demi keamanan, hapus file admin/buat_admin.php sekarang, lalu login.';
        }
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Buat Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body><main class="container py-5"><div class="row justify-content-center"><div class="col-md-6"><div class="form-card"><h1 class="h3 fw-bold mb-3">Buat akun admin</h1><p class="text-secondary">Buat akun pertama untuk mengakses dashboard.</p><?php if ($message): ?><div class="alert alert-info"><?= e($message) ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" minlength="3" maxlength="50" required></div><div class="mb-3"><label class="form-label" for="password">Password (minimal 10 karakter)</label><input class="form-control" type="password" id="password" name="password" minlength="10" required></div><button class="btn btn-primary" type="submit">Buat Admin</button><a class="btn btn-link" href="<?= e(base_url('admin/login.php')) ?>">Ke halaman login</a></form></div></div></div></main></body></html>
