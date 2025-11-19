<?php
session_start();
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
require_once ROOT_PATH .  '/controllers/RencanaController.php';

// --- 1. INISIALISASI ---
$rencanaController = new RencanaController($conn);

// --- 2. PROSES FORM SUBMISSION (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kumpulkan semua data form ke dalam satu array
    $formData = [
        'id' => $_POST['id'],
        'kegiatan_id' => $_POST['kegiatan_id'],
        'rekening_id' => $_POST['rekening_id'],
        'nama_rencana' => $_POST['nama_rencana'],
        'nama_rencana_kegiatan' => trim($_POST['nama_rencana_kegiatan']),
        'jumlah_rencana' => $_POST['jumlah_rencana'],
        'jumlah_kegiatan' => $_POST['jumlah_kegiatan'],
        'satuan' => $_POST['satuan'],
        'harga_satuan' => $_POST['harga_satuan'],
        'bulan' => $_POST['bulan'],
    ];

    // Panggil method update dari controller
    if ($rencanaController->update($formData)) {
        $_SESSION['success_message'] = "Data rencana berhasil diperbarui.";
        // Redirect ke halaman sebelumnya (daftar rencana)
        header("Location: " . ($_SESSION['previous_url'] ?? 'rencana_list.php'));
        exit;
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data. Silakan coba lagi.";
        // Redirect kembali ke halaman edit ini sendiri untuk menampilkan error
        header("Location: rencana_edit.php?id=" . $_POST['id']);
        exit;
    }
}

// --- 3. AMBIL DATA UNTUK DITAMPILKAN DI FORM (GET) ---
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $_SESSION['error_message'] = "ID Rencana tidak valid.";
    header("Location: rencana_list.php");
    exit;
}

// Ambil data rencana yang ada, pastikan menggunakan prepared statement
$stmt = $conn->prepare("SELECT * FROM rencana WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    $_SESSION['error_message'] = "Data rencana tidak ditemukan.";
    header("Location: rencana_list.php");
    exit;
}

// --- 4. TAMPILKAN HALAMAN HTML ---
include_once ROOT_PATH .  '/views/layouts/header.php';

// Ambil data untuk dropdowns
$kegiatanList = $conn->query("SELECT id, kode_kegiatan, nama_kegiatan FROM kegiatan ORDER BY kode_kegiatan ASC");
$rekeningList = $conn->query("SELECT id, kode_rekening, nama_rekening FROM rekening ORDER BY kode_rekening ASC");
$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h3 class="mb-0">Edit Rencana Penganggaran</h3>
        </div>
        <div class="card-body">
            
            <?php include ROOT_PATH .  '/views/layouts/flash_messages.php'; ?>

            <form method="POST" action="rencana_edit.php" class="row g-3">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="col-md-6">
                    <label for="kegiatan_id" class="form-label">Kegiatan Utama (Program):</label>
                    <select id="kegiatan_id" name="kegiatan_id"
                            class="form-select select2-basic"
                            required>
                        <?php mysqli_data_seek($kegiatanList, 0); while ($k = $kegiatanList->fetch_assoc()): ?>
                            <option value="<?= $k['id'] ?>" <?= $data['kegiatan_id'] == $k['id'] ? 'selected' : '' ?>>
                                [<?= htmlspecialchars($k['kode_kegiatan']) ?>] <?= htmlspecialchars($k['nama_kegiatan']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="nama_rencana_kegiatan" class="form-label">Nama Rencana Kegiatan (Opsional):</label>
                    <input type="text" id="nama_rencana_kegiatan" name="nama_rencana_kegiatan" class="form-control" value="<?= htmlspecialchars($data['nama_rencana_kegiatan'] ?? '') ?>" placeholder="Contoh: Lomba LKS, Workshop, dll.">
                </div>

                <div class="col-md-12">
                    <label for="rekening_id" class="form-label">Rekening:</label>
                    <select id="rekening_id" name="rekening_id"
                            class="form-select select2-basic"
                            required>
                        <?php mysqli_data_seek($rekeningList, 0); while ($r = $rekeningList->fetch_assoc()): ?>
                            <option value="<?= $r['id'] ?>" <?= $data['rekening_id'] == $r['id'] ? 'selected' : '' ?>>
                                [<?= htmlspecialchars($r['kode_rekening']) ?>] <?= htmlspecialchars($r['nama_rekening']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <label for="nama_rencana" class="form-label">Uraian Belanja:</label>
                    <input type="text" id="nama_rencana" name="nama_rencana" class="form-control" value="<?= htmlspecialchars($data['nama_rencana']) ?>" required>
                </div>
                
                <div class="col-md-6">
                    <label for="jumlah_rencana" class="form-label">Jumlah Rencana:</label>
                    <input type="number" step="1" id="jumlah_rencana" name="jumlah_rencana" class="form-control" value="<?= (int)$data['jumlah_rencana'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="jumlah_kegiatan" class="form-label">Jumlah Kegiatan:</label>
                    <input type="number" step="1" id="jumlah_kegiatan" name="jumlah_kegiatan" class="form-control" value="<?= (int)$data['jumlah_kegiatan'] ?>" required>
                </div>

                <div class="col-md-4">
                    <label for="satuan" class="form-label">Satuan:</label>
                    <input type="text" id="satuan" name="satuan" class="form-control" value="<?= htmlspecialchars($data['satuan']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label for="harga_satuan" class="form-label">Harga Satuan:</label>
                    <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" value="<?= (int)$data['harga_satuan'] ?>" required>
                </div>

                <div class="col-md-4">
                    <label for="bulan" class="form-label">Bulan:</label>
                    <select id="bulan" name="bulan" class="form-select" required>
                        <?php foreach ($bulanList as $b): ?>
                            <option value="<?= $b ?>" <?= $data['bulan'] === $b ? 'selected' : '' ?>><?= $b ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?= $_SESSION['previous_url'] ?? 'rencana_list.php' ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Inisialisasi Select2 untuk kegiatan & rekening
document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery && jQuery.fn.select2) {
        jQuery('#kegiatan_id, #rekening_id').select2({
            width: '100%'
        });
    }
});
</script>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>
