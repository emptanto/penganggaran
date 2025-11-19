<?php
session_start();
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
require_once ROOT_PATH .  '/config/menus.php';


// Hanya superadmin yang bisa atur hak akses
if ($_SESSION['role'] !== 'superadmin') {
    die("Akses ditolak");
}

// Ambil daftar role unik (kecuali superadmin)
$roles = [];
$resRoles = $conn->query("SELECT DISTINCT role FROM users WHERE role != 'superadmin'");
while ($row = $resRoles->fetch_assoc()) {
    $roles[] = $row['role'];
}

// Simpan perubahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    foreach ($allMenus as $key => $menu) {
        $allowed = isset($_POST['access'][$key]) ? 1 : 0;
        $stmt = $conn->prepare("
            INSERT INTO role_access (role, menu_key, allowed) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE allowed = VALUES(allowed)
        ");
        $stmt->bind_param("ssi", $role, $key, $allowed);
        $stmt->execute();
    }
    $success_message = "Hak akses untuk role <b>" . htmlspecialchars($role) . "</b> berhasil diperbarui!";
}

// Jika role dipilih
$selected_role = $_GET['role'] ?? null;
$current_access = [];
if ($selected_role) {
    $res = $conn->prepare("SELECT menu_key, allowed FROM role_access WHERE role = ?");
    $res->bind_param("s", $selected_role);
    $res->execute();
    $result = $res->get_result();
    while ($row = $result->fetch_assoc()) {
        $current_access[$row['menu_key']] = $row['allowed'];
    }
}

include_once ROOT_PATH .  '/views/layouts/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Hak Akses</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .main-container {
      max-width: 900px;
      margin: 40px auto;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .title {
      text-align: center;
      margin-bottom: 25px;
    }
  </style>
</head>
<body>

<div class="main-container">
    <h3 class="title">Manajemen Hak Akses per Role</h3>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>

    <form method="GET" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Pilih Role:</label>
            <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="">-- Pilih Role --</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r) ?>" <?= $selected_role == $r ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($selected_role): ?>
    <form method="POST">
        <input type="hidden" name="role" value="<?= htmlspecialchars($selected_role) ?>">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Izinkan?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach ($allMenus as $key => $menu): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($menu['label']) ?></td>
                            <td class="text-center">
                                <input type="checkbox" name="access[<?= $key ?>]" 
                                       <?= !empty($current_access[$key]) ? 'checked' : '' ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
