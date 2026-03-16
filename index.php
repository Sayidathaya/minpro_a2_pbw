<?php
// ============================================================
// FILE   : index.php  (PUBLIC HOMEPAGE - SPA Mode)
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';
require_once 'app/models/AboutModel.php';
require_once 'app/models/Models.php';

$aboutM  = new AboutModel($pdo);
$skillM  = new SkillModel($pdo);
$expM    = new ExperienceModel($pdo);
$eduM    = new EducationModel($pdo);
$projM   = new ProjectModel($pdo);
$certM   = new CertificateModel($pdo);

$about   = $aboutM->get();
$skills  = $skillM->getAll();
$exps    = $expM->getAll();
$edus    = $eduM->getAll();
$projs   = $projM->getAll();
$certs   = $certM->getAll();

$flash   = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio - <?= htmlspecialchars($about['name'] ?? 'Sayid Rafi') ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body id="app-body">

<div id="app">

<!-- ═══════════════════ NAVBAR ═══════════════════ -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="#home">
      <span class="brand-dot"></span>SR
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>
    <div class="collapse navbar-collapse" id="navLinks">
      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item"><a class="nav-link" href="#home" @click="activePage='home'">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about" @click="activePage='about'">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#projects" @click="activePage='projects'">Projects</a></li>
        <li class="nav-item"><a class="nav-link" href="#certificates" @click="activePage='certs'">Certificates</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact" @click="activePage='contact'">Contact</a></li>
        <?php if (isAdmin()): ?>
        <li class="nav-item">
          <a class="btn btn-sm btn-warning ms-2 fw-bold" href="admin/index.php">
            <i class="bi bi-speedometer2"></i> Admin
          </a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="btn btn-sm btn-outline-light ms-2" href="login.php">Login</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- ═══════════════════ HERO ═══════════════════ -->
<section id="home" class="hero-section">
  <div class="hero-bg-grid"></div>
  <div class="container h-100 d-flex align-items-center">
    <div class="row w-100 align-items-center">
      <div class="col-lg-7" data-aos="fade-right">
        <p class="hero-tag"><span class="tag-dot"></span> Available for Work</p>
        <h1 class="hero-title">
          <?= htmlspecialchars($about['name'] ?? 'Sayid Rafi') ?>
        </h1>
        <p class="hero-subtitle"><?= htmlspecialchars($about['title'] ?? '') ?></p>
        <p class="hero-desc"><?= htmlspecialchars($about['description'] ?? '') ?></p>
        <div class="hero-cta d-flex gap-3 flex-wrap mt-4">
          <a href="#projects" class="btn btn-primary-custom">Lihat Proyek <i class="bi bi-arrow-right"></i></a>
          <a href="#contact" class="btn btn-outline-custom">Hubungi Saya</a>
        </div>
        <div class="hero-socials mt-4">
          <a href="mailto:<?= htmlspecialchars($about['email'] ?? '') ?>" title="Email"><i class="bi bi-envelope"></i></a>
          <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
          <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="tel:<?= htmlspecialchars($about['phone'] ?? '') ?>" title="Phone"><i class="bi bi-telephone"></i></a>
        </div>
      </div>
      <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-left">
        <div class="hero-image-wrap">
          <div class="hero-image-ring"></div>
          <img src="<?= htmlspecialchars($about['photo'] ?? 'assets/images/profile.jpg') ?>"
               class="hero-profile-img" alt="Profile Photo"
               onerror="this.src='https://ui-avatars.com/api/?name=Sayid+Rafi&size=300&background=e11d48&color=fff'">
          <div class="hero-badge">
            <i class="bi bi-code-slash"></i>
            <span>Web Dev</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-scroll-indicator">
    <a href="#about"><i class="bi bi-chevron-compact-down"></i></a>
  </div>
</section>

<!-- ═══════════════════ ABOUT ═══════════════════ -->
<section id="about" class="section-about">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <span class="section-tag">Tentang Saya</span>
      <h2 class="section-title">Kenali Lebih Dekat</h2>
    </div>

    <div class="row g-5 align-items-center">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="about-image-wrap">
          <img src="<?= htmlspecialchars($about['hero_image'] ?? 'assets/images/hero.jpg') ?>"
               class="about-img" alt="About"
               onerror="this.src='https://ui-avatars.com/api/?name=Sayid+Rafi&size=400&background=f1f5f9&color=e11d48'">
          <div class="about-info-card">
            <div class="about-info-item">
              <i class="bi bi-geo-alt-fill"></i>
              <span><?= htmlspecialchars($about['location'] ?? 'Samarinda') ?></span>
            </div>
            <div class="about-info-item">
              <i class="bi bi-envelope-fill"></i>
              <span><?= htmlspecialchars($about['email'] ?? '-') ?></span>
            </div>
            <div class="about-info-item">
              <i class="bi bi-telephone-fill"></i>
              <span><?= htmlspecialchars($about['phone'] ?? '-') ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <p class="about-text"><?= nl2br(htmlspecialchars($about['description'] ?? '')) ?></p>

        <!-- Skills -->
        <div class="mt-4">
          <h5 class="subsection-title mb-3"><i class="bi bi-lightning-charge-fill"></i> Skills</h5>
          <?php foreach ($skills as $sk): ?>
          <div class="skill-item mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="skill-name"><?= htmlspecialchars($sk['name']) ?></span>
              <span class="skill-pct"><?= (int)$sk['level'] ?>%</span>
            </div>
            <div class="skill-bar">
              <div class="skill-fill" style="width:<?= (int)$sk['level'] ?>%"></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Experience & Education Tabs -->
        <div class="mt-5">
          <ul class="nav nav-tabs-custom mb-3" id="aboutTabs">
            <li><a class="tab-btn active" data-tab="exp">Pengalaman</a></li>
            <li><a class="tab-btn" data-tab="edu">Pendidikan</a></li>
          </ul>

          <div id="tab-exp" class="tab-content-custom">
            <?php foreach ($exps as $e): ?>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h6 class="tl-title"><?= htmlspecialchars($e['position']) ?></h6>
                <span class="tl-company"><?= htmlspecialchars($e['company']) ?></span>
                <span class="tl-period"><?= htmlspecialchars($e['period']) ?></span>
                <p class="tl-desc"><?= htmlspecialchars($e['description'] ?? '') ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <div id="tab-edu" class="tab-content-custom d-none">
            <?php foreach ($edus as $e): ?>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h6 class="tl-title"><?= htmlspecialchars($e['institution']) ?></h6>
                <span class="tl-company"><?= htmlspecialchars($e['degree']) . ($e['field'] ? ' - '.$e['field'] : '') ?></span>
                <span class="tl-period"><?= htmlspecialchars($e['year_start'].' - '.$e['year_end']) ?></span>
                <p class="tl-desc"><?= htmlspecialchars($e['description'] ?? '') ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ PROJECTS ═══════════════════ -->
<section id="projects" class="section-projects">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <span class="section-tag">Portfolio</span>
      <h2 class="section-title">Proyek Saya</h2>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs text-center mb-4" data-aos="fade-up">
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="Web">Web</button>
      <button class="filter-btn" data-filter="Mobile">Mobile</button>
      <button class="filter-btn" data-filter="Design">Design</button>
    </div>

    <div class="row g-4" id="projectsGrid">
      <?php foreach ($projs as $p): ?>
      <div class="col-md-6 col-lg-4 project-card-wrap" data-category="<?= htmlspecialchars($p['category']) ?>">
        <div class="project-card" data-aos="fade-up">
          <div class="project-img-wrap">
            <img src="<?= htmlspecialchars($p['image'] ?? 'assets/images/project-placeholder.jpg') ?>"
                 class="project-img" alt="<?= htmlspecialchars($p['title']) ?>"
                 onerror="this.src='https://placehold.co/600x400/1e293b/e11d48?text=Project'">
            <?php if ($p['featured']): ?>
            <span class="project-badge">Featured</span>
            <?php endif; ?>
          </div>
          <div class="project-body">
            <span class="project-category"><?= htmlspecialchars($p['category']) ?></span>
            <h5 class="project-title"><?= htmlspecialchars($p['title']) ?></h5>
            <p class="project-desc"><?= htmlspecialchars(mb_substr($p['description'], 0, 100)) ?>...</p>
            <div class="project-tech">
              <?php foreach (explode(',', $p['tech_stack'] ?? '') as $t): ?>
              <span class="tech-tag"><?= htmlspecialchars(trim($t)) ?></span>
              <?php endforeach; ?>
            </div>
            <div class="project-links mt-3">
              <?php if (!empty($p['demo_url'])): ?>
              <a href="<?= htmlspecialchars($p['demo_url']) ?>" class="project-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Demo
              </a>
              <?php endif; ?>
              <?php if (!empty($p['github_url'])): ?>
              <a href="<?= htmlspecialchars($p['github_url']) ?>" class="project-link" target="_blank">
                <i class="bi bi-github"></i> GitHub
              </a>
              <?php endif; ?>
              <a href="project-detail.php?id=<?= $p['id'] ?>" class="project-link-detail">
                Detail <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════ CERTIFICATES ═══════════════════ -->
<section id="certificates" class="section-certs">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <span class="section-tag">Achievements</span>
      <h2 class="section-title">Sertifikat & Penghargaan</h2>
    </div>

    <div class="row g-4">
      <?php foreach ($certs as $c): ?>
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <div class="cert-card">
          <div class="cert-img-wrap">
            <img src="<?= htmlspecialchars($c['image'] ?? '') ?>"
                 class="cert-img" alt="<?= htmlspecialchars($c['title']) ?>"
                 onerror="this.src='https://placehold.co/600x400/0f172a/fbbf24?text=Certificate'">
          </div>
          <div class="cert-body">
            <span class="cert-issuer"><i class="bi bi-award"></i> <?= htmlspecialchars($c['issuer'] ?? '') ?></span>
            <h5 class="cert-title"><?= htmlspecialchars($c['title']) ?></h5>
            <p class="cert-desc"><?= htmlspecialchars($c['description'] ?? '') ?></p>
            <div class="cert-footer">
              <span class="cert-date"><i class="bi bi-calendar3"></i> <?= htmlspecialchars($c['issued_date'] ?? '') ?></span>
              <?php if (!empty($c['cert_url'])): ?>
              <a href="<?= htmlspecialchars($c['cert_url']) ?>" class="cert-btn" target="_blank">Lihat <i class="bi bi-arrow-up-right"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════ CONTACT ═══════════════════ -->
<section id="contact" class="section-contact">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <span class="section-tag">Kontak</span>
      <h2 class="section-title">Hubungi Saya</h2>
    </div>

    <div class="row g-5 justify-content-center">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="contact-info">
          <h4 class="contact-heading">Mari Berkolaborasi!</h4>
          <p class="contact-text">Punya proyek menarik? Saya selalu terbuka untuk diskusi dan peluang baru.</p>
          <div class="contact-detail"><i class="bi bi-envelope-fill"></i> <?= htmlspecialchars($about['email'] ?? '-') ?></div>
          <div class="contact-detail"><i class="bi bi-telephone-fill"></i> <?= htmlspecialchars($about['phone'] ?? '-') ?></div>
          <div class="contact-detail"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($about['location'] ?? '-') ?></div>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
          <?= htmlspecialchars($flash['msg']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <div class="contact-form-wrap">
          <form action="aksi_thankyou.php" method="POST" id="contactForm">
            <div class="mb-3">
              <input type="text" name="name" class="form-control-custom" placeholder="Nama Anda *" required>
            </div>
            <div class="mb-3">
              <input type="email" name="email" class="form-control-custom" placeholder="Email Anda">
            </div>
            <div class="mb-3">
              <textarea name="message" class="form-control-custom" rows="5" placeholder="Pesan Anda *" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary-custom w-100">
              Kirim Pesan <i class="bi bi-send"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ FOOTER ═══════════════════ -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-brand">SR Portfolio</div>
      <p class="footer-copy">© 2026 <?= htmlspecialchars($about['name'] ?? 'Sayid Rafi') ?>. All rights reserved.</p>
      <div class="footer-nav">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#projects">Projects</a>
        <a href="#contact">Contact</a>
      </div>
    </div>
  </div>
</footer>

</div><!-- /#app -->

<!-- Vue JS 3 -->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>

</body>
</html>
