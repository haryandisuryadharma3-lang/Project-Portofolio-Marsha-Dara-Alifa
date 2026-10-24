<?php
require __DIR__ . '/config/koneksi.php';
require __DIR__ . '/config/helpers.php';
$profil = $pdo->query('SELECT * FROM profil WHERE id=1')->fetch();
$proyek = $pdo->query('SELECT * FROM proyek ORDER BY created_at DESC LIMIT 3')->fetchAll();
$foto = $profil['foto'] ?? null;

$namaMerek = 'Pie Susu Marsha';
$namaPemilik = $profil['nama'] ?? 'Marsha Dara Alifa';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Beranda | <?= e($namaPemilik) ?></title>
  
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

      /* Hero Section */
      .hero-section {
          background: linear-gradient(180deg, #ffffff 0%, var(--mint-bg) 100%);
      }
      .eyebrow-badge {
          background-color: var(--mint-soft);
          color: var(--mint-dark);
          letter-spacing: 2px;
          font-size: 0.75rem;
      }

      /* Estetik About Us Section */
      .about-section {
          background: linear-gradient(135deg, #e8f7f3 0%, #f4fbf9 50%, #ffffff 100%);
          position: relative;
          overflow: hidden;
      }
      
      .about-card {
          background: #ffffff;
          border: 1px solid rgba(64, 179, 149, 0.15);
          border-radius: 24px;
          box-shadow: 0 15px 35px rgba(15, 76, 58, 0.04);
          transition: all 0.3s ease;
          position: relative;
      }
      
      .about-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 20px 40px rgba(15, 76, 58, 0.08);
          border-color: rgba(64, 179, 149, 0.3);
      }

      .about-icon-box {
          width: 48px;
          height: 48px;
          background-color: var(--mint-soft);
          color: var(--mint-dark);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 1.25rem;
      }

      .text-highlight {
          color: var(--mint-dark);
          font-weight: 600;
      }

      /* Project Cards */
      .card-project {
          border-radius: 20px;
          border: 1px solid #e2f0ec;
          transition: transform 0.3s, box-shadow 0.3s;
      }
      .card-project:hover {
          transform: translateY(-6px);
          box-shadow: 0 15px 30px rgba(15, 76, 58, 0.08) !important;
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
          <a class="nav-link active" href="<?= e(base_url()) ?>">Beranda</a>
          <a class="nav-link" href="<?= e(base_url('portofolio.php')) ?>">Portofolio</a>
          <a class="nav-link" href="<?= e(base_url('kontak.php')) ?>">Kontak</a>
          <a class="btn rounded-pill px-4 btn-sm fw-medium shadow-sm" style="border: 1.5px solid var(--mint-primary); color: var(--mint-dark);" href="<?= e(base_url('admin/login.php')) ?>">Login Admin</a>
        </div>
    </div>
  </div>
</nav>

<main>
<!-- Hero Section -->
<section class="hero-section py-5">
  <div class="container py-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge eyebrow-badge px-3 py-2 rounded-pill fw-semibold mb-3"></span>
        <h1 class="display-4 fw-bold mb-3" style="color: var(--mint-dark);">Halo, saya <span style="color: var(--mint-primary); font-style: italic;"><?= e($namaPemilik) ?></span></h1>
        <h2 class="h5 text-secondary fw-normal mb-4"><?= e($profil['jurusan'] ?? 'Mahasiswa Manajemen Universitas') ?></h2>
        <p class="lead text-secondary fs-6 lh-lg"><?= e($profil['bio'] ?? '') ?></p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a class="btn rounded-pill px-4 py-2 text-white shadow-sm fw-medium" style="background-color: var(--mint-primary);" href="<?= e(base_url('portofolio.php')) ?>">Lihat Portofolio <i class="bi bi-arrow-right ms-1"></i></a>
          <a class="btn btn-outline-dark rounded-pill px-4 py-2 fw-medium" href="<?= e(base_url('kontak.php')) ?>">Hubungi Saya</a>
        </div>
      </div>
      <div class="col-lg-5 text-center">
        <div class="profile-container mx-auto position-relative">
            <img
                src="<?= e(base_url('uploads/Marsha.jpeg')) ?>"
                alt="Foto profil Marsha Dara Alifa"
                class="profile-photo rounded-4 shadow-lg img-fluid"
                style="max-height: 380px; object-fit: cover; border: 6px solid #ffffff;"
            >
        </div>
        <p class="small text-muted mt-3 mb-0">Manajemen • Kreativitas • Kolaborasi</p>
      </div>
    </div>
  </div>
</section>

<!-- Section About Us Estetik -->
<section class="about-section py-5">
    <div class="container py-4">
        
        <!-- Header Judul Section -->
        <div class="text-center mb-5">
            <span class="badge eyebrow-badge px-3 py-2 rounded-pill fw-semibold mb-2"></span>
            <h2 class="display-6 fw-bold" style="color: var(--mint-dark);">About Us</h2>
            <div class="mx-auto rounded-pill mt-2" style="width: 50px; height: 3px; background-color: var(--mint-medium);"></div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="about-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="about-icon-box mb-4">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <p class="text-secondary lh-lg mb-0" style="font-size: 0.95rem;">
                            <span class="text-highlight"><?= e($namaMerek) ?></span> adalah usaha pie susu rumahan (handmade) yang mengkhususkan diri pada sajian pie susu otentik berkualitas tinggi[cite: 8]. Didirikan oleh <span class="text-highlight"><?= e($namaPemilik) ?></span>, brand ini mencerminkan kecintaan pada kue buatan tangan dan kelezatan resep khas yang manis serta lembut[cite: 8]. Kami menggunakan bahan-bahan pilihan seperti mentega berkualitas dan isian vla susu yang gurih-manis untuk menciptakan perpaduan <em>crust</em> renyah dan tekstur lembut yang sempurna[cite: 8].
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="about-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="about-icon-box mb-4">
                            <i class="bi bi-stars"></i>
                        </div>
                        <p class="text-secondary lh-lg mb-0" style="font-size: 0.95rem;">
                            Setiap pie susu <span class="text-highlight"><?= e($namaMerek) ?></span> dibuat dan dipanggang secara higienis dengan penuh ketelitian untuk memastikan kesegaran serta rasa terbaik di setiap gigitannya[cite: 8]. Melalui <span class="text-highlight"><?= e($namaMerek) ?></span>, <span class="text-highlight"><?= e($namaPemilik) ?></span> ingin menghadirkan kehangatan cita rasa manis yang cocok dinikmati bersama keluarga maupun dijadikan oleh-oleh istimewa[cite: 8]. Kami bangga dapat menjadi bagian dari momen manis dalam kehidupan Anda sehari-hari[cite: 8].
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Proyek Terbaru Section -->
<section class="section-padding py-5">
  <div class="container py-3">
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <span class="badge eyebrow-badge px-3 py-2 rounded-pill fw-semibold mb-2">KARYA PILIHAN</span>
            <h2 class="fw-bold mb-0" style="color: var(--mint-dark);">Proyek Terbaru</h2>
        </div>
        <a href="<?= e(base_url('portofolio.php')) ?>" class="text-decoration-none fw-semibold" style="color: var(--mint-primary);">Lihat semua proyek &rarr;</a>
    </div>
    
    <div class="row g-4">
    <?php if (!$proyek): ?>
        <div class="col-12"><div class="alert alert-light border text-center py-5 text-muted rounded-4">Belum ada proyek. Silakan tambahkan melalui halaman admin.</div></div>
    <?php endif; ?>
    <?php foreach ($proyek as $item): ?>
        <div class="col-md-6 col-lg-4">
            <article class="card card-project h-100 border-0 shadow-sm overflow-hidden bg-white">
                <?php if (!empty($item['gambar']) && is_file(__DIR__ . '/' . $item['gambar'])): ?>
                    <img class="w-100 object-fit-cover" style="height: 220px;" src="<?= e(base_url($item['gambar'])) ?>" alt="<?= e($item['judul']) ?>">
                <?php else: ?>
                    <div class="w-100 d-flex align-items-center justify-content-center fw-medium" style="height: 220px; background: var(--mint-soft); color: var(--mint-dark);">
                        <span>Preview Proyek</span>
                    </div>
                <?php endif; ?>
                <div class="p-4 d-flex flex-column">
                    <span class="badge px-3 py-1 rounded-pill fw-normal align-self-start mb-2" style="background-color: var(--mint-soft); color: var(--mint-dark); font-size: 0.75rem;"><?= e($item['kategori']) ?></span>
                    <h3 class="h6 fw-bold text-dark mb-2"><?= e($item['judul']) ?></h3>
                    <p class="text-secondary small mb-4 flex-grow-1"><?= e(mb_strimwidth($item['deskripsi'], 0, 110, '...')) ?></p>
                    <div>
                        <a href="<?= e(base_url('detail.php?id=' . (int)$item['id'])) ?>" class="text-decoration-none fw-semibold small" style="color: var(--mint-primary);">Lihat detail &rarr;</a>
                    </div>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </div>
  </div>
</section>
</main>

<!-- Footer -->
<footer class="bg-white border-top py-4 text-muted small">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <span>© <?= date('Y') ?> <?= e($namaPemilik) ?>. All rights reserved.</span>
        <span>Website Portofolio • Pemrograman Web</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>