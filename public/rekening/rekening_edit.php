<?php
// 1. SEMUA LOGIKA PHP DI ATAS
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php'; 

// 2. PROSES FORM (UPDATE DATA) JIKA ADA PENGIRIMAN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form
    $id            = $_POST['id']; // Ambil ID dari hidden input
    $kode_rekening = trim($_POST['kode_rekening']);
    $nama_belanja  = trim($_POST['nama_belanja']);
    $nama_rekening = trim($_POST['nama_rekening']);

    $stmt = $conn->prepare("UPDATE rekening SET kode_rekening = ?, nama_belanja = ?, nama_rekening = ? WHERE id = ?");
    $stmt->bind_param("sssi", $kode_rekening, $nama_belanja, $nama_rekening, $id);
    
    // Lakukan redirect SEKARANG JUGA
    if ($stmt->execute()) {
        header("Location: rekening_list.php?status=update_sukses");
    } else {
        header("Location: rekening_list.php?status=update_gagal");
    }
    exit; // Wajib ada exit() setelah redirect
}

// 3. AMBIL DATA UNTUK DITAMPILKAN DI FORM
// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: rekening_list.php?status=invalid_id");
    exit;
}
$id = $_GET['id'];

// Ambil data rekening yang akan di-edit
$stmt = $conn->prepare("SELECT * FROM rekening WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Jika data dengan ID tersebut tidak ditemukan, redirect
if (!$data) {
    header("Location: rekening_list.php?status=not_found");
    exit;
}

// 4. SETELAH SEMUA LOGIKA SELESAI, BARU MULAI OUTPUT HTML
require_once ROOT_PATH .  '/views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2 class="mb-0">Edit Rekening</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="rekening_edit.php?id=<?= htmlspecialchars($id) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                        
                        <div class="mb-3">
                            <label for="kode_rekening" class="form-label">Kode Rekening</label>
                            <input type="text" id="kode_rekening" name="kode_rekening" class="form-control" value="<?= htmlspecialchars($data['kode_rekening']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_belanja" class="form-label">Nama Belanja</label>
                            <input type="text" id="nama_belanja" name="nama_belanja" class="form-control" value="<?= htmlspecialchars($data['nama_belanja']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_rekening" class="form-label">Nama Rekening</label>
                            <input type="text" id="nama_rekening" name="nama_rekening" class="form-control" value="<?= htmlspecialchars($data['nama_rekening']) ?>" required>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="rekening_list.php" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>