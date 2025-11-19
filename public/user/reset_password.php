<?php
require_once '../../config/db.php';
session_start();

// Cek apakah user adalah superadmin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'superadmin') {
    header('Location: index.php');
    exit;
}

$users = $conn->query("SELECT id, username FROM users ORDER BY username ASC");
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $new_password = $_POST['new_password'];

    if (empty($new_password)) {
        $error = "Password baru tidak boleh kosong.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        if ($stmt->execute()) {
            $success = "Password berhasil direset.";
        } else {
            $error = "Gagal mereset password.";
        }
    }
}
?>

<?php include_once ROOT_PATH .  '/views/layouts/header.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
  <h2 class="mb-4">Reset Password User</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="reset_password.php" class="card p-4 shadow">
    <div class="mb-3">
      <label for="user_id" class="form-label">Pilih User</label>
      <select name="user_id" id="user_id" class="form-select" required>
        <option value="">-- Pilih User --</option>
        <?php while ($user = $users->fetch_assoc()): ?>
          <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="new_password" class="form-label">Password Baru</label>
      <input type="password" name="new_password" id="new_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning w-100">Reset Password</button>
  </form>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>
