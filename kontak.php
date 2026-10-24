<?php
require __DIR__ . '/config/koneksi.php';
require __DIR__ . '/config/helpers.php';

$profil = $pdo->query('SELECT * FROM profil WHERE id=1')->fetch();
$namaPemilik = $profil['nama'] ?? 'Marsha Dara Alifa';

$errors = [];
$success = false;
$nama = $email = $whatsapp = $pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if (mb_strlen($nama) < 2 || mb_strlen($nama) > 100) $errors[] = 'Nama harus berisi 2–100 karakter.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Masukkan alamat email yang valid.';
    if (!preg_match('/^[0-9+() .-]{8,20}$/', $whatsapp)) $errors[] = 'Nomor WhatsApp harus berisi 8–20 karakter angka atau simbol telepon.';
    if (mb_strlen($pesan) < 10 || mb_strlen($pesan) > 2000) $errors[] = 'Pesan harus berisi 10–2.000 karakter.';

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO pesan_kontak (nama,email,whatsapp,pesan) VALUES (?,?,?,?)');
        $stmt->execute([$nama, $email, $whatsapp, $pesan]);
        $success = true;
        $nama = $email = $whatsapp = $pesan = '';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak | <?= e($namaPemilik) ?></title>
  
  <!-- Google Fonts: Playfair Display (Header) & Poppins (Body) -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet">
  
  <style>
      :root {
          --mint-dark: #0f4c3a;
          --mint-primary: #1e8569;
          --mint-medium: #40b395;
          --mint-soft: #e3f6f1;
          --mint-bg: #f2fbf8;
          --text-dark: #1b332c;
      }
      
      body {
          font-family: 'Poppins', sans-serif;
          background-color: #fafdfc;
          color: var(--text-dark);
          min-height: 100vh;
          display: flex;
          flex-direction: column;
      }

      main {
          flex: 1;
      }
      
      h1, h2, h3, .font-serif {
          font-family: 'Playfair Display', serif;
      }

      /* Navbar */
      .navbar {
          background: rgba(255, 255, 255, 0.9);
          backdrop-filter: blur(10px);
      }
      .navbar-brand span {
          color: var(--mint-primary);
      }
      .nav-link {
          color: #527066 !important;
          font-weight: 500;
          transition: color 0.3s;
      }
      .nav-link:hover, .nav-link.active {
          color: var(--mint-dark) !important;
          font-weight: 600;
      }

      /* Header Kontak */
      .contact-header {
          background: linear-gradient(135deg, #e8f7f3 0%, #f4fbf9 50%, #ffffff 100%);
          border-bottom: 1px solid rgba(64, 179, 149, 0.15);
      }

      .eyebrow-badge {
          background-color: var(--mint-soft);
          color: var(--mint-dark);
          letter-spacing: 2px;
          font-size: 0.75rem;
      }

      /* Form Container Card */
      .form-card-estetik {
          background: #ffffff;
          border: 1px solid rgba(64, 179, 149, 0.15);
          border-radius: 24px;
          box-shadow: 0 15px 35px rgba(15, 76, 58, 0.04);
      }

      .form-control:focus {
          border-color: var(--mint-medium);
          box-shadow: 0 0 0 0.25rem rgba(30, 133, 105, 0.15);
      }

      .btn-mint {
          background-color: var(--mint-primary);
          color: #ffffff;
          transition: background-color 0.2s;
      }
      .btn-mint:hover {
          background-color: var(--mint-dark);
          color: #ffffff;
      }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top border-bottom py-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="<?= e(base_url()) ?>">Marsha<span>.</span></a>
    <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
        <div class="navbar-nav ms-auto align-items-center gap-3">
          <a class="nav-link" href="<?= e(base_url()) ?>">Beranda</a>
          <a class="nav-link" href="<?= e(base_url('portofolio.php')) ?>">Portofolio</a>
          <a class="nav-link active" href="<?= e(base_url('kontak.php')) ?>">Kontak</a>
          <a class="btn rounded-pill px-4 btn-sm fw-medium shadow-sm" style="border: 1.5px solid var(--mint-primary); color: var(--mint-dark);" href="<?= e(base_url('admin/login.php')) ?>">Login Admin</a>
        </div>
    </div>
  </div>
</nav>

<main>
<!-- Header Kontak -->
<header class="contact-header py-5 text-center">
  <div class="container py-4">
    <span class="badge eyebrow-badge px-3 py-2 rounded-pill fw-semibold mb-3"></span>
    <h1 class="display-5 fw-bold mb-2" style="color: var(--mint-dark);">Hubungi Marsha</h1>
    <p class="text-secondary mb-0 mx-auto" style="max-width: 500px;">Silakan isi formulir berikut untuk mengirim pesan.</p>
    <div class="mx-auto rounded-pill mt-3" style="width: 50px; height: 3px; background-color: var(--mint-medium);"></div>
  </div>
</header>

<!-- Form Kontak Section -->
<section class="py-5">
  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <?php if ($success): ?>
          <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div>Pesan berhasil dikirim. Terima kasih telah menghubungi saya.</div>
          </div>
        <?php endif; ?>

        <?php if ($errors): ?>
          <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <strong>Periksa kembali:</strong>
            <ul class="mb-0 mt-2">
              <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="form-card-estetik p-4 p-md-5">
          <form method="post" novalidate>
            <div class="mb-3">
              <label for="nama" class="form-label fw-medium text-dark">Nama lengkap</label>
              <input class="form-control rounded-3 py-2" id="nama" name="nama" maxlength="100" required value="<?= e($nama) ?>">
            </div>
            
            <div class="mb-3">
              <label for="email" class="form-label fw-medium text-dark">Email</label>
              <input class="form-control rounded-3 py-2" type="email" id="email" name="email" maxlength="150" required value="<?= e($email) ?>">
            </div>
            
            <div class="mb-3">
              <label for="whatsapp" class="form-label fw-medium text-dark">Nomor WhatsApp</label>
              <input class="form-control rounded-3 py-2" type="tel" id="whatsapp" name="whatsapp" maxlength="20" pattern="[0-9+() .-]{8,20}" required value="<?= e($whatsapp) ?>" placeholder="Contoh: 081234567890">
            </div>
            
            <div class="mb-4">
              <label for="pesan" class="form-label fw-medium text-dark">Pesan</label>
              <textarea class="form-control rounded-3" id="pesan" name="pesan" rows="5" minlength="10" maxlength="2000" required><?= e($pesan) ?></textarea>
              <div class="form-text text-muted small mt-1">Minimal 10 karakter, maksimal 2.000 karakter.</div>
            </div>
            
            <button class="btn btn-mint btn-lg rounded-pill px-5 w-100 shadow-sm fw-medium" type="submit">Kirim Pesan</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</section>
</main>

<!-- Footer -->
<footer class="bg-white border-top py-4 text-muted small mt-auto">
  <div class="container d-flex justify-content-between flex-wrap gap-2">
    <span>© <?= date('Y') ?> <?= e($namaPemilik) ?>. All rights reserved.</span>
    <span>Website Portofolio • Pemrograman Web</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>