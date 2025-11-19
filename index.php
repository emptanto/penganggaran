<?php
session_start();
require 'config/db.php'; // Pastikan file koneksi database ini ada

// --- LOGIKA ---
// Cek jika user sudah login, langsung redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = null;
$notification = null;

// Pesan notifikasi dari parameter URL
if (isset($_GET['expired'])) {
    $notification = "Sesi Anda telah habis. Silakan login kembali.";
    $notification_type = "warning";
} elseif (isset($_GET['not_logged_in'])) {
    $notification = "Anda harus login terlebih dahulu untuk mengakses halaman tersebut.";
    $notification_type = "danger";
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- Cek kredensial ---
    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {
        // Query database
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session dan redirect
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['role']      = $user['role'];
                $_SESSION['login_time']= time();
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Username atau password salah.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Aplikasi Penganggaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .login-container { max-width: 400px; margin: 5rem auto; padding: 2rem; background: #fff; border-radius: .5rem; box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); }
    .login-title { text-align: center; margin-bottom: 1.5rem; }
  </style>
  </head>
<body>
<div class="login-container">
  <h3 class="login-title">Aplikasi Penganggaran</h3>

  <?php if (!empty($notification)): ?>
    <div class="alert alert-<?= htmlspecialchars($notification_type ?? 'info') ?> text-center">
      <?= htmlspecialchars($notification) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="index.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" class="form-control" id="username" required autofocus>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>

  <div class="text-center mt-3">
    <small>Belum punya akun? <a href="register.php">Daftar di sini</a></small>
  </div>
</div>
</body>
</html>