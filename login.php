<?php
// ============================================================
// FILE   : login.php
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';

if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? 'admin/index.php' : 'index.php'));
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header('Location: ' . ($user['role'] === 'admin' ? 'admin/index.php' : 'index.php'));
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Harap isi semua field.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SR Portfolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

<div class="login-wrapper">
  <div class="login-card">
    <div class="login-header">
      <div class="login-logo">SR</div>
      <h2 class="login-title">Admin Login</h2>
      <p class="login-subtitle">Masuk ke panel manajemen portfolio</p>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
      <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3">
        <label class="form-label-custom">Username</label>
        <div class="input-icon-wrap">
          <i class="bi bi-person-fill input-icon"></i>
          <input type="text" name="username" class="form-control-custom with-icon"
                 placeholder="Masukkan username" required
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label-custom">Password</label>
        <div class="input-icon-wrap">
          <i class="bi bi-lock-fill input-icon"></i>
          <input type="password" name="password" class="form-control-custom with-icon"
                 placeholder="Masukkan password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </button>
    </form>

    <div class="login-back mt-3 text-center">
      <a href="index.php"><i class="bi bi-arrow-left"></i> Kembali ke Portfolio</a>
    </div>

    <div class="login-hint mt-3 text-center">
      <small class="text-muted">Default: <code>sayidrafi</code> / <code>password</code></small>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
