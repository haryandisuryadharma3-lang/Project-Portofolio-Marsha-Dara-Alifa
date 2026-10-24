<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
require_admin();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT * FROM proyek WHERE id=?');
$stmt->execute([$id ?: 0]);
$item = $stmt->fetch();
if (!$item) { http_response_code(404); exit('Proyek tidak ditemukan.'); }
$errors = [];
$judul = $item['judul']; $kategori = $item['kategori']; $deskripsi = $item['deskripsi']; $tautan = $item['tautan'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $tautan = trim($_POST['tautan'] ?? '');
    if ($judul === '' || mb_strlen($judul) > 150) $errors[] = 'Judul wajib diisi (maksimal 150 karakter).';
    if ($kategori === '' || mb_strlen($kategori) > 100) $errors[] = 'Kategori wajib diisi (maksimal 100 karakter).';
    if (mb_strlen($deskripsi) < 10) $errors[] = 'Deskripsi minimal 10 karakter.';
    if ($tautan !== '' && !filter_var($tautan, FILTER_VALIDATE_URL)) $errors[] = 'Tautan harus berupa URL valid.';
    $newImage = null;
    if (!$errors) {
        try {
            $newImage = upload_image($_FILES['gambar'] ?? [], 'uploads/proyek');
            $gambarFinal = $newImage ?: $item['gambar'];
            $upd = $pdo->prepare('UPDATE proyek SET judul=?,kategori=?,deskripsi=?,gambar=?,tautan=? WHERE id=?');
            $upd->execute([$judul,$kategori,$deskripsi,$gambarFinal,$tautan ?: null,$id]);
            if ($newImage && $item['gambar']) delete_uploaded_file($item['gambar']);
            header('Location: ' . base_url('admin/proyek.php?status=edit')); exit;
        } catch (Throwable $e) {
            if ($newImage) delete_uploaded_file($newImage);
            $errors[] = $e instanceof RuntimeException ? $e->getMessage() : 'Data proyek gagal diperbarui.';
        }
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit Proyek</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body class="admin-body"><main class="container py-5"><div class="row justify-content-center"><div class="col-lg-8"><a href="<?= e(base_url('admin/proyek.php')) ?>">← Kembali ke daftar proyek</a><div class="form-card mt-3"><h1 class="h3 fw-bold mb-4">Edit Proyek</h1><?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" enctype="multipart/form-data"><div class="mb-3"><label class="form-label" for="judul">Judul proyek</label><input class="form-control" id="judul" name="judul" maxlength="150" required value="<?= e($judul) ?>"></div><div class="mb-3"><label class="form-label" for="kategori">Kategori</label><input class="form-control" id="kategori" name="kategori" maxlength="100" required value="<?= e($kategori) ?>"></div><div class="mb-3"><label class="form-label" for="deskripsi">Deskripsi</label><textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" minlength="10" required><?= e($deskripsi) ?></textarea></div><div class="mb-3"><label class="form-label" for="tautan">Tautan proyek (opsional)</label><input class="form-control" type="url" id="tautan" name="tautan" value="<?= e($tautan) ?>"></div><?php if ($item['gambar'] && is_file(dirname(__DIR__) . '/' . $item['gambar'])): ?><div class="mb-3"><p class="form-label">Gambar saat ini</p><img src="<?= e(base_url($item['gambar'])) ?>" class="admin-thumb-large" alt="Gambar saat ini"></div><?php endif; ?><div class="mb-4"><label class="form-label" for="gambar">Ganti gambar (opsional, JPG/PNG/WEBP maks. 3 MB)</label><input class="form-control" type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div><button class="btn btn-primary" type="submit">Simpan Perubahan</button></form></div></div></div></main></body></html>
