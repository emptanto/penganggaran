<?php
session_start();
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';

// Pastikan hanya superadmin yang bisa mengakses
if ($_SESSION['role'] !== 'superadmin') {
    die("Akses ditolak."); // Atau redirect ke halaman lain
}

$user_id = $_GET['id'] ?? null;
$errors = [];
$success = '';

// 1. PINDAHKAN SEMUA LOGIKA PEMROSESAN FORM KE ATAS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posted_id = $_POST['id'];
    $new_role = $_POST['role'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Ambil data user saat ini untuk perbandingan
    $stmt_current = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt_current->bind_param("i", $posted_id);
    $stmt_current->execute();
    $current_user = $stmt_current->get_result()->fetch_assoc();
    $stmt_current->close();

    // Logika Update Role
    if ($new_role !== $current_user['role']) {
        $stmt_role = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt_role->bind_param("si", $new_role, $posted_id);
        if ($stmt_role->execute()) {
            $success .= "Role pengguna berhasil diubah.";
        } else {
            $errors[] = "Gagal mengubah role.";
        }
        $stmt_role->close();
    }

    // Logika Update Password (HANYA JIKA DIISI)
    if (!empty($new_password)) {
        if (strlen($new_password) < 8) {
            $errors[] = "Password baru minimal harus 8 karakter.";
        } elseif ($new_password !== $confirm_password) {
            $errors[] = "Konfirmasi password tidak cocok.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt_pass->bind_param("si", $hashed_password, $posted_id);
            if ($stmt_pass->execute()) {
                $success .= "Password pengguna berhasil diubah.";
            } else {
                $errors[] = "Gagal mengubah password.";
            }
            $stmt_pass->close();
        }
    }
    
    // Logika Redirect (JIKA TIDAK ADA ERROR)
    if (empty($errors)) {
        if (empty($success)) {
            // Jika tidak ada perubahan sama sekali
            $_SESSION['info_message'] = "Tidak ada perubahan yang disimpan.";
        } else {
            // Jika ada perubahan yang sukses
            $_SESSION['success_message'] = $success;
        }
        
        // Lakukan redirect SEKARANG JUGA
        header("Location: user_list.php");
        exit;
    }
    // Jika ada error, skrip akan lanjut ke bawah untuk menampilkan form lagi dengan pesan error.
}


// 2. LOGIKA UNTUK MENGAMBIL DATA AWAL (UNTUK TAMPILAN)
if (!$user_id || !is_numeric($user_id)) {
    die("ID pengguna tidak valid.");
}

// Ambil data user yang akan di-edit
$stmt = $conn->prepare("SELECT id, username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("Pengguna tidak ditemukan.");
}

// 3. SETELAH SEMUA LOGIKA SELESAI, BARU MULAI TAMPILKAN HALAMAN
include_once ROOT_PATH .  '/views/layouts/header.php';
?>

<div class="main-container">
    <h3 class="title">Edit Pengguna: <?= htmlspecialchars($user['username']) ?></h3>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?><p class="mb-0"><?= $error ?></p><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="user_edit.php?id=<?= htmlspecialchars($user['id']) ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div class="card mb-4">
            <div class="card-header">Edit Role</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="role" class="form-label">Role Pengguna</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Ubah Password (Opsional)</div>
            <div class="card-body">
                <div class="form-text mb-3">Kosongkan jika tidak ingin mengubah password.</div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" minlength="8">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="user_list.php" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

</body>
</html>