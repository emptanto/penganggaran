<?php
// rencana_filter.php
?>
<form action="<?= htmlspecialchars($currentPage) ?>" method="GET" id="rencanaFilterForm">
    <?php
    // Pertahankan parameter GET lain (sort, order, limit, dll), kecuali filter_* dan page
    foreach ($_GET as $key => $value):
        if (strpos($key, 'filter_') === 0 || $key === 'page') continue;
    ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
    <?php endforeach; ?>
    <!-- Set page ke 1 setiap kali filter berubah -->
    <input type="hidden" name="page" value="1">

    <div class="row g-3">
        <!-- KEGIATAN -->
        <div class="col-md-3">
            <label for="filter_kegiatan" class="form-label">Kegiatan</label>
            <select name="filter_kegiatan" id="filter_kegiatan"
                    class="form-select select2-basic"
                    onchange="this.form.submit()">
                <option value="">Semua Kegiatan</option>
                <?php if ($kegiatanList && $kegiatanList->num_rows): ?>
                    <?php mysqli_data_seek($kegiatanList, 0); while ($k = $kegiatanList->fetch_assoc()): ?>
                        <option value="<?= (int)$k['id'] ?>" <?= ($filter_kegiatan == $k['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kegiatan']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- REKENING -->
        <div class="col-md-3">
            <label for="filter_rekening" class="form-label">Rekening</label>
            <select name="filter_rekening" id="filter_rekening"
                    class="form-select select2-basic"
                    onchange="this.form.submit()">
                <option value="">Semua Rekening</option>
                <?php if ($rekeningList && $rekeningList->num_rows): ?>
                    <?php mysqli_data_seek($rekeningList, 0); while ($r = $rekeningList->fetch_assoc()): ?>
                        <option value="<?= (int)$r['id'] ?>" <?= ($filter_rekening == $r['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['nama_rekening']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- BULAN -->
        <div class="col-md-3">
            <label for="filter_bulan" class="form-label">Bulan</label>
            <select name="filter_bulan" id="filter_bulan"
                    class="form-select select2-basic"
                    onchange="this.form.submit()">
                <option value="">Semua Bulan</option>
                <?php if ($bulanList && $bulanList->num_rows): ?>
                    <?php mysqli_data_seek($bulanList, 0); while ($b = $bulanList->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($b['bulan']) ?>" <?= ($filter_bulan == $b['bulan']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['bulan']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- URAIAN (INPUT TEKS) -->
        <div class="col-md-3">
            <label for="filter_uraian" class="form-label">Cari Uraian</label>
            <input type="text"
                   class="form-control"
                   name="filter_uraian"
                   id="filter_uraian"
                   placeholder="Ketik kata kunci uraian..."
                   value="<?= htmlspecialchars($filter_uraian ?? '') ?>">
            
        </div>

        <!-- USER (hanya untuk laporan/superadmin) -->
        <?php if ($isReportPage || $isSuperadmin): ?>
        <div class="col-md-3 mt-3">
            <label for="filter_user" class="form-label">User</label>
            <select name="filter_user" id="filter_user"
                    class="form-select select2-basic"
                    onchange="this.form.submit()">
                <option value="">Semua User</option>
                <?php if ($userList && $userList->num_rows): ?>
                    <?php mysqli_data_seek($userList, 0); while ($u = $userList->fetch_assoc()): ?>
                        <option value="<?= (int)$u['id'] ?>" <?= ($filter_user == $u['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['username']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>

    <hr>
    <div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check"></i> Terapkan
        </button>
        <a href="<?= htmlspecialchars($currentPage) ?>" class="btn btn-secondary">
            <i class="fas fa-sync-alt"></i> Reset
        </a>
    </div>
</form>

<script>
// Auto-filter untuk input "Cari Uraian" dengan debounce
(function() {
    var input = document.getElementById('filter_uraian');
    if (!input) return;

    var timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            // submit form terdekat (form filter ini)
            if (input.form) {
                input.form.submit();
            }
        }, 500); // jeda 500ms setelah berhenti mengetik
    });
})();
</script>
