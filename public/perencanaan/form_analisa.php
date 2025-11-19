<?php
require_once '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';
require_once ROOT_PATH .  '/views/layouts/header.php';
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisa Rencana Kegiatan & Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Cari Referensi</h2>
                        
                        <form action="solusi.php" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label"><strong>1. Pilih Sumber Data Referensi:</strong></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sumber_data" id="sumber_kegiatan" value="kegiatan" checked>
                                    <label class="form-check-label" for="sumber_kegiatan">
                                        Database Kegiatan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sumber_data" id="sumber_rekening" value="rekening">
                                    <label class="form-check-label" for="sumber_rekening">
                                        Database Rekening Belanja
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label"><strong>2. Ketik Kata Kunci atau Deskripsi Pencarian:</strong></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required placeholder="Contoh: perjalanan dinas, bahan bangunan, administrasi sekolah..."></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Temukan Referensi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>