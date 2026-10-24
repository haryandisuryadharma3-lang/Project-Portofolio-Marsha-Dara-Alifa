<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
require_admin();
if (isset($_GET['hapus_pesan']) && ctype_digit($_GET['hapus_pesan'])) {
    $stmt = $pdo->prepare('DELETE FROM pesan_kontak WHERE id=?');
    $stmt->execute([(int)$_GET['hapus_pesan']]);
    header('Location: ' . base_url('admin/proyek.php?pesan=terhapus')); exit;
}
$proyek = $pdo->query('SELECT * FROM proyek ORDER BY created_at DESC')->fetchAll();
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Kelola Proyek</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body class="admin-body"><nav class="navbar bg-white border-bottom"><div class="container"><a class="navbar-brand fw-bold" href="<?= e(base_url('admin/dashboard.php')) ?>">← Dashboard</a><a href="<?= e(base_url('logout.php')) ?>" class="btn btn-outline-danger btn-sm">Logout</a></div></nav>
<main class="container py-5"><div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"><h1 class="h2 fw-bold mb-0">Kelola Proyek</h1><a class="btn btn-primary" href="<?= e(base_url('admin/tambah_proyek.php')) ?>">+ Tambah Proyek</a></div>
<?php if (isset($_GET['status'])): ?><div class="alert alert-success">Perubahan proyek berhasil disimpan.</div><?php endif; ?>
<div class="form-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($proyek as $item): ?><tr><td><?php if ($item['gambar'] && is_file(dirname(__DIR__) . '/' . $item['gambar'])): ?><img src="<?= e(base_url($item['gambar'])) ?>" class="admin-thumb" alt="Gambar proyek"><?php else: ?><span class="text-secondary small">Tanpa gambar</span><?php endif; ?></td><td><?= e($item['judul']) ?></td><td><?= e($item['kategori']) ?></td><td><?= e($item['created_at']) ?></td><td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="<?= e(base_url('admin/edit_proyek.php?id=' . (int)$item['id'])) ?>">Edit</a><form method="post" action="<?= e(base_url('admin/hapus_proyek.php')) ?>" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button></form></div></td></tr><?php endforeach; ?>
<?php if (!$proyek): ?><tr><td colspan="5" class="text-center text-secondary">Belum ada proyek.</td></tr><?php endif; ?></tbody></table></div></div>
</main></body></html>
