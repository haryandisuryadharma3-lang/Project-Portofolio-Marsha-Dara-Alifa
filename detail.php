<?php
require __DIR__ . '/config/koneksi.php';
require __DIR__ . '/config/helpers.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT * FROM proyek WHERE id = ?');
$stmt->execute([$id ?: 0]);
$item = $stmt->fetch();
if (!$item) { http_response_code(404); }
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Detail Proyek | Marsha Dara Alifa</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body>
<nav class="navbar bg-white border-bottom"><div class="container"><a class="navbar-brand fw-bold" href="<?= e(base_url()) ?>">Marsha<span class="text-primary">.</span></a><a href="<?= e(base_url('portofolio.php')) ?>" class="btn btn-outline-secondary btn-sm">Kembali ke portofolio</a></div></nav>
<main class="container section-padding"><div class="row justify-content-center"><div class="col-lg-9">
<?php if (!$item): ?><div class="alert alert-warning">Proyek tidak ditemukan.</div><?php else: ?>
<p class="eyebrow"><?= e($item['kategori']) ?></p><h1 class="fw-bold mb-4"><?= e($item['judul']) ?></h1>
<?php if (!empty($item['gambar']) && is_file(__DIR__ . '/' . $item['gambar'])): ?><img class="detail-image mb-4" src="<?= e(base_url($item['gambar'])) ?>" alt="<?= e($item['judul']) ?>"><?php endif; ?>
<p class="lead text-secondary"><?= nl2br(e($item['deskripsi'])) ?></p>
<?php if (!empty($item['tautan']) && filter_var($item['tautan'], FILTER_VALIDATE_URL)): ?><a class="btn btn-primary mt-3" href="<?= e($item['tautan']) ?>" target="_blank" rel="noopener noreferrer">Buka tautan proyek</a><?php endif; ?>
<?php endif; ?></div></div></main></body></html>
