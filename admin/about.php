<?php
// ============================================================
// FILE   : admin/about.php  (Edit About)
// ============================================================
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/AboutModel.php';
requireAdmin();

$model = new AboutModel($pdo);
$about = $model->get();
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'        => sanitize($_POST['name']        ?? ''),
        'title'       => sanitize($_POST['title']       ?? ''),
        'description' => sanitize($_POST['description'] ?? ''),
        'email'       => sanitize($_POST['email']       ?? ''),
        'phone'       => sanitize($_POST['phone']       ?? ''),
        'location'    => sanitize($_POST['location']    ?? ''),
    ];
    $model->update($data, $about['id']);

    // Upload foto profil
    if (!empty($_FILES['photo']['name'])) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fn  = 'profile_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/images/'.$fn)) {
            $model->updatePhoto('photo', 'assets/images/'.$fn, $about['id']);
        }
    }
    // Upload hero image
    if (!empty($_FILES['hero_image']['name'])) {
        $ext = pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION);
        $fn  = 'hero_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['hero_image']['tmp_name'], '../assets/images/'.$fn)) {
            $model->updatePhoto('hero_image', 'assets/images/'.$fn, $about['id']);
        }
    }
    setFlash('success', 'Data about berhasil diperbarui!');
    header('Location: about.php'); exit;
}

$about = $model->get(); // Re-fetch after possible update
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Kelola About - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<div class="admin-main" id="adminMain">
<?php $pageTitle = 'Kelola About'; include 'partials/topbar.php'; ?>
<div class="admin-content">
<?php if($flash): ?><div class="alert alert-<?=$flash['type']==='success'?'success':'danger'?> alert-dismissible fade show"><?=htmlspecialchars($flash['msg'])?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<div class="admin-card">
  <div class="admin-card-header"><h5><i class="bi bi-person-circle"></i> Data About</h5></div>
  <div class="admin-card-body">
    <form method="POST" action="about.php" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label-admin">Nama Lengkap *</label>
          <input type="text" name="name" class="form-control-admin" required value="<?=htmlspecialchars($about['name']??'')?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Judul / Jabatan *</label>
          <input type="text" name="title" class="form-control-admin" required value="<?=htmlspecialchars($about['title']??'')?>">
        </div>
        <div class="col-12">
          <label class="form-label-admin">Deskripsi / Bio *</label>
          <textarea name="description" class="form-control-admin" rows="5" required><?=htmlspecialchars($about['description']??'')?></textarea>
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Email</label>
          <input type="email" name="email" class="form-control-admin" value="<?=htmlspecialchars($about['email']??'')?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Telepon</label>
          <input type="text" name="phone" class="form-control-admin" value="<?=htmlspecialchars($about['phone']??'')?>">
        </div>
        <div class="col-md-4">
          <label class="form-label-admin">Lokasi</label>
          <input type="text" name="location" class="form-control-admin" value="<?=htmlspecialchars($about['location']??'')?>">
        </div>
        <div class="col-md-6">
          <label class="form-label-admin">Foto Profil</label>
          <input type="file" name="photo" class="form-control-admin" accept="image/*">
          <?php if(!empty($about['photo'])): ?>
          <div class="mt-2"><img src="../<?=htmlspecialchars($about['photo'])?>" class="preview-img" onerror="this.style.display='none'" alt="Foto"></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label-admin">Gambar Hero (About Section)</label>
          <input type="file" name="hero_image" class="form-control-admin" accept="image/*">
          <?php if(!empty($about['hero_image'])): ?>
          <div class="mt-2"><img src="../<?=htmlspecialchars($about['hero_image'])?>" class="preview-img" onerror="this.style.display='none'" alt="Hero"></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="form-actions mt-4">
        <button type="submit" class="btn btn-admin-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('collapsed');document.getElementById('adminMain').classList.toggle('expanded');}</script>
</body></html>
