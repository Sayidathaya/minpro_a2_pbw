<?php
// ============================================================
// FILE   : aksi_thankyou.php
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';
require_once 'app/models/Models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name']    ?? '');
    $email   = sanitize($_POST['email']   ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($name && $message) {
        $m = new ThankyouModel($pdo);
        $m->create(['name' => $name, 'email' => $email, 'message' => $message]);
        setFlash('success', 'Pesan berhasil dikirim! Terima kasih sudah menghubungi.');
    } else {
        setFlash('error', 'Nama dan pesan wajib diisi.');
    }
}

header('Location: index.php#contact');
exit;
