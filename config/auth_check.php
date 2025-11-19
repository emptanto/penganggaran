<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php'; // koneksi DB

// ====== CEK LOGIN ======
if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php?not_logged_in=1");
    exit;
}

// ====== CEK TIMEOUT ======
$timeout_duration = 1800; // dalam detik
if (isset($_SESSION['login_time']) && time() - $_SESSION['login_time'] > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ./index.php?expired=1");
    exit;
}
$_SESSION['login_time'] = time();

// ====== CEK AKSES HALAMAN ======
function check_access($menu_key) {
    global $conn;

    $userId = $_SESSION['user_id'] ?? 0;

    // Ambil role user
    $stmtRole = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmtRole->bind_param("i", $userId);
    $stmtRole->execute();
    $resultRole = $stmtRole->get_result();
    $role = $resultRole->fetch_assoc()['role'] ?? '';

    if (!$role) {
        header("Location: ./index.php?not_logged_in=1");
        exit;
    }

    // Cek izin di role_access
    $stmt = $conn->prepare("SELECT allowed FROM role_access WHERE role = ? AND menu_key = ?");
    $stmt->bind_param("ss", $role, $menu_key);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || $row['allowed'] != 1) {
        header("HTTP/1.1 403 Forbidden");
        echo "<h1>Akses Ditolak</h1><p>Anda tidak memiliki izin untuk halaman ini.</p>";
        exit;
    }
}
?>
