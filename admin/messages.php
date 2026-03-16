<?php
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/Models.php';
requireAdmin();
$model = new ThankyouModel($pdo);
$flash = getFlash();

// Mark read
if (isset($_GET['read'])) {
    $model->markRead((int)$_GET['read']);
    header('Location: messages.php'); exit;
}
$items = $model->getAll();
?>
<!DOCTYPE html><html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pesan Masuk - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css"></head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<div class="admin-main" id="adminMain">
<?php $pageTitle='Pesan Masuk'; include 'partials/topbar.php'; ?>
<div class="admin-content">
<?php if($flash): ?><div class="alert alert-<?=$flash['type']==='success'?'success':'danger'?> alert-dismissible fade show"><?=htmlspecialchars($flash['msg'])?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<div class="admin-card">
  <div class="admin-card-header"><h5><i class="bi bi-chat-dots"></i> Semua Pesan Masuk</h5><span class="badge bg-danger"><?= $model->getUnread() ?> belum dibaca</span></div>
  <div class="admin-card-body p-0">
    <div class="table-responsive">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Pesan</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php foreach($items as $i=>$m): ?>
          <tr class="<?=!$m['is_read']?'row-unread':''?>">
            <td><?=$i+1?></td>
            <td class="fw-bold"><?=htmlspecialchars($m['name'])?></td>
            <td><a href="mailto:<?=htmlspecialchars($m['email']??'')?>"><?=htmlspecialchars($m['email']??'-')?></a></td>
            <td>
              <span class="msg-preview" title="<?=htmlspecialchars($m['message'])?>"><?=htmlspecialchars(mb_substr($m['message'],0,60))?>...</span>
            </td>
            <td><?=date('d/m/Y H:i',strtotime($m['created_at']))?></td>
            <td><?=$m['is_read']?'<span class="badge bg-secondary">Dibaca</span>':'<span class="badge bg-danger">Baru</span>'?></td>
            <td>
              <?php if(!$m['is_read']): ?>
              <a href="messages.php?read=<?=$m['id']?>" class="btn-action edit" title="Tandai Dibaca"><i class="bi bi-check2"></i></a>
              <?php endif; ?>
              <a href="../aksi_hapus.php?tabel=thankyou&id=<?=$m['id']?>&redirect=admin/messages.php" class="btn-action delete" onclick="return confirm('Hapus pesan?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($items)): ?><tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pesan masuk</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('collapsed');document.getElementById('adminMain').classList.toggle('expanded');}</script>
</body></html>
