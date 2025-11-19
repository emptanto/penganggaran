<?php
session_start();
require 'config/db.php';
require_once 'config/auth_check.php';

// --- BAGIAN LOGIKA & PENGAMBILAN DATA ---

$isSuperadmin = ($_SESSION['role'] === 'superadmin');
$userId = $_SESSION['user_id'];

// Persiapan Prepared Statement untuk filter user
$whereClause = "";
$params = [];
$types = "";
if (!$isSuperadmin) {
    // FIX: Filter berdasarkan user_id langsung di tabel 'rencana' (menggunakan alias 'r')
    $whereClause = " AND r.user_id = ?";
    $params[] = $userId;
    $types = "i";
}

// Helper function untuk eksekusi query dengan aman
function fetchData($conn, $sql, $params = [], $types = "") {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error . " | Query: " . $sql);
    }
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// 1. Data untuk Stat Cards
// FIX: Query disederhanakan, JOIN tidak diperlukan untuk filter ini
$totalAnggaranSql = "SELECT SUM(r.total_biaya) as total FROM rencana r WHERE 1=1 $whereClause";
$totalAnggaran = fetchData($conn, $totalAnggaranSql, $params, $types)->fetch_assoc()['total'] ?? 0;

// FIX: Query disederhanakan, JOIN tidak diperlukan untuk filter ini
$totalKegiatanSql = "SELECT COUNT(DISTINCT r.kegiatan_id) as total FROM rencana r WHERE 1=1 $whereClause";
$totalKegiatan = fetchData($conn, $totalKegiatanSql, $params, $types)->fetch_assoc()['total'] ?? 0;

$bulanIni = date('F');
$namaBulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$bulanIni = $namaBulanIndonesia[date('n') - 1];

// FIX: Query disederhanakan, JOIN tidak diperlukan untuk filter ini
$anggaranBulanIniSql = "SELECT SUM(r.total_biaya) as total FROM rencana r WHERE r.bulan = ? $whereClause";
$anggaranBulanIniParams = array_merge([$bulanIni], $params);
$anggaranBulanIniTypes = "s" . $types;
$anggaranBulanIni = fetchData($conn, $anggaranBulanIniSql, $anggaranBulanIniParams, $anggaranBulanIniTypes)->fetch_assoc()['total'] ?? 0;

$belanjaModal = 0;
$belanjaOperasional = 0;

// FIX: JOIN ke kegiatan & program dihapus karena tidak perlu untuk filter
$sqlJenisBelanja = "
    SELECT
        CASE
            WHEN LOWER(rek.nama_rekening) LIKE '%modal%' OR LOWER(rek.nama_belanja) LIKE '%modal%' THEN 'modal'
            ELSE 'operasional'
        END AS jenis_belanja,
        SUM(r.total_biaya) as total
    FROM rencana r
    JOIN rekening rek ON r.rekening_id = rek.id
    WHERE 1=1 $whereClause
    GROUP BY jenis_belanja
";
$resJenisBelanja = fetchData($conn, $sqlJenisBelanja, $params, $types);
while ($row = $resJenisBelanja->fetch_assoc()) {
    if ($row['jenis_belanja'] === 'modal') {
        $belanjaModal = $row['total'];
    } else {
        $belanjaOperasional = $row['total'];
    }
}

// 2. Data untuk Chart Anggaran per Bulan
$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$dataPerBulan = array_fill_keys($bulanList, 0);
// FIX: Query disederhanakan, JOIN tidak diperlukan
$sqlBulan = "SELECT r.bulan, SUM(r.total_biaya) AS total FROM rencana r WHERE 1=1 $whereClause GROUP BY r.bulan";
$resBulan = fetchData($conn, $sqlBulan, $params, $types);
while ($row = $resBulan->fetch_assoc()) {
    $dataPerBulan[$row['bulan']] = (float)$row['total'];
}

// 3. Data untuk Top 10 Kegiatan & Rekening
// FIX: JOIN ke program dihapus. JOIN ke kegiatan dipertahankan karena butuh 'nama_kegiatan'.
$sqlKegiatan = "SELECT k.nama_kegiatan, SUM(r.total_biaya) AS total FROM rencana r JOIN kegiatan k ON r.kegiatan_id = k.id WHERE 1=1 $whereClause GROUP BY k.nama_kegiatan ORDER BY total DESC LIMIT 10";
$dataKegiatan = fetchData($conn, $sqlKegiatan, $params, $types);

// FIX: JOIN ke kegiatan & program dihapus. JOIN ke rekening dipertahankan karena butuh 'nama_rekening'.
$sqlRekening = "SELECT rek.nama_rekening, SUM(r.total_biaya) AS total FROM rencana r JOIN rekening rek ON r.rekening_id = rek.id WHERE 1=1 $whereClause GROUP BY rek.nama_rekening ORDER BY total DESC LIMIT 10";
$dataRekening = fetchData($conn, $sqlRekening, $params, $types);

// --- BAGIAN TAMPILAN (HTML) ---
include 'views/layouts/header.php';
?>
<style>
    .stat-card { transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-5px); }
</style>

<div class="container mt-4 mb-5">
    <h2 class="mb-4">Dashboard Anggaran</h2>

    <div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm stat-card h-100">
            <div class="card-body">
                <h5 class="card-title text-muted">Total Anggaran</h5>
                <p class="card-text fs-4 fw-bold">Rp <?= number_format($totalAnggaran, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm stat-card h-100">
            <div class="card-body">
                <h5 class="card-title text-muted">Belanja Operasional</h5>
                <p class="card-text fs-4 fw-bold text-primary">Rp <?= number_format($belanjaOperasional, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm stat-card h-100">
            <div class="card-body">
                <h5 class="card-title text-muted">Belanja Modal</h5>
                <p class="card-text fs-4 fw-bold text-success">Rp <?= number_format($belanjaModal, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm stat-card h-100">
            <div class="card-body">
                <h5 class="card-title text-muted">Jumlah Kegiatan Terencana</h5>
                <p class="card-text fs-4 fw-bold"><?= number_format($totalKegiatan) ?> Kegiatan</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm stat-card h-100">
            <div class="card-body">
                <h5 class="card-title text-muted">Anggaran Bulan Ini (<?= $bulanIni ?>)</h5>
                <p class="card-text fs-4 fw-bold">Rp <?= number_format($anggaranBulanIni, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Anggaran per Bulan</h5>
                    <canvas id="chartBulan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Top 10 Kegiatan berdasarkan Anggaran</h5>
                    <canvas id="chartKegiatan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Top 10 Rekening berdasarkan Anggaran</h5>
                    <canvas id="chartRekening"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Fungsi pembantu untuk memformat angka menjadi format Rupiah
const formatCurrency = (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);

// Palet warna yang lebih harmonis
const colorPalette = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#f8f9fc', '#dddfeb', '#4e73df'];

// Fungsi untuk mengambil data dari PHP result set
function processData(phpResult) {
    const labels = [];
    const data = [];
    phpResult.forEach(item => {
        labels.push(item.nama_kegiatan || item.nama_rekening);
        data.push(item.total);
    });
    return { labels, data };
}

// Data dari PHP
const dataBulan = <?= json_encode(array_values($dataPerBulan)) ?>;
const labelBulan = <?= json_encode(array_keys($dataPerBulan)) ?>;
const dataKegiatan = processData(<?= json_encode($dataKegiatan->fetch_all(MYSQLI_ASSOC)) ?>);
const dataRekening = processData(<?= json_encode($dataRekening->fetch_all(MYSQLI_ASSOC)) ?>);

// Chart 1: Anggaran per Bulan (Vertical Bar)
new Chart(document.getElementById('chartBulan'), {
    type: 'bar',
    data: {
        labels: labelBulan,
        datasets: [{
            label: 'Total Anggaran',
            data: dataBulan,
            backgroundColor: '#4e73df',
            borderColor: '#4e73df',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => formatCurrency(ctx.raw) } } },
        scales: { y: { ticks: { callback: (val) => formatCurrency(val) } } }
    }
});

// Chart 2: Top Kegiatan (Doughnut)
new Chart(document.getElementById('chartKegiatan'), {
    type: 'doughnut',
    data: {
        labels: dataKegiatan.labels,
        datasets: [{ data: dataKegiatan.data, backgroundColor: colorPalette }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' }, tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${formatCurrency(ctx.raw)}` } } }
    
    }
});

// Chart 3: Top Rekening (Doughnut)
new Chart(document.getElementById('chartRekening'), {
    type: 'doughnut',
    data: {
        labels: dataRekening.labels,
        datasets: [{ data: dataRekening.data, backgroundColor: colorPalette }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' }, tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${formatCurrency(ctx.raw)}` } } }
    }
});
</script>

<?php include 'views/layouts/footer.php'; ?>

