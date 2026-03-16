<?php
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/Models.php';
requireAdmin();
$model  = new SkillModel($pdo);
$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$flash  = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'     => sanitize($_POST['name']     ?? ''),
        'level'    => (int)($_POST['level']        ?? 0),
        'category' => sanitize($_POST['category']  ?? ''),
        'urutan'   => (int)($_POST['urutan']        ?? 0),
    ];
    $pid = (int)($_POST['id'] ?? 0);
    if ($pid) { $model->update($data, $pid); setFlash('success', 'Skill diperbarui!'); }
    else      { $model->create($data);       setFlash('success', 'Skill ditambahkan!'); }
    header('Location: skills.php'); exit;
}
$item  = ($action === 'edit' && $id) ? $model->getById($id) : null;
$items = $model->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Kelola Skills - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<div class="admin-main" id="adminMain">
<?php $pageTitle = 'Kelola Skills'; include 'partials/topbar.php'; ?>
<div class="admin-content">
<?php if($flash): ?><div class="alert alert-<?=$flash['type']==='success'?'success':'danger'?> alert-dismissible fade show"><?=htmlspecialchars($flash['msg'])?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<?php if ($action==='tambah'||$action==='edit'): ?>
<div class="admin-card">
  <div class="admin-card-header">
    <h5><?=$action==='edit'?'Edit Skill':'Tambah Skill'?></h5>
    <a href="skills.php" class="btn-link-card">← Kembali</a>
  </div>
  <div class="admin-card-body">
    <form method="POST" action="skills.php">
      <?php if($item): ?><input type="hidden" name="id" value="<?=$item['id']?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-4"><label class="form-label-admin">Nama Skill *</label>
          <input type="text" name="name" class="form-control-admin" required value="<?=htmlspecialchars($item['name']??'')?>"></div>
        <div class="col-md-3"><label class="form-label-admin">Level (0-100)</label>
          <input type="number" name="level" class="form-control-admin" min="0" max="100" value="<?=(int)($item['level']??0)?>"></div>
        <div class="col-md-3"><label class="form-label-admin">Kategori</label>
          <input type="text" name="category" class="form-control-admin" placeholder="Frontend, Backend..." value="<?=htmlspecialchars($item['category']??'')?>"></div>
        <div class="col-md-2"><label class="form-label-admin">Urutan</label>
          <input type="number" name="urutan" class="form-control-admin" value="<?=(int)($item['urutan']??0)?>"></div>
      </div>
      <div class="form-actions mt-4">
        <button type="submit" class="btn btn-admin-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="skills.php" class="btn btn-admin-cancel">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php else: ?>
<div class="admin-card">
  <div class="admin-card-header">
    <h5><i class="bi bi-lightning-charge"></i> Daftar Skills</h5>
    <a href="skills.php?action=tambah" class="btn btn-admin-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
  </div>
  <div class="admin-card-body p-0">
    <table class="admin-table">
      <thead><tr><th>#</th><th>Nama</th><th>Level</th><th>Kategori</th><th>Urutan</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php foreach($items as $i=>$s): ?>
        <tr>
          <td><?=$i+1?></td>
          <td class="fw-bold"><?=htmlspecialchars($s['name'])?></td>
          <td>
            <div class="skill-bar-mini"><div class="skill-fill-mini" style="width:<?=(int)$s['level']?>%"></div></div>
            <small><?=(int)$s['level']?>%</small>
          </td>
          <td><span class="badge-cat"><?=htmlspecialchars($s['category']??'')?></span></td>
          <td><?=$s['urutan']?></td>
          <td>
            <a href="skills.php?action=edit&id=<?=$s['id']?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
            <a href="../aksi_hapus.php?tabel=skills&id=<?=$s['id']?>&redirect=admin/skills.php" class="btn-action delete" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($items)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Belum ada skill</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('collapsed');document.getElementById('adminMain').classList.toggle('expanded');}</script>
</body></html>
