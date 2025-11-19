<?php
// File: rencana_list.php (Halaman Manajemen)
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
require_once ROOT_PATH .  '/views/layouts/header.php';
require_once ROOT_PATH .  '/controllers/RencanaController.php';


// --- Konfigurasi Halaman ---
$pageTitle = 'Rencana Penganggaran';
$show_actions = true;  // Tombol Edit/Delete akan ditampilkan
$isReportPage = false; // Memberitahu logika pusat untuk menerapkan hak akses user
$currentPage = 'rencana_list.php';
$filter_uraian = $_GET['filter_uraian'] ?? '';


// Panggil file logika pusat
require '_rencana_logic.php';
?>

<div class="container mt-4">
    <?php include ROOT_PATH . '/views/layouts/flash_messages.php'; ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><?= $pageTitle ?></h2>
        <a href="rencana_tambah.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Rencana Baru</a>
    </div>

    <div class="accordion mb-4" id="accordionFilter">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFilter">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false">
                    <i class="fas fa-filter me-2"></i> Tampilkan Filter Data
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse" data-bs-parent="#accordionFilter">
                <div class="accordion-body">
                    <?php include 'rencana_filter.php'; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php include 'rencana_view.php'; ?>
        </div>
    </div>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>