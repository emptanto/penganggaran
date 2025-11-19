<?php
// File: _rencana_logic.php (Logika Pusat untuk Rencana & RKAS)
// Perubahan: sumber dropdown filter diambil dari DISTINCT rencana (bukan semua master)
// dan tetap menggunakan RencanaController->getFiltered($filters).
// Tambahan: filter_uraian (pencarian teks pada kolom uraian).

// --- Inisialisasi & Persiapan ---
$rencanaController = new RencanaController($conn);

// Role & context
$isSuperadmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin');
$userId       = $_SESSION['user_id'] ?? null;

// Simpan previous URL
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'] ?? '';

// --- Pengambilan Parameter URL ---
$filter_kegiatan = $_GET['filter_kegiatan'] ?? '';
$filter_rekening = $_GET['filter_rekening'] ?? '';
$filter_bulan    = $_GET['filter_bulan'] ?? '';
$filter_user     = $_GET['filter_user'] ?? '';

// FILTER BARU: URAIAN (TEXT SEARCH)
$filter_uraian   = trim($_GET['filter_uraian'] ?? '');

$sort        = $_GET['sort']  ?? 'rencana.id';
$order       = $_GET['order'] ?? 'desc';
$limit_param = $_GET['limit'] ?? 15;
$page        = max(1, (int)($_GET['page'] ?? 1));
$currentPage = $currentPage ?? 'rencana_list.php'; // fallback

// --- Normalisasi limit ---
$show_all = ($limit_param === 'all');
if ($show_all) {
    $limit  = 9999; // tampilkan semua
    $offset = 0;
} else {
    $limit  = max(1, (int)$limit_param);
    $offset = ($page - 1) * $limit;
}

// --- Whitelist sorting ---
// key = nama param sort di UI, value = kolom SQL valid
$validSort = [
    'nama_kegiatan'  => 'kegiatan.nama_kegiatan',
    'nama_rekening'  => 'rekening.nama_rekening',
    'nama_rencana'   => 'rencana.nama_rencana',
    'harga_satuan'   => 'rencana.harga_satuan',
    'bulan'          => 'rencana.bulan',
    'username'       => 'users.username',
    // default fallback
    'rencana.id'     => 'rencana.id',
];

// Tetapkan kolom sort yang valid
$sortBy = $validSort[$sort] ?? 'rencana.id';
// Urutan ASC/DESC aman
$order  = (strtolower($order) === 'asc') ? 'asc' : 'desc';

// --- Menyiapkan filters untuk Controller ---
$filters = [
    // Jika ini halaman laporan ($isReportPage true), anggap superadmin (lihat rkas.php)
    'isSuperadmin'    => (!empty($isReportPage) ? true : $isSuperadmin),
    'userId'          => $userId,

    // filter id (kegiatan_id, rekening_id, user_id) & bulan (string)
    'filter_kegiatan' => $filter_kegiatan,
    'filter_rekening' => $filter_rekening,
    'filter_bulan'    => $filter_bulan,
    'filter_user'     => $filter_user,

    // FILTER BARU: URAIAN (string / kata kunci)
    'filter_uraian'   => $filter_uraian,

    'sortBy'          => $sortBy,
    'order'           => $order,
];

// Paging opsional (controller kita memang mendukung limit/offset opsional)
if (!$show_all) {
    $filters['limit']  = $limit;
    $filters['offset'] = $offset;
}

// --- Ambil Data dari Controller ---
$filteredResult = $rencanaController->getFiltered($filters);
// Controller mengembalikan:
// - 'data'         => mysqli_result
// - 'total_rows'   => int
// - 'grand_total'  => int
$result        = $filteredResult['data'];
$totalData     = (int)($filteredResult['total_rows'] ?? 0);
$grandTotalAll = (int)($filteredResult['grand_total'] ?? 0);
$totalPages    = $show_all ? 1 : max(1, (int)ceil($totalData / $limit));

// ======================================================================
// Sumber opsi FILTER: diambil dari DISTINCT rencana yang ada (bukan semua master)
// ======================================================================

// Jika bukan halaman laporan & bukan superadmin, batasi opsi pada rencana milik user login.
$whereUser  = '';
$bindTypes  = '';
$bindParams = [];

if (empty($isReportPage) && !$isSuperadmin && $userId) {
    $whereUser   = 'WHERE r.user_id = ?';
    $bindTypes   = 'i';
    $bindParams  = [$userId];
}

// KEGIATAN (distinct yang pernah dipakai di rencana)
$sqlKegiatan = "
    SELECT DISTINCT k.id, k.nama_kegiatan
    FROM rencana r
    JOIN kegiatan k ON k.id = r.kegiatan_id
    $whereUser
    ORDER BY k.nama_kegiatan ASC
";
$kegiatanStmt = $conn->prepare($sqlKegiatan);
if ($whereUser) { $kegiatanStmt->bind_param($bindTypes, ...$bindParams); }
$kegiatanStmt->execute();
$kegiatanList = $kegiatanStmt->get_result();

// REKENING (distinct yang pernah dipakai di rencana)
$sqlRekening = "
    SELECT DISTINCT rk.id, rk.nama_rekening
    FROM rencana r
    JOIN rekening rk ON rk.id = r.rekening_id
    $whereUser
    ORDER BY rk.nama_rekening ASC
";
$rekeningStmt = $conn->prepare($sqlRekening);
if ($whereUser) { $rekeningStmt->bind_param($bindTypes, ...$bindParams); }
$rekeningStmt->execute();
$rekeningList = $rekeningStmt->get_result();

// BULAN (distinct dari rencana) — urut kronologis pakai FIELD
$sqlBulan = "
    SELECT DISTINCT r.bulan
    FROM rencana r
    $whereUser
    ORDER BY FIELD(r.bulan,
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    )
";
$bulanStmt = $conn->prepare($sqlBulan);
if ($whereUser) { $bulanStmt->bind_param($bindTypes, ...$bindParams); }
$bulanStmt->execute();
$bulanList = $bulanStmt->get_result();

// USER (distinct dari rencana) — hanya untuk halaman laporan / superadmin
if (!empty($isReportPage) || $isSuperadmin) {
    $sqlUser = "
        SELECT DISTINCT u.id, u.username
        FROM rencana r
        JOIN users u ON u.id = r.user_id
        ORDER BY u.username ASC
    ";
    $userList = $conn->query($sqlUser);
} else {
    $userList = null;
}

// --- Helper untuk link sort pada header tabel ---
function sortLink($label, $field, $currentSort, $currentOrder, $currentPage) {
    $nextOrder = ($currentSort === $field && $currentOrder === 'asc') ? 'desc' : 'asc';
    $arrow     = ($currentSort === $field) ? ($currentOrder === 'asc' ? ' ▲' : ' ▼') : '';
    $query     = $_GET;
    $query['sort']  = $field;
    $query['order'] = $nextOrder;
    $href = htmlspecialchars($currentPage) . '?' . http_build_query($query);
    return '<a class="text-decoration-none text-dark" href="'.$href.'">'.htmlspecialchars($label).$arrow.'</a>';
}
