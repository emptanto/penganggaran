<?php
// login.php
session_start();
require 'config/db.php';

// Cek sesi login
if (isset($_GET['expired'])) {
    $expiredAlert = "<div class='alert alert-warning text-center'>Sesi Anda telah habis. Silakan login kembali.</div>";
} elseif (isset($_GET['not_logged_in'])) {
    $expiredAlert = "<div class='alert alert-danger text-center'>Silakan login terlebih dahulu.</div>";
}

$_SESSION['login_time'] = time();
$_SESSION['expire_time'] = 1800; // 30 menit

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "Username dan password wajib diisi.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = "Password salah.";
            }
        } else {
            $errors[] = "User tidak ditemukan.";
        }
    }
}
?>

<?php include 'views/layouts/header.php'; ?>

<!-- Tambahkan meta viewport di header.php jika belum -->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="w-100" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Login</h2>

    <?= isset($expiredAlert) ? $expiredAlert : '' ?>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="card p-4 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
