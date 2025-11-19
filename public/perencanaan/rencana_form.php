<?php
// rencana_form.php
?>
<h5 class="card-title mb-4">Tambah Rencana Anggaran Baru</h5>

<form action="rencana_tambah.php" method="POST">
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="kegiatan_id" class="form-label">Pilih Kegiatan</label>
            <select name="kegiatan_id" id="kegiatan_id" class="form-select select2-basic" required>
                <option value="">-- Pilih Kegiatan --</option>
                <?php foreach ($kegiatanList as $kegiatan): ?>
                    <option value="<?= $kegiatan['id'] ?>">
                        <?= htmlspecialchars($kegiatan['nama_kegiatan']) ?> 
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="rekening_id" class="form-label">Pilih Rekening</label>
            <select name="rekening_id" id="rekening_id" class="form-select select2-basic" required>
                <option value="">-- Pilih Rekening --</option>
                <?php foreach ($rekeningList as $rekening): ?>
                    <option value="<?= $rekening['id'] ?>">
                        <?= htmlspecialchars($rekening['nama_rekening']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label for="nama_rencana" class="form-label">Nama Rencana / Uraian</label>
            <input type="text" name="nama_rencana" id="nama_rencana" class="form-control" required>
        </div>
    </div>
   



    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="jumlah_rencana" class="form-label">Jumlah Rencana</label>
            <input type="number" name="jumlah_rencana" id="jumlah_rencana" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="jumlah_kegiatan" class="form-label">Jumlah Kegiatan</label>
            <input type="number" name="jumlah_kegiatan" id="jumlah_kegiatan" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" required>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label for="harga_satuan" class="form-label">Harga Satuan</label>
            <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="bulan" class="form-label">Bulan</label>
            <select name="bulan" id="bulan" class="form-select select2" required>
                <option value="">-- Pilih Bulan --</option>
                <?php
                $bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                foreach ($bulanList as $bulan):
                ?>
                    <option value="<?= $bulan ?>"><?= $bulan ?></option>
                <?php endforeach; ?>
            </select>
        </div>
            <div class="col-md-4 d-flex align-self-end">
        <button type="submit" class="btn btn-primary">Simpan Rencana</button>
    </div>
    </div>
    

</form>