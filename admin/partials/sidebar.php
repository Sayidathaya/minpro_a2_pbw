<?php
// ============================================================
// FILE   : admin/partials/sidebar.php
// ============================================================
require_once __DIR__ . '/../../config/session.php';
$unreadCount = 0;
try {
    global $pdo;
    $unreadCount = (int)$pdo->query("SELECT COUNT(*) FROM thankyou WHERE is_read=0")->fetchColumn();
} catch(Exception $e) {}

$currentFile = basename($_SERVER['PHP_SELF']);
?>
<div class="admin-sidebar" id="sidebar">
  <div class="sidebar-brand">
    <span class="brand-icon">SR</span>
    <span class="brand-text">Admin Panel</span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-group">
      <span class="nav-group-label">Main</span>
      <a href="../admin/index.php"   class="nav-link-sidebar <?= $currentFile==='index.php'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="../index.php" class="nav-link-sidebar" target="_blank"><i class="bi bi-eye"></i> Lihat Website</a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Kelola Data</span>
      <a href="../admin/about.php"        class="nav-link-sidebar <?= $currentFile==='about.php'?'active':'' ?>"><i class="bi bi-person-circle"></i> About</a>
      <a href="../admin/skills.php"       class="nav-link-sidebar <?= $currentFile==='skills.php'?'active':'' ?>"><i class="bi bi-lightning-charge"></i> Skills</a>
      <a href="../admin/experience.php"   class="nav-link-sidebar <?= $currentFile==='experience.php'?'active':'' ?>"><i class="bi bi-briefcase"></i> Experience</a>
      <a href="../admin/education.php"    class="nav-link-sidebar <?= $currentFile==='education.php'?'active':'' ?>"><i class="bi bi-mortarboard"></i> Education</a>
      <a href="../admin/projects.php"     class="nav-link-sidebar <?= $currentFile==='projects.php'?'active':'' ?>"><i class="bi bi-folder2-open"></i> Projects</a>
      <a href="../admin/certificates.php" class="nav-link-sidebar <?= $currentFile==='certificates.php'?'active':'' ?>"><i class="bi bi-award"></i> Certificates</a>
      <a href="../admin/messages.php"     class="nav-link-sidebar <?= $currentFile==='messages.php'?'active':'' ?>">
        <i class="bi bi-chat-dots"></i> Messages
        <?php if ($unreadCount > 0): ?>
        <span class="badge-count"><?= $unreadCount ?></span>
        <?php endif; ?>
      </a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Account</span>
      <span class="nav-link-sidebar nav-user"><i class="bi bi-person-fill"></i> <?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
      <a href="../logout.php" class="nav-link-sidebar text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </nav>
</div>
