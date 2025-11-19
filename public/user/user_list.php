<?php
session_start();
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
include_once ROOT_PATH .  '/views/layouts/header.php'; 


// Ambil daftar user, kecuali admin
$users = $conn->query("SELECT id, username, role, created_at FROM users WHERE role != 'admin' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Pengguna</title>
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
    @media (max-width: 576px) {
      .table th, .table td {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container mt-4 mb-5">
  <h2 class="mb-4">Manajemen Pengguna</h2>
  <div class="card mb-3">
    <div class="card-body">  
      <div class="col-md-6">
    <h3>Perencanaan pengguna</h3>
    <a href="../../register.php" class="btn btn-primary">Register baru</a>
    <a href="role_users.php" class="btn btn-primary">Role user</a>
  </div></div></div>

<div class="card mb-3">
  <div class="card-body">
  <h3>Data User</h3>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light text-center">
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Role</th>
          <th>Terdaftar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($user = $users->fetch_assoc()): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td class="text-center"><?= $user['role'] ?></td>
            <td><?= $user['created_at'] ?></td>
            <td class="text-center">
    <a href="user_edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning me-1">
        Edit
    </a>
    
    <a href="user_delete.php?id=<?= $user['id'] ?>"
        class="btn btn-sm btn-danger"
        onclick="return confirm('Yakin ingin menghapus user ini?')">
        Hapus
    </a>
</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div></div>
  <div class="text-center mt-4">
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
  </div>
</div>

</body>
</html>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>