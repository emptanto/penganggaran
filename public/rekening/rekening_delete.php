<?php
require_once '../../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Siapkan dan jalankan perintah hapus
    $stmt = $conn->prepare("DELETE FROM rekening WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: rekening_list.php");
exit;
