<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/helpers.php';
require_admin();
$profil = $pdo->query('SELECT * FROM profil WHERE id=1')->fetch();
$errors = [];
$nama = $profil['nama']; $jurusan = $profil['jurusan']; $bio = $profil['bio']; $email = $profil['email']; $whatsapp = $profil['whatsapp'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    if ($nama === '' || mb_strlen($nama) > 100) $errors[] = 'Nama wajib diisi, maksimal 100 karakter.';
    if ($jurusan === '' || mb_strlen($jurusan) > 100) $errors[] = 'Jurusan wajib diisi.';
    if (mb_strlen($bio) < 10) $errors[] = 'Bio minimal 10 karakter.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if (!preg_match('/^[0-9+() .-]{8,25}$/', $whatsapp)) $errors[] = 'Nomor WhatsApp tidak valid.';
    $newPhoto = null;
    if (!$errors) {
        try {
            $newPhoto = upload_image($_FILES['foto'] ?? [], 'uploads/profil');
            $fotoFinal = $newPhoto ?: $profil['foto'];
            $stmt = $pdo->prepare('UPDATE profil SET nama=?,jurusan=?,bio=?,email=?,whatsapp=?,foto=? WHERE id=1');
            $stmt->execute([$nama,$jurusan,$bio,$email,$whatsapp,$fotoFinal]);
            if ($newPhoto && $profil['foto']) delete_uploaded_file($profil['foto']);
            header('Location: ' . base_url('admin/profil.php?status=simpan')); exit;
        } catch (Throwable $e) {
            if ($newPhoto) delete_uploaded_file($newPhoto);
            $errors[] = $e instanceof RuntimeException ? $e->getMessage() : 'Profil gagal disimpan.';
        }
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit Profil</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="<?= e(base_url('assets/css/style.css')) ?>" rel="stylesheet"></head><body class="admin-body"><main class="container py-5"><div class="row justify-content-center"><div class="col-lg-8"><a href="<?= e(base_url('admin/dashboard.php')) ?>">← Kembali ke dashboard</a><div class="form-card mt-3"><h1 class="h3 fw-bold mb-4">Edit Profil</h1><?php if (isset($_GET['status'])): ?><div class="alert alert-success">Profil berhasil diperbarui.</div><?php endif; ?><?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" enctype="multipart/form-data"><div class="mb-3"><label class="form-label" for="nama">Nama</label><input class="form-control" id="nama" name="nama" required maxlength="100" value="<?= e($nama) ?>"></div><div class="mb-3"><label class="form-label" for="jurusan">Status/Jurusan</label><input class="form-control" id="jurusan" name="jurusan" required maxlength="100" value="<?= e($jurusan) ?>"></div><div class="mb-3"><label class="form-label" for="bio">Bio singkat</label><textarea class="form-control" id="bio" name="bio" rows="4" minlength="10" required><?= e($bio) ?></textarea></div><div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" type="email" id="email" name="email" required value="<?= e($email) ?>"></div><div class="mb-3"><label class="form-label" for="whatsapp">WhatsApp</label><input class="form-control" id="whatsapp" name="whatsapp" required value="<?= e($whatsapp) ?>"></div><?php if ($profil['foto'] && is_file(dirname(__DIR__) . '/' . $profil['foto'])): ?><div class="mb-3"><p class="form-label">Foto saat ini</p><img src="<?= e(base_url($profil['foto'])) ?>" class="admin-thumb-large" alt="Foto profil saat ini"></div><?php endif; ?><div class="mb-4"><label class="form-label" for="foto">Foto profil baru (opsional, JPG/PNG/WEBP maks. 3 MB)</label><input class="form-control" type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div><button class="btn btn-primary" type="submit">Simpan Profil</button></form></div></div></div></main></body></html>
