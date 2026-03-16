<?php
// ============================================================
// FILE   : admin/partials/topbar.php
// NOTE   : $pageTitle must be set before including this file
// ============================================================
$pageTitle = $pageTitle ?? 'Admin';
?>
<div class="admin-topbar">
  <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <div class="topbar-title"><?= htmlspecialchars($pageTitle) ?></div>
  <div class="topbar-right d-flex align-items-center gap-3">
    <a href="../index.php" target="_blank" class="topbar-link" title="Lihat Website">
      <i class="bi bi-box-arrow-up-right"></i>
    </a>
    <div class="topbar-user">
      <i class="bi bi-person-circle"></i>
      <span><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
    </div>
  </div>
</div>
