<?php
// public/pages/kegiatan_import.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../config/db.php';
require_once ROOT_PATH . '/controllers/KegiatanController.php';

if (!isset($_SESSION['user_id'])) {
  $_SESSION['error'] = 'Akses ditolak. Silakan login terlebih dahulu.';
  header('Location: ' . url('index.php?p=kegiatan_form'));
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['error'] = 'Metode tidak valid.';
  header('Location: ' . url('index.php?p=kegiatan_form'));
  exit;
}

// Validasi file upload
if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
  $_SESSION['error'] = 'Gagal mengunggah file. Pastikan Anda memilih file CSV.';
  header('Location: ' . url('index.php?p=kegiatan_form'));
  exit;
}

$tmpPath = $_FILES['csv_file']['tmp_name'];
$ext     = strtolower(pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION));
if ($ext !== 'csv' || !is_uploaded_file($tmpPath)) {
  $_SESSION['error'] = 'File harus berformat .csv yang valid.';
  header('Location: ' . url('index.php?p=kegiatan_form'));
  exit;
}

try {
  $controller  = new KegiatanController($conn);
  $imported    = $controller->importCSV($tmpPath, (int)$_SESSION['user_id']);

  if ($imported === false) {
    $_SESSION['error'] = 'Terjadi kesalahan saat memproses CSV.';
  } elseif ($imported === 0) {
    $_SESSION['info']  = 'Tidak ada baris valid yang diimpor.';
  } else {
    $_SESSION['success'] = "$imported data kegiatan berhasil diimpor.";
  }
} catch (Throwable $e) {
  $_SESSION['error'] = 'Gagal import: ' . $e->getMessage();
}

header("Location: kegiatan_list.php");
exit;
