<?php
// kegiatan_list.php (Final dengan semua fitur)

session_start();
require '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';

// --- BAGIAN LOGIKA ---

$search = trim($_GET['search'] ?? '');
$sort_by = $_GET['sort_by'] ?? 'id';
$order = $_GET['order'] ?? 'DESC';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_param = $_GET['limit'] ?? 10;
$show_all = ($limit_param === 'all');

$allowed_columns = ['id', 'nama_kegiatan', 'program', 'sub_program', 'kode_kegiatan'];
$sort_by = in_array($sort_by, $allowed_columns) ? $sort_by : 'id';
$order = in_array(strtoupper($order), ['ASC', 'DESC']) ? strtoupper($order) : 'DESC';

$whereClause = "";
$params = [];
$types = "";
if (!empty($search)) {
    $whereClause = "WHERE program LIKE ? OR sub_program LIKE ? OR nama_kegiatan LIKE ? OR kode_kegiatan LIKE ?";
    $search_param = "%{$search}%";
    $params = [$search_param, $search_param, $search_param, $search_param];
    $types = "ssss";
}

$limit = $show_all ? 9999 : (int)$limit_param;
$offset = ($page - 1) * $limit;

$countQuery = "SELECT COUNT(*) as total FROM kegiatan $whereClause";
$stmtCount = $conn->prepare($countQuery);
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalData = $stmtCount->get_result()->fetch_assoc()['total'];
$totalPages = $show_all ? 1 : ceil($totalData / $limit);

$query = "SELECT * FROM kegiatan $whereClause ORDER BY $sort_by $order LIMIT ?, ?";
$stmt = $conn->prepare($query);
$current_params = $params;
$current_types = $types;
$current_params[] = $offset;
$current_params[] = $limit;
$current_types .= "ii";
$stmt->bind_param($current_types, ...$current_params);
$stmt->execute();
$kegiatanList = $stmt->get_result();

function sortLink($label, $field, $currentSort, $currentOrder) {
    $nextOrder = ($currentSort === $field && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
    $arrow = ($currentSort === $field) ? ($currentOrder === 'ASC' ? ' ▲' : ' ▼') : '';
    $queryParams = $_GET;
    $queryParams['sort_by'] = $field;
    $queryParams['order'] = $nextOrder;
    return "<a href=\"kegiatan_list.php?".http_build_query($queryParams)."\" class=\"text-decoration-none text-dark\">{$label}{$arrow}</a>";
}

// --- BAGIAN TAMPILAN (HTML) ---
include ROOT_PATH .  '/views/layouts/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Daftar Kegiatan</h2>
    <?php include ROOT_PATH .  '/views/layouts/flash_messages.php'; ?>

    <div class="accordion mb-4" id="accordionKegiatan">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <i class="fas fa-plus-circle me-2"></i> Tambah / Import Kegiatan
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionKegiatan">
                <div class="accordion-body">
                    <h5 class="card-title">Tambah Kegiatan Baru</h5>
                    <form action="kegiatan_tambah.php" method="POST" class="mb-5">
                        <div class="row g-3 mb-3">
                            <div class="col-md-4"><label class="form-label">Kode Kegiatan</label><input type="text" name="kode_kegiatan" class="form-control" required></div>
                            
                            <div class="col-md-8"><label class="form-label">Program</label><input type="text" name="program" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Sub Program</label><input type="text" name="sub_program" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Nama Kegiatan</label><input type="text" name="nama_kegiatan" class="form-control" required></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
                    </form>
                    <hr>
                    <h5 class="card-title mt-4">Import dari CSV</h5>
                    <form action="kegiatan_import.php" method="POST" enctype="multipart/form-data">
                        <div class="row gx-3 gy-2 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Pilih File CSV</label>
                                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                                <div class="form-text">Format: kode_kegiatan, program, sub_program, nama_kegiatan. <a href="<?= BASE_URL; ?>uploads/template_kegiatan.csv" download>Unduh Template</a></div>
                            </div>
                            <div class="col-md-4 d-flex align-self-center">
                                <button type="submit" class="btn btn-success w-100">Import CSV</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan program, sub program, nama, atau kode kegiatan..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-3">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-info flex-grow-1 me-2">Cari</button>
                        <a href="kegiatan_list.php" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="text-muted">
                    <?php if ($totalData > 0): ?>
                        Menampilkan <strong><?= $kegiatanList->num_rows ?></strong> dari <strong><?= $totalData ?></strong> data.
                    <?php else: ?>
                        Data tidak ditemukan.
                    <?php endif; ?>
                </div>
                
                <form method="GET" action="kegiatan_list.php" class="d-inline-block">
                    <?php foreach ($_GET as $key => $value): if ($key != 'limit' && $key != 'page'): ?>
                        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endif; endforeach; ?>
                    <div class="d-flex align-items-center">
                        <label for="limit" class="form-label me-2 mb-0"><small>Tampilkan:</small></label>
                        <select name="limit" id="limit" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                            <?php $current_limit = $_GET['limit'] ?? 10; ?>
                            <option value="10" <?= $current_limit == 10 ? 'selected' : '' ?>>10</option>
                            <option value="20" <?= $current_limit == 20 ? 'selected' : '' ?>>20</option>
                            <option value="50" <?= $current_limit == 50 ? 'selected' : '' ?>>50</option>
                            <option value="all" <?= $current_limit == 'all' ? 'selected' : '' ?>>Semua</option>
                        </select>
                    </div>
                </form>
            </div>

            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th><?= sortLink('Kode Kegiatan', 'kode_kegiatan', $sort_by, $order) ?></th>
                        <th><?= sortLink('Program', 'program', $sort_by, $order) ?></th>
                        <th><?= sortLink('Sub Program', 'sub_program', $sort_by, $order) ?></th>
                        <th><?= sortLink('Nama Kegiatan', 'nama_kegiatan', $sort_by, $order) ?></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($kegiatanList->num_rows > 0): ?>
                        <?php $no = $offset + 1; ?>
                        <?php while ($row = $kegiatanList->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['kode_kegiatan']) ?></td>
                                <td><?= htmlspecialchars($row['program']) ?></td>
                                <td><?= htmlspecialchars($row['sub_program']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                                <td class="text-center">
                                    <a href="kegiatan_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="kegiatan_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if (!$show_all && $totalPages > 1): ?>
                <nav><ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++):
                        $queryParams = $_GET; $queryParams['page'] = $i; ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($queryParams) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul></nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT_PATH .  '/views/layouts/footer.php'; ?>