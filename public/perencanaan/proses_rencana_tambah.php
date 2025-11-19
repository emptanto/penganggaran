<?php
// File: proses_rencana_tambah.php (Versi Sederhana & Anti-Typo)

require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rencana_list.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil semua data dari form dengan aman
$kegiatan_id            = $_POST['kegiatan_id'] ?? null;
$nama_rencana_kegiatan  = trim($_POST['nama_rencana_kegiatan'] ?? null);
if (empty($nama_rencana_kegiatan)) {
    $nama_rencana_kegiatan = null; // Pastikan null jika kosong, untuk database
}
$rekening_ids           = $_POST['rekening_id'] ?? [];
$nama_rencanas          = $_POST['nama_rencana'] ?? [];
$jumlah_rencanas        = $_POST['jumlah_rencana'] ?? [];
$jumlah_kegiatans       = $_POST['jumlah_kegiatan'] ?? [];
$satuans                = $_POST['satuan'] ?? [];
$harga_satuans          = $_POST['harga_satuan'] ?? [];
$bulans                 = $_POST['bulan'] ?? [];

if (empty($kegiatan_id) || empty(trim($nama_rencanas[0]))) {
    $_SESSION['error_message'] = "Kegiatan dan minimal satu baris uraian rencana wajib diisi.";
    header("Location: rencana_tambah.php");
    exit;
}

$conn->begin_transaction();

try {
    // Query tetap sama dengan 11 placeholder (?)
    $sql = "INSERT INTO rencana 
                (kegiatan_id, rekening_id, nama_rencana, nama_rencana_kegiatan, 
                 jumlah_rencana, jumlah_kegiatan, satuan, harga_satuan, 
                 total_biaya, bulan, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Looping untuk setiap baris data
    foreach ($nama_rencanas as $index => $nama_rencana) {
        if (empty(trim($nama_rencana))) {
            continue;
        }
        
        $jumlah_rencana  = (int)$jumlah_rencanas[$index];
        $jumlah_kegiatan = (int)$jumlah_kegiatans[$index];
        $harga_satuan    = (int)$harga_satuans[$index];
        $total_biaya     = $jumlah_rencana * $jumlah_kegiatan * $harga_satuan;

        // =================================================================
        // PERUBAHAN UTAMA DI SINI
        // =================================================================
        
        // 1. Siapkan semua 11 variabel dalam sebuah array
        $params = [
            $kegiatan_id,
            $rekening_ids[$index],
            $nama_rencanas[$index],
            $nama_rencana_kegiatan, // Variabel tunggal, bukan dari $index
            $jumlah_rencana,
            $jumlah_kegiatans[$index],
            $satuans[$index],
            $harga_satuan,
            $total_biaya,
            $bulans[$index],
            $user_id
        ];

        // 2. Langsung eksekusi dengan array tersebut. Tidak perlu bind_param!
        if (!$stmt->execute($params)) {
            throw new Exception("Gagal eksekusi query pada baris " . ($index + 1) . ": " . $stmt->error);
        }
        // =================================================================
    }

    $conn->commit();
    $_SESSION['success_message'] = "Data rencana anggaran berhasil ditambahkan.";

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Terjadi kegagalan: " . $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}

header("Location: rencana_list.php");
exit;
?>