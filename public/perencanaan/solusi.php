<?php
// Asumsi header.php, db.php, auth_check.php sudah di-include
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
include_once ROOT_PATH .  '/views/layouts/header.php';



// --- Ambil Input dari Form ---
$sumber_data = isset($_POST['sumber_data']) ? $_POST['sumber_data'] : '';
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';

// Validasi input
if (empty($sumber_data) || empty(trim($deskripsi))) {
    die("Error: Harap lengkapi semua isian form.");
}

// --- Proses Kata Kunci ---
$stopWords = ['dan', 'di', 'untuk', 'atau', 'dalam', 'kegiatan', 'pelaksanaan', 'pengembangan', 'belanja'];
$keywords = array_diff(explode(' ', strtolower($deskripsi)), $stopWords);
$keywords = array_filter($keywords);
if (empty($keywords)) {
    die("Error: Deskripsi terlalu singkat.");
}

$sql = "";
$params = [];
$types = "";

// --- LOGIKA UTAMA: Pilih Query Berdasarkan Sumber Data ---
if ($sumber_data === 'kegiatan') {
    // --- Query untuk Tabel KEGIATAN ---
    $sql = "SELECT *, (0";
    foreach ($keywords as $keyword) {
        $sql .= " + (CASE WHEN program LIKE ? THEN 1 ELSE 0 END)";
        $sql .= " + (CASE WHEN sub_program LIKE ? THEN 2 ELSE 0 END)";
        $sql .= " + (CASE WHEN nama_kegiatan LIKE ? THEN 3 ELSE 0 END)";
    }
    $sql .= ") AS relevance_score FROM kegiatan";
    
    // Siapkan parameter dan klausa WHERE
    $whereParts = [];
    foreach ($keywords as $keyword) {
        $whereParts[] = "(program LIKE ? OR sub_program LIKE ? OR nama_kegiatan LIKE ?)";
        for ($i=0; $i<3; $i++) { $params[] = "%".$keyword."%"; $types .= "s"; }
    }
    // Gabungkan parameter untuk HAVING clause
    foreach ($keywords as $keyword) {
        for ($i=0; $i<3; $i++) { $params[] = "%".$keyword."%"; $types .= "s"; }
    }
    $sql .= " WHERE " . implode(' OR ', $whereParts);
    $sql .= " HAVING relevance_score > 0 ORDER BY relevance_score DESC LIMIT 10";

} elseif ($sumber_data === 'rekening') {
    // --- Query untuk Tabel REKENING ---
    $sql = "SELECT *, (0";
    foreach ($keywords as $keyword) {
        $sql .= " + (CASE WHEN nama_belanja LIKE ? THEN 2 ELSE 0 END)";
        $sql .= " + (CASE WHEN nama_rekening LIKE ? THEN 3 ELSE 0 END)";
    }
    $sql .= ") AS relevance_score FROM rekening";

    // Siapkan parameter dan klausa WHERE
    $whereParts = [];
    foreach ($keywords as $keyword) {
        $whereParts[] = "(nama_belanja LIKE ? OR nama_rekening LIKE ?)";
        for ($i=0; $i<2; $i++) { $params[] = "%".$keyword."%"; $types .= "s"; }
    }
    // Gabungkan parameter untuk HAVING clause
    foreach ($keywords as $keyword) {
        for ($i=0; $i<2; $i++) { $params[] = "%".$keyword."%"; $types .= "s"; }
    }
    $sql .= " WHERE " . implode(' OR ', $whereParts);
    $sql .= " HAVING relevance_score > 0 ORDER BY relevance_score DESC LIMIT 10";
} else {
    die("Sumber data tidak valid.");
}

// --- Eksekusi Query ---
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Error dalam mempersiapkan query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <h2 class="text-center mb-3">Hasil Pencarian dari "<?php echo ucfirst($sumber_data); ?>"</h2>
            <div class="card mb-4"><div class="card-body text-center bg-light">
                <p class="mb-1 text-muted">Anda mencari untuk:</p>
                <blockquote class="blockquote mb-0"><p>"<?php echo htmlspecialchars($deskripsi); ?>"</p></blockquote>
            </div></div>

            <?php if ($result->num_rows > 0): ?>
                <p class="text-muted mb-3"><i class="bi bi-check-circle-fill text-success"></i> Ditemukan <strong><?php echo $result->num_rows; ?></strong> data relevan:</p>
                
                <div class="list-group">
                <?php while($row = $result->fetch_assoc()): ?>
                    <?php if ($sumber_data === 'kegiatan'): ?>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?php echo htmlspecialchars($row['nama_kegiatan']); ?></h5>
                                <span class="badge bg-primary rounded-pill p-2 align-self-start">Skor: <?php echo $row['relevance_score']; ?></span>
                            </div>
                            <p class="mb-1"><small class="text-muted">
                                <strong>Program:</strong> <?php echo htmlspecialchars($row['program']); ?>
                            </small></p>
                            <small class="text-secondary">Kode: <?php echo htmlspecialchars($row['kode_kegiatan']); ?></small>
                        </div>
                    <?php else: ?>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?php echo htmlspecialchars($row['nama_rekening']); ?></h5>
                                <span class="badge bg-success rounded-pill p-2">Skor: <?php echo $row['relevance_score']; ?></span>
                            </div>
                            <p class="mb-1"><small class="text-muted">
                                <strong>Jenis Belanja:</strong> <?php echo htmlspecialchars($row['nama_belanja']); ?>
                            </small></p>
                            <small class="text-secondary">Kode Rekening: <?php echo htmlspecialchars($row['kode_rekening']); ?></small>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
                </div>

            <?php else: ?>
                <div class="alert alert-warning text-center"><h4 class="alert-heading">Tidak Ditemukan</h4>
                <p>Maaf, tidak ada data yang cocok dengan deskripsi Anda di database <strong><?php echo ucfirst($sumber_data); ?></strong>.</p></div>
            <?php endif; ?>

            <div class="text-center mt-4"><a href="form_analisa.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Form</a></div>

        </div>
    </div>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>