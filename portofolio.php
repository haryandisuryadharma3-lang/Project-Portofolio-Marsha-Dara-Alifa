<?php
require __DIR__ . '/config/koneksi.php';
require __DIR__ . '/config/helpers.php';

// Mengambil profil dan seluruh data proyek
$profil = $pdo->query('SELECT * FROM profil WHERE id=1')->fetch();
$proyek = $pdo->query('SELECT * FROM proyek ORDER BY created_at DESC')->fetchAll();

$namaPemilik = $profil['nama'] ?? 'Marsha Dara Alifa';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portofolio | <?= e($namaPemilik) ?></title>
  
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

      /* Header Portofolio */
      .portfolio-header {
          background: linear-gradient(135deg, #e8f7f3 0%, #f4fbf9 50%, #ffffff 100%);
          border-bottom: 1px solid rgba(64, 179, 149, 0.15);
      }

      .eyebrow-badge {
          background-color: var(--mint-soft);
          color: var(--mint-dark);
          letter-spacing: 2px;
          font-size: 0.75rem;
      }

      /* Card Proyek */
      .card-project {
          border-radius: 20px;
          border: 1px solid #e2f0ec;
          transition: transform 0.3s, box-shadow 0.3s;
      }
      .card-project:hover {
          transform: translateY(-6px);
          box-shadow: 0 15px 30px rgba(15, 76, 58, 0.08) !important;
      }

      .badge-category {
          background-color: var(--mint-soft);
          color: var(--mint-dark);
          font-size: 0.75rem;
      }

      .link-detail {
          color: var(--mint-primary);
          transition: color 0.2s;
      }
      .link-detail:hover {
          color: var(--mint-dark);
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
          <a class="nav-link active" href="<?= e(base_url('portofolio.php')) ?>">Portofolio</a>
          <a class="nav-link" href="<?= e(base_url('kontak.php')) ?>">Kontak</a>
          <a class="btn rounded-pill px-4 btn-sm fw-medium shadow-sm" style="border: 1.5px solid var(--mint-primary); color: var(--mint-dark);" href="<?= e(base_url('admin/login.php')) ?>">Login Admin</a>
        </div>
    </div>
  </div>
</nav>

<main>
<!-- Header Portofolio -->
<header class="portfolio-header py-5 text-center">
  <div class="container py-4">
    <span class="badge eyebrow-badge px-3 py-2 rounded-pill fw-semibold mb-3"></span>
    <h1 class="display-5 fw-bold mb-2" style="color: var(--mint-dark);">Portofolio <?= e($namaPemilik) ?></h1>
    <p class="text-secondary mb-0 mx-auto" style="max-width: 520px;">Made With Love With Your Own Hands.</p>
    <div class="mx-auto rounded-pill mt-3" style="width: 50px; height: 3px; background-color: var(--mint-medium);"></div>
  </div>
</header>

<!-- Daftar Seluruh Proyek -->
<section class="py-5">
  <div class="container py-3">
    <div class="row g-4">
      <?php if (!$proyek): ?>
        <div class="col-12">
          <div class="alert alert-light border text-center py-5 text-muted rounded-4 shadow-sm">
            <i class="bi bi-journal-x fs-2 d-block mb-2 text-secondary"></i>
            Belum ada proyek yang ditambahkan.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($proyek as $item): ?>
          <div class="col-md-6 col-lg-4">
            <article class="card card-project h-100 border-0 shadow-sm overflow-hidden bg-white">
              
              <!-- Gambar Proyek -->
              <div style="height: 220px; background-color: var(--mint-soft); position: relative;" class="overflow-hidden">
                <?php if (!empty($item['gambar']) && is_file(__DIR__ . '/' . $item['gambar'])): ?>
                  <img class="w-100 h-100 object-fit-cover" src="<?= e(base_url($item['gambar'])) ?>" alt="<?= e($item['judul']) ?>">
                <?php else: ?>
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-medium" style="background: var(--mint-soft); color: var(--mint-dark);">
                    <span>Preview Proyek</span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Deskripsi Proyek -->
              <div class="p-4 d-flex flex-column flex-grow-1">
                <div class="mb-2">
                  <span class="badge px-3 py-1 rounded-pill fw-normal badge-category">
                    <?= e($item['kategori']) ?>
                  </span>
                </div>
                <h2 class="h6 fw-bold text-dark mb-2"><?= e($item['judul']) ?></h2>
                <p class="text-secondary small mb-4 flex-grow-1"><?= e(mb_strimwidth($item['deskripsi'], 0, 110, '...')) ?></p>
                
                <div>
                  <a class="text-decoration-none fw-semibold small link-detail d-inline-flex align-items-center gap-1" href="<?= e(base_url('detail.php?id=' . (int)$item['id'])) ?>">
                    Lihat detail &rarr;
                  </a>
                </div>
              </div>

            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
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