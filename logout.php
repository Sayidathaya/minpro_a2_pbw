<?php
// ============================================================
// FILE   : logout.php
// ============================================================
require_once 'config/koneksi.php';
require_once 'config/session.php';

session_destroy();
header('Location: login.php');
exit;
