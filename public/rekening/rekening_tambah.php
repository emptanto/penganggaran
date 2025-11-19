<?php
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';

// Proses jika form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_rekening = trim($_POST['kode_rekening']);
    $nama_belanja = trim($_POST['nama_belanja']);
    $nama_rekening = trim($_POST['nama_rekening']);

    // Validasi sederhana
    if (!empty($kode_rekening) && !empty($nama_rekening)) {
        // Hindari SQL injection
        $kode_rekening = $conn->real_escape_string($kode_rekening);
        $nama_belanja = $conn->real_escape_string($nama_belanja);
        $nama_rekening = $conn->real_escape_string($nama_rekening);

        // Query simpan
        $sql = "INSERT INTO rekening (kode_rekening, nama_belanja, nama_rekening) VALUES ('$kode_rekening', '$nama_belanja', '$nama_rekening')";

        if ($conn->query($sql)) {
            // Redirect kembali ke halaman rencana list
            header("Location: rekening_list.php?status=sukses");
            $_SESSION['success_message'] = "Data rekening baru berhasil ditambahkan.";
            exit;
        } else {
            //echo "Gagal menambahkan data: " . $conn->error;
            $_SESSION['error_message'] = "Gagal menambahkan data rekening: " . $conn->error;
        }
    } else {
        echo "Kode dan Nama Rekening wajib diisi.";
    }
} else {
    // Redirect jika bukan method POST
    header("Location: rekening_list.php");
    exit;
}
?>
