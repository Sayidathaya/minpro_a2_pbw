<?php
// ============================================================
// FILE   : admin/index.php  (ADMIN DASHBOARD)
// ============================================================
require_once '../config/koneksi.php';
require_once '../config/session.php';
require_once '../app/models/AboutModel.php';
require_once '../app/models/Models.php';

requireAdmin();

$about    = (new AboutModel($pdo))->get();
$skills   = (new SkillModel($pdo))->getAll();
$exps     = (new ExperienceModel($pdo))->getAll();
$edus     = (new EducationModel($pdo))->getAll();
$projs    = (new ProjectModel($pdo))->getAll();
$certs    = (new CertificateModel($pdo))->getAll();
$msgs     = (new ThankyouModel($pdo))->getAll();
$unread   = (new ThankyouModel($pdo))->getUnread();

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - SR Portfolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<!-- ═══ SIDEBAR ═══ -->
<div class="admin-sidebar" id="sidebar">
  <div class="sidebar-brand">
    <span class="brand-icon">SR</span>
    <span class="brand-text">Admin Panel</span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-group">
      <span class="nav-group-label">Main</span>
      <a href="index.php" class="nav-link-sidebar active"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="../index.php" class="nav-link-sidebar" target="_blank"><i class="bi bi-eye"></i> Lihat Website</a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Kelola Data</span>
      <a href="about.php" class="nav-link-sidebar"><i class="bi bi-person-circle"></i> About</a>
      <a href="skills.php" class="nav-link-sidebar"><i class="bi bi-lightning-charge"></i> Skills</a>
      <a href="experience.php" class="nav-link-sidebar"><i class="bi bi-briefcase"></i> Experience</a>
      <a href="education.php" class="nav-link-sidebar"><i class="bi bi-mortarboard"></i> Education</a>
      <a href="projects.php" class="nav-link-sidebar"><i class="bi bi-folder2-open"></i> Projects</a>
      <a href="certificates.php" class="nav-link-sidebar"><i class="bi bi-award"></i> Certificates</a>
      <a href="messages.php" class="nav-link-sidebar">
        <i class="bi bi-chat-dots"></i> Messages
        <?php if ($unread > 0): ?>
        <span class="badge-count"><?= $unread ?></span>
        <?php endif; ?>
      </a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Account</span>
      <a href="../logout.php" class="nav-link-sidebar text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </nav>
</div>

<!-- ═══ MAIN CONTENT ═══ -->
<div class="admin-main" id="adminMain">

  <!-- Topbar -->
  <div class="admin-topbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="topbar-title">Dashboard</div>
    <div class="topbar-user">
      <i class="bi bi-person-circle"></i>
      <span><?= htmlspecialchars($_SESSION['username']) ?></span>
    </div>
  </div>

  <!-- Content -->
  <div class="admin-content">

    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
      <?= htmlspecialchars($flash['msg']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="--c:#3b82f6"><i class="bi bi-folder2-open"></i></div>
          <div class="stat-info">
            <h3><?= count($projs) ?></h3>
            <p>Proyek</p>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="--c:#10b981"><i class="bi bi-award"></i></div>
          <div class="stat-info">
            <h3><?= count($certs) ?></h3>
            <p>Sertifikat</p>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="--c:#f59e0b"><i class="bi bi-lightning-charge"></i></div>
          <div class="stat-info">
            <h3><?= count($skills) ?></h3>
            <p>Skills</p>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="--c:#e11d48"><i class="bi bi-chat-dots"></i></div>
          <div class="stat-info">
            <h3><?= count($msgs) ?></h3>
            <p>Pesan <?php if ($unread): ?><span class="unread-dot"><?= $unread ?> baru</span><?php endif; ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card mb-4">
      <div class="admin-card-header">
        <h5><i class="bi bi-zap"></i> Aksi Cepat</h5>
      </div>
      <div class="admin-card-body">
        <div class="d-flex flex-wrap gap-2">
          <a href="projects.php?action=tambah" class="btn btn-admin-primary"><i class="bi bi-plus"></i> Tambah Proyek</a>
          <a href="certificates.php?action=tambah" class="btn btn-admin-primary"><i class="bi bi-plus"></i> Tambah Sertifikat</a>
          <a href="skills.php?action=tambah" class="btn btn-admin-secondary"><i class="bi bi-plus"></i> Tambah Skill</a>
          <a href="experience.php?action=tambah" class="btn btn-admin-secondary"><i class="bi bi-plus"></i> Tambah Pengalaman</a>
          <a href="messages.php" class="btn btn-admin-danger"><i class="bi bi-chat-dots"></i> Lihat Pesan <?php if ($unread): ?>(<?= $unread ?>)<?php endif; ?></a>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Recent Projects -->
      <div class="col-lg-6">
        <div class="admin-card">
          <div class="admin-card-header">
            <h5><i class="bi bi-folder2-open"></i> Proyek Terbaru</h5>
            <a href="projects.php" class="btn-link-card">Lihat Semua</a>
          </div>
          <div class="admin-card-body p-0">
            <table class="admin-table">
              <thead><tr><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
              <tbody>
                <?php foreach (array_slice($projs, 0, 5) as $p): ?>
                <tr>
                  <td><?= htmlspecialchars($p['title']) ?></td>
                  <td><span class="badge-cat"><?= htmlspecialchars($p['category']) ?></span></td>
                  <td>
                    <a href="projects.php?action=edit&id=<?= $p['id'] ?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
                    <a href="aksi_hapus.php?tabel=projects&id=<?= $p['id'] ?>&redirect=projects.php"
                       class="btn-action delete" onclick="return confirm('Hapus proyek ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Recent Messages -->
      <div class="col-lg-6">
        <div class="admin-card">
          <div class="admin-card-header">
            <h5><i class="bi bi-chat-dots"></i> Pesan Terbaru</h5>
            <a href="messages.php" class="btn-link-card">Lihat Semua</a>
          </div>
          <div class="admin-card-body p-0">
            <table class="admin-table">
              <thead><tr><th>Nama</th><th>Pesan</th><th>Status</th></tr></thead>
              <tbody>
                <?php foreach (array_slice($msgs, 0, 5) as $m): ?>
                <tr class="<?= !$m['is_read'] ? 'row-unread' : '' ?>">
                  <td><?= htmlspecialchars($m['name']) ?></td>
                  <td><?= htmlspecialchars(mb_substr($m['message'], 0, 40)) ?>...</td>
                  <td>
                    <?php if (!$m['is_read']): ?>
                    <span class="badge bg-danger">Baru</span>
                    <?php else: ?>
                    <span class="badge bg-secondary">Dibaca</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.admin-content -->
</div><!-- /.admin-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('collapsed');
  document.getElementById('adminMain').classList.toggle('expanded');
}
</script>
</body>
</html>
