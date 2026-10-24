<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    return '/portfolio_marsha/' . ltrim($path, '/');
}

function require_admin(): void {
    if (empty($_SESSION['admin_id'])) {
        header('Location: ' . base_url('admin/login.php'));
        exit;
    }
}

function upload_image(array $file, string $folder, array $allowed = ['image/jpeg', 'image/png', 'image/webp']): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload gambar gagal. Coba lagi.');
    }
    if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 3 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!in_array($mime, $allowed, true) || !isset($extensions[$mime])) {
        throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.');
    }

    $relativeFolder = trim($folder, '/');
    $targetDir = dirname(__DIR__) . '/' . $relativeFolder;
    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Folder upload tidak dapat dibuat.');
    }
    $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($file['tmp_name'], $targetDir . '/' . $filename)) {
        throw new RuntimeException('Gambar tidak dapat disimpan.');
    }
    return $relativeFolder . '/' . $filename;
}

function delete_uploaded_file(?string $relativePath): void {
    if (!$relativePath) return;
    $safePath = str_replace('\\', '/', $relativePath);
    if (str_starts_with($safePath, 'uploads/') && !str_contains($safePath, '..')) {
        $full = dirname(__DIR__) . '/' . $safePath;
        if (is_file($full)) @unlink($full);
    }
}
