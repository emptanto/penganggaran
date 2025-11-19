<?php
// 1. SEMUA LOGIKA PHP DI ATAS
require_once '../../config/db.php'; 
require_once ROOT_PATH .  '/config/auth_check.php';
require_once ROOT_PATH .  '/controllers/KegiatanController.php';

$controller = new KegiatanController($conn);

// 2. PROSES FORM (UPDATE DATA)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // [SARAN] Ambil data dengan null coalescing operator untuk keamanan
    $id = $_POST['id'] ?? 0;
    $kode = $_POST['kode_kegiatan'] ?? '';
    $program = $_POST['program'] ?? '';
    $sub_program = $_POST['sub_program'] ?? '';
    $nama = $_POST['nama_kegiatan'] ?? '';

    // Lanjutkan hanya jika ID valid
    if ($id > 0) {
        $result = $controller->update($id, $kode, $program, $sub_program, $nama);
        if ($result) {
            header("Location: kegiatan_list.php?status=update_sukses");
        } else {
            header("Location: kegiatan_list.php?status=update_gagal");
        }
    } else {
        header("Location: kegiatan_list.php?status=invalid_id");
    }
    exit;
}


// 3. AMBIL DATA UNTUK DITAMPILKAN
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kegiatan_list.php?status=invalid_id");
    exit;
}
$id = $_GET['id'];
$data = $controller->getById($id);

if (!$data) {
    header("Location: kegiatan_list.php?status=not_found");
    exit;
}

// 4. MULAI OUTPUT HTML
require_once ROOT_PATH .  '/views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="mb-0">Edit Kegiatan</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                
                <div class="mb-3">
                    <label for="kode_kegiatan" class="form-label">Kode Kegiatan</label>
                    <input type="text" id="kode_kegiatan" name="kode_kegiatan" class="form-control" value="<?= htmlspecialchars($data['kode_kegiatan']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="program" class="form-label">Program</label>
                    <input type="text" id="program" name="program" class="form-control" value="<?= htmlspecialchars($data['program']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sub_program" class="form-label">Sub Program</label>
                    <input type="text" id="sub_program" name="sub_program" class="form-control" value="<?= htmlspecialchars($data['sub_program']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="form-control" value="<?= htmlspecialchars($data['nama_kegiatan']) ?>" required>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="kegiatan_list.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; // Disarankan juga menggunakan include_once di sini ?>