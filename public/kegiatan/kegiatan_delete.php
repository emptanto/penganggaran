<?php
require_once '../../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Siapkan dan eksekusi perintah hapus
    $stmt = $conn->prepare("DELETE FROM kegiatan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: kegiatan_list.php");
exit;
