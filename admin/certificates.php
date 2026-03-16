<?php
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/Models.php';
requireAdmin();
$model  = new CertificateModel($pdo);
$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$flash  = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title'       => sanitize($_POST['title']       ?? ''),
        'issuer'      => sanitize($_POST['issuer']      ?? ''),
        'description' => sanitize($_POST['description'] ?? ''),
        'issued_date' => sanitize($_POST['issued_date'] ?? ''),
        'cert_url'    => sanitize($_POST['cert_url']    ?? ''),
        'image'       => ''
    ];
    $imgPath = '';
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'cert_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $filename)) {
            $imgPath = 'assets/images/' . $filename;
        }
    }
    $data['image'] = $imgPath;
    $pid = (int)($_POST['id'] ?? 0);
    if ($pid) {
        $model->update($data, $pid);
        if ($imgPath) $model->updateImage($imgPath, $pid);
        setFlash('success', 'Sertifikat berhasil diperbarui!');
    } else {
        $model->create($data);
        setFlash('success', 'Sertifikat berhasil ditambahkan!');
    }
    header('Location: certificates.php'); exit;
}
$item  = ($action === 'edit' && $id) ? $model->getById($id) : null;
$items = $model->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Kelola Sertifikat - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<div class="admin-main" id="adminMain">
<?php $pageTitle = 'Kelola Sertifikat'; include 'partials/topbar.php'; ?>
<div class="admin-content">
<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type']==='success'?'success':'danger' ?> alert-dismissible fade show">
  <?= htmlspecialchars($flash['msg']) ?> <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($action === 'tambah' || $action === 'edit'): ?>
<div class="admin-card">
  <div class="admin-card-header">
    <h5><?= $action==='edit'?'<i class="bi bi-pencil"></i> Edit Sertifikat':'<i class="bi bi-plus-circle"></i> Tambah Sertifikat' ?></h5>
    <a href="certificates.php" class="btn-link-card">← Kembali</a>
  </div>
  <div class="admin-card-body">
    <form method="POST" action="certificates.php" enctype="multipart/form-data">
      <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label-admin">Judul Sertifikat *</label>
          <input type="text" name="title" class="form-control-admin" required value="<?= htmlspecialchars($item['title']??'') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Penerbit</label>
          <input type="text" name="issuer" class="form-control-admin" value="<?= htmlspecialchars($item['issuer']??'') ?>">
        </div>
        <div class="col-12">
          <label class="form-label-admin">Deskripsi</label>
          <textarea name="description" class="form-control-admin" rows="3"><?= htmlspecialchars($item['description']??'') ?></textarea>
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Tanggal Terbit</label>
          <input type="date" name="issued_date" class="form-control-admin" value="<?= htmlspecialchars($item['issued_date']??'') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">URL Sertifikat</label>
          <input type="url" name="cert_url" class="form-control-admin" value="<?= htmlspecialchars($item['cert_url']??'') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Gambar Sertifikat</label>
          <input type="file" name="image" class="form-control-admin" accept="image/*">
          <?php if (!empty($item['image'])): ?>
          <small class="text-muted">Saat ini: <?= htmlspecialchars($item['image']) ?></small>
          <?php endif; ?>
        </div>
      </div>
      <div class="form-actions mt-4">
        <button type="submit" class="btn btn-admin-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="certificates.php" class="btn btn-admin-cancel">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php else: ?>
<div class="admin-card">
  <div class="admin-card-header">
    <h5><i class="bi bi-award"></i> Daftar Sertifikat</h5>
    <a href="certificates.php?action=tambah" class="btn btn-admin-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
  </div>
  <div class="admin-card-body p-0">
    <div class="table-responsive">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Gambar</th><th>Judul</th><th>Penerbit</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php foreach ($items as $i => $c): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><img src="../<?= htmlspecialchars($c['image']??'') ?>" class="table-thumb" onerror="this.src='https://placehold.co/60x40/0f172a/fff?text=C'" alt=""></td>
            <td class="fw-bold"><?= htmlspecialchars($c['title']) ?></td>
            <td><?= htmlspecialchars($c['issuer']??'-') ?></td>
            <td><?= htmlspecialchars($c['issued_date']??'-') ?></td>
            <td>
              <a href="certificates.php?action=edit&id=<?= $c['id'] ?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
              <a href="../aksi_hapus.php?tabel=certificates&id=<?= $c['id'] ?>&redirect=admin/certificates.php" class="btn-action delete" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($items)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Belum ada sertifikat</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('collapsed');document.getElementById('adminMain').classList.toggle('expanded');}</script>
</body>
</html>
