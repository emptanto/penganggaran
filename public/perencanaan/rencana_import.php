<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $kegiatan_id     = (int) $row[0];
            $rekening_id     = (int) $row[1];
            $jumlah_rencana  = (int) $row[2];
            $jumlah_kegiatan = (int) $row[3];
            $satuan          = trim($row[4]);
            $harga_satuan    = (int) $row[5];
            $total_biaya     = $jumlah_rencana * $jumlah_kegiatan * $harga_satuan;
            $bulan           = trim(ucfirst(strtolower($row[7])));
            $user_id         = $_SESSION['user_id'];

            // Validasi bulan agar sesuai ENUM
            if (!in_array($bulan, $valid_bulan)) {
                continue; // lewati baris ini jika bulan tidak valid
            }

            $stmt = $conn->prepare("INSERT INTO rencana (
                kegiatan_id, rekening_id, jumlah_rencana, jumlah_kegiatan,
                satuan, harga_satuan, total_biaya, bulan, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiisissi", $rekening_id, $id_rekening, $jumlah_rencana, $jumlah_kegiatan, $satuan, $harga_satuan, $total_biaya, $bulan, $user_id);
            $stmt->execute();
        fclose($handle);
    }

    header("Location: rencana_list.php?import=success");
    exit;
}
?>
