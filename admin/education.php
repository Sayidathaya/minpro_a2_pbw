<?php
// ============================================================
// FILE   : admin/education.php
// ============================================================
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/Models.php';
requireAdmin();
$model  = new EducationModel($pdo);
$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$flash  = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'institution' => sanitize($_POST['institution'] ?? ''),
        'degree'      => sanitize($_POST['degree']      ?? ''),
        'field'       => sanitize($_POST['field']       ?? ''),
        'year_start'  => (int)($_POST['year_start']      ?? 0),
        'year_end'    => (int)($_POST['year_end']         ?? 0),
        'description' => sanitize($_POST['description'] ?? ''),
        'urutan'      => (int)($_POST['urutan']           ?? 0),
    ];
    $pid = (int)($_POST['id'] ?? 0);
    if ($pid) { $model->update($data, $pid); setFlash('success', 'Pendidikan diperbarui!'); }
    else      { $model->create($data);       setFlash('success', 'Pendidikan ditambahkan!'); }
    header('Location: education.php'); exit;
}
$item  = ($action==='edit'&&$id) ? $model->getById($id) : null;
$items = $model->getAll();
?>
<!DOCTYPE html><html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kelola Pendidikan - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css"></head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<div class="admin-main" id="adminMain">
<?php $pageTitle='Kelola Pendidikan'; include 'partials/topbar.php'; ?>
<div class="admin-content">
<?php if($flash): ?><div class="alert alert-<?=$flash['type']==='success'?'success':'danger'?> alert-dismissible fade show"><?=htmlspecialchars($flash['msg'])?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<?php if($action==='tambah'||$action==='edit'): ?>
<div class="admin-card">
  <div class="admin-card-header"><h5><?=$action==='edit'?'Edit Pendidikan':'Tambah Pendidikan'?></h5><a href="education.php" class="btn-link-card">← Kembali</a></div>
  <div class="admin-card-body">
    <form method="POST" action="education.php">
      <?php if($item): ?><input type="hidden" name="id" value="<?=$item['id']?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-8"><label class="form-label-admin">Institusi *</label><input type="text" name="institution" class="form-control-admin" required value="<?=htmlspecialchars($item['institution']??'')?>"></div>
        <div class="col-md-4"><label class="form-label-admin">Urutan</label><input type="number" name="urutan" class="form-control-admin" value="<?=(int)($item['urutan']??0)?>"></div>
        <div class="col-md-6"><label class="form-label-admin">Jenjang / Gelar *</label><input type="text" name="degree" class="form-control-admin" required value="<?=htmlspecialchars($item['degree']??'')?>"></div>
        <div class="col-md-6"><label class="form-label-admin">Bidang Studi</label><input type="text" name="field" class="form-control-admin" value="<?=htmlspecialchars($item['field']??'')?>"></div>
        <div class="col-md-3"><label class="form-label-admin">Tahun Mulai</label><input type="number" name="year_start" class="form-control-admin" value="<?=(int)($item['year_start']??0)?>"></div>
        <div class="col-md-3"><label class="form-label-admin">Tahun Selesai</label><input type="number" name="year_end" class="form-control-admin" value="<?=(int)($item['year_end']??0)?>"></div>
        <div class="col-12"><label class="form-label-admin">Deskripsi</label><textarea name="description" class="form-control-admin" rows="3"><?=htmlspecialchars($item['description']??'')?></textarea></div>
      </div>
      <div class="form-actions mt-4">
        <button type="submit" class="btn btn-admin-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="education.php" class="btn btn-admin-cancel">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php else: ?>
<div class="admin-card">
  <div class="admin-card-header"><h5><i class="bi bi-mortarboard"></i> Daftar Pendidikan</h5><a href="education.php?action=tambah" class="btn btn-admin-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a></div>
  <div class="admin-card-body p-0">
    <table class="admin-table">
      <thead><tr><th>#</th><th>Institusi</th><th>Gelar</th><th>Tahun</th><th>Urutan</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php foreach($items as $i=>$e): ?>
        <tr>
          <td><?=$i+1?></td>
          <td class="fw-bold"><?=htmlspecialchars($e['institution'])?></td>
          <td><?=htmlspecialchars($e['degree'])?></td>
          <td><?=htmlspecialchars($e['year_start'].' - '.$e['year_end'])?></td>
          <td><?=$e['urutan']?></td>
          <td>
            <a href="education.php?action=edit&id=<?=$e['id']?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
            <a href="../aksi_hapus.php?tabel=education&id=<?=$e['id']?>&redirect=admin/education.php" class="btn-action delete" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($items)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
</div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('collapsed');document.getElementById('adminMain').classList.toggle('expanded');}</script>
</body></html>
