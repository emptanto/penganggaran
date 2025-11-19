<?php
// rencana_view.php (Versi Sempurna)

// Inisialisasi variabel dari scope induk (rencana_list.php atau rkas.php)
$show_actions = $show_actions ?? false;
$isSuperadmin = $isSuperadmin ?? false;
$isReportPage = $isReportPage ?? false;
$offset = $offset ?? 0;
$page = $page ?? 1;
$currentPage = $currentPage ?? 'rencana_list.php';

// --- Logika untuk colspan dinamis ---
// Hitung jumlah kolom header secara dinamis untuk colspan yang akurat
$colspan_before_total = 6; // Kolom sebelum 'Total Biaya': No, Kegiatan, Rekening, Uraian, Volume, Harga
$colspan_after_total = 1;  // Kolom setelah 'Total Biaya': Bulan
if ($isReportPage || $isSuperadmin) $colspan_after_total++; // Tambah kolom Pengaju
if ($show_actions) $colspan_after_total++;
$totalColumns = $colspan_before_total + 1 + $colspan_after_total; // +1 untuk kolom Total Biaya itu sendiri

?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="me-3 mb-2 mb-md-0">
        <h5 class="card-title mb-1">Tabel Rencana Anggaran</h5>
        <?php if (isset($totalData) && $totalData > 0): ?>
            <small class="text-muted">
                Menampilkan <strong><?= $result->num_rows ?></strong> dari <strong><?= $totalData ?></strong> data.
                <?php if (isset($grandTotalAll) && $grandTotalAll > 0): ?>
                    <span class="mx-2">|</span>
                    <strong>Grand Total:</strong>
                    <span class="text-success fw-bold">Rp <?= number_format($grandTotalAll, 0, ',', '.') ?></span>
                <?php endif; ?>
            </small>
        <?php endif; ?>
    </div>

    <div class="d-flex align-items-center">
        <?php
$export_params = $_GET;
// Jika ini adalah halaman laporan, tambahkan penanda 'report=1'
if ($isReportPage) {
    $export_params['report'] = '1';
}
?>
        <a href="rencana_export.php?<?= http_build_query($export_params) ?>" class="btn btn-sm btn-success">
            <i class="fas fa-file-excel"></i> Export
        </a>

        <form method="GET" action="<?= htmlspecialchars($currentPage) ?>" class="d-inline-block ms-2">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if ($key != 'limit' && $key != 'page'): ?>
                    <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="d-flex align-items-center">
                <label for="limit" class="form-label me-2 mb-0"><small>Tampilkan:</small></label>
                <select name="limit" id="limit" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                    <?php $current_limit = $_GET['limit'] ?? 15; ?>
                    <option value="10" <?= ($current_limit == 10) ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($current_limit == 25) ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($current_limit == 50) ? 'selected' : '' ?>>50</option>
                    <option value="all" <?= ($current_limit == 'all') ? 'selected' : '' ?>>Semua</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-light text-center align-middle">
            <tr>
                <th>No</th>
                <th><?= sortLink('Kegiatan', 'nama_kegiatan', $sort, $order, $currentPage) ?></th>
                <th><?= sortLink('Rekening', 'nama_rekening', $sort, $order, $currentPage) ?></th>
                <th><?= sortLink('Uraian', 'nama_rencana', $sort, $order, $currentPage) ?></th>
                <th><?= sortLink('Harga Satuan', 'harga_satuan', $sort, $order, $currentPage) ?></th>
                <th>Rincian Volume</th>
                <th>Total Biaya</th>
                <th><?= sortLink('Bulan', 'bulan', $sort, $order, $currentPage) ?></th>
                <?php if ($isReportPage || $isSuperadmin): ?>
                    <th><?= sortLink('Pengaju', 'username', $sort, $order, $currentPage) ?></th>
                <?php endif; ?>
                <?php if ($show_actions): ?>
                    <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php $no = $offset + 1; $pageTotal = 0; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_rekening']) ?></td> 
                        <!-- <td><small><?= htmlspecialchars($row['kode_rekening'] . ' - ' . $row['nama_rekening']) ?></small></td> jika ingin menampilkan kode dan nama -->
                        <td>
                            <?php
                            $uraian_lengkap = $row['nama_rencana'];
                            if (!empty($row['nama_rencana_kegiatan'])) {
                                $uraian_lengkap .= ' (' . htmlspecialchars($row['nama_rencana_kegiatan']) . ')';
                            }
                            echo htmlspecialchars($uraian_lengkap);
                            ?>
                        </td>
                        <td class="text-end"><?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="text-center text-nowrap">
                            <?php
                            $total_volume = $row['jumlah_rencana'] * $row['jumlah_kegiatan'];
                            echo $row['jumlah_rencana'] . ' x ' . $row['jumlah_kegiatan'] . ' = <strong>' . $total_volume . '</strong> ' . htmlspecialchars($row['satuan']);
                            ?>
                        </td>
                        <td class="text-end fw-bold"><?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['bulan']) ?></td>
                        <?php if ($isReportPage || $isSuperadmin): ?>
                            <td class="text-center"><?= htmlspecialchars($row['username']) ?></td>
                        <?php endif; ?>
                        <?php if ($show_actions): ?>
                            <td class="text-center text-nowrap">
                                <a href="rencana_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit Rencana"><i class="fas fa-pencil-alt"></i></a>
                                <a href="rencana_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus rencana ini?')" title="Hapus Rencana"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php $pageTotal += $row['total_biaya']; ?>
                <?php endwhile; ?>
                
                <tr class="table-light">
                    <td colspan="<?= $colspan_before_total ?>" class="text-end fw-bold">Total Halaman Ini:</td>
                    <td class="text-end fw-bold"><?= number_format($pageTotal, 0, ',', '.') ?></td>
                    <td colspan="<?= $colspan_after_total ?>"></td>
                </tr>

            <?php else: ?>
                <tr><td colspan="<?= $totalColumns ?>" class="text-center py-4">Data tidak ditemukan. Silakan sesuaikan filter Anda.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php
    // Normalisasi nilai halaman
    $page = isset($page) ? (int)$page : 1;
    $page = max(1, min($page, (int)$totalPages));

    $range = 2; // jumlah halaman di kiri & kanan halaman aktif

    // Helper untuk build URL dengan query yang sudah ada
    $buildUrl = function ($pageNumber) use ($currentPage) {
        $params = $_GET;
        $params['page'] = $pageNumber;
        return htmlspecialchars($currentPage) . '?' . http_build_query($params);
    };
    ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center flex-wrap mt-3">

            <!-- Tombol Previous -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($page <= 1) ? '#' : $buildUrl($page - 1) ?>" tabindex="-1">
                    &laquo;
                </a>
            </li>

            <?php
            // Jika total halaman sedikit, tampilkan semua
            if ($totalPages <= (2 * $range + 5)) {
                for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $buildUrl($i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor;
            } else {
                // Halaman pertama
                ?>
                <li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $buildUrl(1) ?>">1</a>
                </li>
                <?php

                $start = max(2, $page - $range);
                $end   = min($totalPages - 1, $page + $range);

                // Ellipsis setelah halaman pertama
                if ($start > 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif;

                // Halaman di sekitar halaman aktif
                for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $buildUrl($i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor;

                // Ellipsis sebelum halaman terakhir
                if ($end < $totalPages - 1): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>

                <!-- Halaman terakhir -->
                <li class="page-item <?= ($page == $totalPages) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $buildUrl($totalPages) ?>"><?= $totalPages ?></a>
                </li>
            <?php } ?>

            <!-- Tombol Next -->
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($page >= $totalPages) ? '#' : $buildUrl($page + 1) ?>">
                    &raquo;
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>
