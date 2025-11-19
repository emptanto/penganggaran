<?php
session_start();
// Menggunakan konstanta ROOT_PATH untuk path yang konsisten
require_once __DIR__ . '/../../config/db.php';
require_once ROOT_PATH . '/config/auth_check.php';

// Ambil data kegiatan untuk dropdown utama
$kegiatanList = $conn->query("SELECT id, nama_kegiatan, kode_kegiatan FROM kegiatan ORDER BY kode_kegiatan");

// Ambil data rekening sekali saja untuk digunakan di dalam template baris baru
$rekeningList = $conn->query("SELECT id, kode_rekening, nama_rekening FROM rekening ORDER BY kode_rekening");
$rekeningOptions = [];
while ($row = $rekeningList->fetch_assoc()) {
    $rekeningOptions[] = $row;
}

// Memanggil file header
include_once ROOT_PATH . '/views/layouts/header.php';
?>

<!-- === STYLESHEETS === -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  .table-rencana{table-layout:fixed;width:100%}
  .select2-container .select2-selection--single .select2-selection__rendered{
    display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
  }
</style>
<!-- === END STYLESHEETS === -->

<!-- === KONTEN UTAMA HALAMAN === -->
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <h2 class="card-title mb-0">Formulir Tambah Rencana Anggaran</h2>
    </div>
    <div class="card-body p-4">
      <form action="proses_rencana_tambah.php" method="POST" id="form-rencana">
        <div class="row mb-4">
          <div class="col-md-6">
            <label for="kegiatan_id" class="form-label fs-5">Pilih Kegiatan Utama (Program)</label>
            <select id="kegiatan_id" name="kegiatan_id" class="form-select form-select-lg js-select2" data-placeholder="-- Pilih Salah Satu Kegiatan --" required>
              <option></option>
              <?php while ($kegiatan = $kegiatanList->fetch_assoc()) : ?>
                <option value="<?= $kegiatan['id'] ?>"><?= htmlspecialchars($kegiatan['nama_kegiatan']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="nama_rencana_kegiatan" class="form-label fs-5">Nama Rencana Kegiatan</label>
            <input type="text" id="nama_rencana_kegiatan" name="nama_rencana_kegiatan" class="form-control form-control-lg" placeholder="Contoh: Lomba LKS, Workshop, dll." required>
          </div>
        </div>

        <hr class="my-4">
        <h4 class="mb-3">Detail Rencana Belanja</h4>

        <div class="table-responsive">
          <table class="table table-bordered align-middle table-rencana">
            <thead class="table-light text-center">
              <tr>
                <th style="width:25%;">Pilih Rekening</th>
                <th>Uraian Rencana</th>
                <th style="width:8%;">Jml. Rencana</th>
                <th style="width:8%;">Jml. Kegiatan</th>
                <th style="width:10%;">Satuan</th>
                <th style="width:12%;">Harga Satuan</th>
                <th style="width:12%;">Bulan</th>
                <th style="width:5%;">Aksi</th>
              </tr>
            </thead>
            <tbody id="rencana-container"></tbody>
          </table>
        </div>

        <button type="button" id="tambah-baris" class="btn btn-primary mt-2">
          <i class="fas fa-plus me-1"></i> Tambah Baris
        </button>

        <hr class="my-4">
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save me-2"></i>Simpan Rencana</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- === END KONTEN UTAMA HALAMAN === -->

<!-- === TEMPLATE UNTUK BARIS BARU (DISEMBUNYIKAN) === -->
<template id="template-row">
  <tr>
    <td>
      <select name="rekening_id[]" class="form-select form-select-lg js-select2" data-placeholder="Pilih Rekening" required>
        <option></option>
        <?php foreach ($rekeningOptions as $rekening) :
          $is_modal = (stripos($rekening['nama_rekening'] ?? '', 'modal') !== false) ? '1' : '0';
        ?>
          <option
            value="<?= $rekening['id'] ?>"
            data-is-modal="<?= $is_modal ?>"
            data-nama="<?= htmlspecialchars($rekening['nama_rekening']) ?>"
            data-kode="<?= htmlspecialchars($rekening['kode_rekening']) ?>"
          >
            <?= htmlspecialchars($rekening['nama_rekening']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </td>
    <td><input type="text" name="nama_rencana[]" class="form-control form-control-lg" placeholder="Uraian belanja" required></td>
    <td><input type="number" name="jumlah_rencana[]" class="form-control form-control-lg" value="1" min="1" required></td>
    <td><input type="number" name="jumlah_kegiatan[]" class="form-control form-control-lg" value="1" min="1" required></td>
    <td><input type="text" name="satuan[]" class="form-control form-control-lg" placeholder="rim, paket" required></td>
    <td><input type="number" name="harga_satuan[]" class="form-control form-control-lg" placeholder="50000" min="0" step="100" required></td>
    <td>
      <select name="bulan[]" class="form-select form-select-lg" required>
        <option>Januari</option><option>Februari</option><option>Maret</option><option>April</option>
        <option>Mei</option><option>Juni</option><option>Juli</option><option>Agustus</option>
        <option>September</option><option>Oktober</option><option>November</option><option>Desember</option>
      </select>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-danger btn-sm js-hapus-baris" title="Hapus baris ini"><i class="fas fa-trash"></i></button>
    </td>
  </tr>
</template>
<!-- === END TEMPLATE === -->

<script>
(function(){
  const container = document.getElementById('rencana-container');
  const btnTambah = document.getElementById('tambah-baris');
  const tpl = document.getElementById('template-row');

  function initSelect2(root){
    if (window.jQuery && jQuery().select2) {
      jQuery(root).find('.js-select2').each(function(){
        const $el = jQuery(this);
        if (!$el.data('select2')) {
          $el.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: $el.data('placeholder') || ''
          });
        }
      });
    }
  }

  function addRow(){
    const node = tpl.content.cloneNode(true);
    container.appendChild(node);
    initSelect2(container);
  }

  // ==== FIX ANTI DOUBLE-ADD ====
  // Pakai fase CAPTURE + hentikan propagasi, supaya handler lain (mis. di footer) tidak ikut dieksekusi.
  if (btnTambah && !btnTambah.dataset.bound) {
    btnTambah.dataset.bound = '1';
    btnTambah.addEventListener('click', function(e){
      e.preventDefault();
      // hentikan semua handler lain di elemen ini
      if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
      e.stopPropagation(); // cegah bubbling ke document/body
      addRow();            // hanya 1 baris
      return false;
    }, true); // <-- useCapture = true
  }

  // Hapus baris (delegasi)
  container.addEventListener('click', function(e){
    if (e.target.closest('.js-hapus-baris')) {
      const tr = e.target.closest('tr');
      if (tr) tr.remove();
    }
  });

  // ====== VALIDASI MODAL/NON-MODAL + POPUP ======
  function checkRow(tr){
    if (!tr) return;
    const sel = tr.querySelector('select[name="rekening_id[]"]');
    const hargaInput = tr.querySelector('input[name="harga_satuan[]"]');
    if (!sel || !hargaInput) return;

    const opt = sel.options[sel.selectedIndex];
    const isModal = opt && opt.dataset && opt.dataset.isModal === '1';
    const harga = parseFloat(hargaInput.value || '0');

    if (harga > 600000 && !isModal) {
      if (!tr.dataset.warned) {
        tr.dataset.warned = '1';
        alert('Pagu ini masuk batas modal, jika untuk pembelian modal, ganti rekening anda ke modal, jika bukan pembelian modal abaikan pesan ini');
      }
      tr.classList.add('table-warning');
    } else {
      tr.classList.remove('table-warning');
      tr.dataset.warned = '';
    }
  }

  container.addEventListener('change', function(e){
    if (e.target.matches('select[name="rekening_id[]"]') || e.target.matches('input[name="harga_satuan[]"]')) {
      checkRow(e.target.closest('tr'));
    }
  });
  container.addEventListener('input', function(e){
    if (e.target.matches('input[name="harga_satuan[]"]')) {
      checkRow(e.target.closest('tr'));
    }
  });

  const form = document.getElementById('form-rencana');
  if (form) {
    form.addEventListener('submit', function(){
      container.querySelectorAll('tr').forEach(checkRow);
      // tidak memblokir submit
    });
  }
})();
</script>

<?php
// Memuat footer yang berisi skrip JavaScript
include_once ROOT_PATH . '/views/layouts/footer.php';
?>
