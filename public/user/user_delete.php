<?php
session_start();
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid");
}

$id = intval($_GET['id']);

// Periksa apakah user ada
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Query gagal: " . $stmt->error);
}
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("User tidak ditemukan");
}

$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

// Jika bukan admin, hapus
if (trim($role) !== 'admin') {
    $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete->bind_param("i", $id);
    if (!$delete->execute()) {
        die("Gagal menghapus user: " . $delete->error);
    }
    $delete->close();
    echo "User berhasil dihapus (id: $id)";
} else {
    die("Tidak bisa menghapus user admin");
}
header("Location: user_list.php");
exit;
