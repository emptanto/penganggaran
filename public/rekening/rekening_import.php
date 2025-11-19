<?php
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== false) {
        // Lewati baris header (jika ada)
        fgetcsv($handle, 1000, ',');

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $kode_rekening = trim($data[0]);
            $nama_belanja = trim($data[1]);
            $nama_rekening = trim($data[2]);

            if (!empty($kode_rekening) && !empty($nama_belanja) && !empty($nama_rekening)) {
                // Hindari duplikasi
                $cek = $conn->prepare("SELECT id FROM rekening WHERE kode_rekening = ?");
                $cek->bind_param("s", $kode_rekening);
                $cek->execute();
                $cek->store_result();

                if ($cek->num_rows == 0) {
                    $stmt = $conn->prepare("INSERT INTO rekening (kode_rekening, nama_belanja, nama_rekening) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $kode_rekening, $nama_belanja, $nama_rekening);
                    $stmt->execute();
                }

                $cek->close();
            }
        }

        fclose($handle);
    }
}

header("Location: rekening_list.php");
exit;
