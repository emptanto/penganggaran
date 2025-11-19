<?php
// File: rkas.php (Halaman Laporan)
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
include_once ROOT_PATH .  '/views/layouts/header.php';
require_once ROOT_PATH .  '/controllers/RencanaController.php';


// --- Konfigurasi Halaman ---
$pageTitle = 'Laporan Rencana Kegiatan dan Anggaran Sekolah (RKAS)';
$show_actions = (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin');
$isReportPage = true;  // Memberitahu logika pusat untuk menampilkan semua data
$currentPage = 'rkas.php';
$filter_uraian = $_GET['filter_uraian'] ?? '';


// Panggil file logika pusat
require '_rencana_logic.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><?= $pageTitle ?></h2>
        </div>

    <div class="card mb-4">
        <div class="card-body">
            <?php include 'rencana_filter.php'; ?>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php include 'rencana_view.php'; ?>
        </div>
    </div>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>