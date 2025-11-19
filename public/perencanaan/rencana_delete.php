<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Cek apakah user adalah superadmin atau pemilik data
    $userId = $_SESSION['user_id'];
    $isSuperadmin = $_SESSION['role'] === 'superadmin';

    $check = $conn->prepare("SELECT user_id FROM rencana WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($isSuperadmin || $row['user_id'] == $userId) {
            $delete = $conn->prepare("DELETE FROM rencana WHERE id = ?");
            $delete->bind_param("i", $id);
            $delete->execute();
        }
    }
}

// Tentukan tujuan redirect: ke halaman sebelumnya jika ada, jika tidak, ke halaman default.
$redirect_url = $_SESSION['previous_url'] ?? 'rencana_list.php';

// Tambahkan parameter status=delete_sukses ke URL tujuan secara cerdas.
if (strpos($redirect_url, '?') === false) {
    // Jika tidak ada '?', tambahkan dengan '?'.
    $redirect_url .= '?status=delete_sukses';
} else {
    // Jika sudah ada '?', tambahkan dengan '&'.
    $redirect_url .= '&status=delete_sukses';
}

// Lakukan redirect dan hentikan eksekusi skrip.
header("Location: " . $redirect_url);
exit;
