<?php
// ============================================================
// FILE   : project-detail.php  (Halaman Detail Proyek)
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';
require_once 'app/models/AboutModel.php';
require_once 'app/models/Models.php';

$id    = (int) ($_GET['id'] ?? 0);
$projM = new ProjectModel($pdo);
$proj  = $projM->getById($id);

if (!$proj) {
    header('Location: index.php#projects');
    exit;
}

$about = (new AboutModel($pdo))->get();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($proj['title']) ?> - SR Portfolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="index.php"><span class="brand-dot"></span>SR</a>
    <div class="ms-auto">
      <a href="index.php#projects" class="btn btn-outline-custom btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>
  </div>
</nav>

<div class="detail-page">
  <div class="container pt-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb-custom">
        <li><a href="index.php">Home</a></li>
        <li><i class="bi bi-chevron-right"></i></li>
        <li><a href="index.php#projects">Projects</a></li>
        <li><i class="bi bi-chevron-right"></i></li>
        <li class="active"><?= htmlspecialchars($proj['title']) ?></li>
      </ol>
    </nav>

    <div class="row g-5">
      <div class="col-lg-7">
        <img src="<?= htmlspecialchars($proj['image'] ?? '') ?>"
             class="detail-img w-100 rounded-3 mb-4" alt="<?= htmlspecialchars($proj['title']) ?>"
             onerror="this.src='https://placehold.co/800x500/1e293b/e11d48?text=Project'">
      </div>
      <div class="col-lg-5">
        <span class="detail-category"><?= htmlspecialchars($proj['category']) ?></span>
        <h1 class="detail-title"><?= htmlspecialchars($proj['title']) ?></h1>
        <p class="detail-desc"><?= nl2br(htmlspecialchars($proj['description'])) ?></p>

        <div class="detail-tech mb-4">
          <h6 class="fw-bold mb-2">Tech Stack:</h6>
          <?php foreach (explode(',', $proj['tech_stack'] ?? '') as $t): ?>
          <span class="tech-tag"><?= htmlspecialchars(trim($t)) ?></span>
          <?php endforeach; ?>
        </div>

        <div class="d-flex gap-3 flex-wrap">
          <?php if (!empty($proj['demo_url'])): ?>
          <a href="<?= htmlspecialchars($proj['demo_url']) ?>" class="btn btn-primary-custom" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Live Demo
          </a>
          <?php endif; ?>
          <?php if (!empty($proj['github_url'])): ?>
          <a href="<?= htmlspecialchars($proj['github_url']) ?>" class="btn btn-outline-custom" target="_blank">
            <i class="bi bi-github"></i> Source Code
          </a>
          <?php endif; ?>
        </div>

        <div class="detail-meta mt-4">
          <span><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($proj['created_at'])) ?></span>
          <?php if ($proj['featured']): ?>
          <span class="ms-3"><i class="bi bi-star-fill text-warning"></i> Featured</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="site-footer mt-5">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-brand">SR Portfolio</div>
      <p class="footer-copy">© 2026 <?= htmlspecialchars($about['name'] ?? '') ?>. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
