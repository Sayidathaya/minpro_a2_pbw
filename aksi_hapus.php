<?php
// ============================================================
// FILE   : aksi_hapus.php
// PURPOSE: Universal delete handler for all tables
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';

requireAdmin();

$allowedTables = ['skills', 'experience', 'education', 'projects', 'certificates', 'thankyou'];

$tabel    = $_GET['tabel']    ?? '';
$id       = (int)($_GET['id'] ?? 0);
$redirect = $_GET['redirect'] ?? 'admin/index.php';

// Security: only allow whitelisted tables
if (!in_array($tabel, $allowedTables, true) || $id <= 0) {
    setFlash('error', 'Permintaan tidak valid.');
    header('Location: ' . BASE_URL . $redirect);
    exit;
}

// Optional: delete associated image file for projects/certificates
if (in_array($tabel, ['projects', 'certificates'])) {
    $stmt = $pdo->prepare("SELECT image FROM $tabel WHERE id=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row && !empty($row['image'])) {
        $imgPath = __DIR__ . '/' . $row['image'];
        if (file_exists($imgPath)) {
            @unlink($imgPath);
        }
    }
}

$stmt = $pdo->prepare("DELETE FROM $tabel WHERE id=?");
if ($stmt->execute([$id])) {
    setFlash('success', 'Data berhasil dihapus.');
} else {
    setFlash('error', 'Gagal menghapus data.');
}

header('Location: ' . BASE_URL . $redirect);
exit;
