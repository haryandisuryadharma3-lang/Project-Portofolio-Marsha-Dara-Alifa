<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
if (!empty($_SESSION['admin_id'])) { header('Location: ' . base_url('admin/dashboard.php')); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, username, password FROM admin WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: ' . base_url('admin/dashboard.php'));
        exit;
    }
    $error = 'Username atau password tidak sesuai.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login Admin | Marsha</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body class="login-page"><main class="container py-5"><div class="row justify-content-center"><div class="col-md-6 col-lg-5"><div class="form-card"><a href="<?= e(base_url()) ?>" class="text-decoration-none">← Kembali ke website</a><p class="eyebrow mt-4">AREA ADMIN</p><h1 class="h2 fw-bold mb-2">Login Admin</h1><p class="text-secondary mb-4">Masuk untuk mengelola portofolio.</p><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" autocomplete="username" required></div><div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required></div><button class="btn btn-primary btn-lg w-100" type="submit">Masuk</button></form><p class="small text-secondary mt-3 mb-0">Pertama kali? Buat akun melalui halaman <a href="<?= e(base_url('admin/buat_admin.php')) ?>">buat admin</a>, lalu hapus file setup tersebut.</p></div></div></div></main></body></html>
