<?php
// ============================================================
// FILE   : admin/projects.php  (CRUD Proyek)
// ============================================================
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/Models.php';

requireAdmin();

$model  = new ProjectModel($pdo);
$action = $_GET['action'] ?? 'list';
$id     = (int) ($_GET['id'] ?? 0);
$flash  = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title'       => sanitize($_POST['title']       ?? ''),
        'description' => sanitize($_POST['description'] ?? ''),
        'tech_stack'  => sanitize($_POST['tech_stack']  ?? ''),
        'demo_url'    => sanitize($_POST['demo_url']    ?? ''),
        'github_url'  => sanitize($_POST['github_url']  ?? ''),
        'category'    => sanitize($_POST['category']    ?? 'Web'),
        'featured'    => isset($_POST['featured']) ? 1 : 0,
        'image'       => ''
    ];

    // Handle image upload
    $imgPath = '';
    if (!empty($_FILES['image']['name'])) {
        $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'proj_' . time() . '.' . $ext;
        $dest     = '../assets/images/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
            $imgPath = 'assets/images/' . $filename;
        }
    }
    $data['image'] = $imgPath;

    $pid = (int) ($_POST['id'] ?? 0);
    if ($pid) {
        $model->update($data, $pid);
        if ($imgPath) $model->updateImage($imgPath, $pid);
        setFlash('success', 'Proyek berhasil diperbarui!');
    } else {
        $model->create($data);
        setFlash('success', 'Proyek berhasil ditambahkan!');
    }
    header('Location: projects.php');
    exit;
}

$item   = ($action === 'edit' && $id) ? $model->getById($id) : null;
$items  = $model->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Proyek - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<?php include 'partials/sidebar.php'; ?>

<div class="admin-main" id="adminMain">
  <?php include 'partials/topbar.php'; $pageTitle = 'Kelola Proyek'; ?>

  <div class="admin-content">
    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type']==='success'?'success':'danger' ?> alert-dismissible fade show">
      <?= htmlspecialchars($flash['msg']) ?> <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($action === 'tambah' || $action === 'edit'): ?>
    <!-- FORM -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h5><?= $action === 'edit' ? '<i class="bi bi-pencil"></i> Edit Proyek' : '<i class="bi bi-plus-circle"></i> Tambah Proyek' ?></h5>
        <a href="projects.php" class="btn-link-card">← Kembali</a>
      </div>
      <div class="admin-card-body">
        <form method="POST" action="projects.php" enctype="multipart/form-data">
          <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><?php endif; ?>
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label-admin">Judul Proyek *</label>
              <input type="text" name="title" class="form-control-admin" required value="<?= htmlspecialchars($item['title'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label-admin">Kategori</label>
              <select name="category" class="form-control-admin">
                <?php foreach (['Web','Mobile','Design','Other'] as $cat): ?>
                <option value="<?= $cat ?>" <?= ($item['category']??'Web')===$cat?'selected':'' ?>><?= $cat ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-admin">Deskripsi *</label>
              <textarea name="description" class="form-control-admin" rows="4" required><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">Tech Stack (pisahkan koma)</label>
              <input type="text" name="tech_stack" class="form-control-admin" placeholder="HTML, CSS, PHP, MySQL" value="<?= htmlspecialchars($item['tech_stack'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">Gambar Proyek</label>
              <input type="file" name="image" class="form-control-admin" accept="image/*">
              <?php if (!empty($item['image'])): ?>
              <small class="text-muted">Saat ini: <?= htmlspecialchars($item['image']) ?></small>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">URL Demo</label>
              <input type="url" name="demo_url" class="form-control-admin" value="<?= htmlspecialchars($item['demo_url'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">URL GitHub</label>
              <input type="url" name="github_url" class="form-control-admin" value="<?= htmlspecialchars($item['github_url'] ?? '') ?>">
            </div>
            <div class="col-12">
              <div class="form-check-admin">
                <input type="checkbox" name="featured" id="featured" <?= ($item['featured'] ?? 0) ? 'checked' : '' ?>>
                <label for="featured">Tandai sebagai Featured</label>
              </div>
            </div>
          </div>
          <div class="form-actions mt-4">
            <button type="submit" class="btn btn-admin-primary">
              <i class="bi bi-save"></i> <?= $action === 'edit' ? 'Simpan Perubahan' : 'Tambah Proyek' ?>
            </button>
            <a href="projects.php" class="btn btn-admin-cancel">Batal</a>
          </div>
        </form>
      </div>
    </div>

    <?php else: ?>
    <!-- LIST -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h5><i class="bi bi-folder2-open"></i> Daftar Proyek</h5>
        <a href="projects.php?action=tambah" class="btn btn-admin-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
      </div>
      <div class="admin-card-body p-0">
        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr><th>#</th><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Tech Stack</th><th>Featured</th><th>Aksi</th></tr>
            </thead>
            <tbody>
              <?php foreach ($items as $i => $p): ?>
              <tr>
                <td><?= $i+1 ?></td>
                <td><img src="../<?= htmlspecialchars($p['image'] ?? '') ?>" class="table-thumb" onerror="this.src='https://placehold.co/60x40/1e293b/fff?text=P'" alt=""></td>
                <td class="fw-bold"><?= htmlspecialchars($p['title']) ?></td>
                <td><span class="badge-cat"><?= htmlspecialchars($p['category']) ?></span></td>
                <td class="text-muted small"><?= htmlspecialchars(mb_substr($p['tech_stack'] ?? '', 0, 40)) ?></td>
                <td><?= $p['featured'] ? '<i class="bi bi-star-fill text-warning"></i>' : '-' ?></td>
                <td>
                  <a href="projects.php?action=edit&id=<?= $p['id'] ?>" class="btn-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a href="../aksi_hapus.php?tabel=projects&id=<?= $p['id'] ?>&redirect=admin/projects.php"
                     class="btn-action delete" title="Hapus" onclick="return confirm('Yakin hapus proyek ini?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($items)): ?>
              <tr><td colspan="7" class="text-center text-muted py-4">Belum ada proyek</td></tr>
              <?php endif; ?>
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
