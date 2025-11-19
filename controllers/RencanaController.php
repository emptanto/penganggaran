<?php
// controllers/RencanaController.php

/**
 * Class RencanaController
 * Mengelola semua logika bisnis terkait data Rencana Anggaran.
 */
class RencanaController {
    private $conn;

    /**
     * @param mysqli $db Objek koneksi database
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mengambil data rencana dengan filter, sorting, dan paginasi.
     * @param array $filters Opsi filter dari user.
     * @return array Hasil query berisi data, total baris, dan grand total.
     */
    public function getFiltered($filters) {
    $baseQuery = "
        FROM rencana
        JOIN kegiatan ON rencana.kegiatan_id = kegiatan.id
        JOIN rekening ON rencana.rekening_id = rekening.id
        JOIN users    ON rencana.user_id    = users.id
    ";
    
    $whereClause = "WHERE 1=1";
    $whereTypes  = "";
    $whereParams = [];

    // --- Membangun klausa WHERE secara dinamis ---
    if (empty($filters['isSuperadmin'])) {
        $whereClause .= " AND rencana.user_id = ?";
        $whereTypes  .= "i";
        $whereParams[] = (int)$filters['userId'];
    } elseif (!empty($filters['filter_user'])) {
        $whereClause .= " AND rencana.user_id = ?";
        $whereTypes  .= "i";
        $whereParams[] = (int)$filters['filter_user'];
    }

    if (!empty($filters['filter_kegiatan'])) {
        $whereClause .= " AND rencana.kegiatan_id = ?";
        $whereTypes  .= "i";
        $whereParams[] = (int)$filters['filter_kegiatan'];
    }

    if (!empty($filters['filter_rekening'])) {
        $whereClause .= " AND rencana.rekening_id = ?";
        $whereTypes  .= "i";
        $whereParams[] = (int)$filters['filter_rekening'];
    }

    if (!empty($filters['filter_bulan'])) {
        $whereClause .= " AND rencana.bulan = ?";
        $whereTypes  .= "s";
        $whereParams[] = (string)$filters['filter_bulan'];
    }

    // FILTER BARU: URAIAN
    if (!empty($filters['filter_uraian'])) {
        $whereClause .= " AND (rencana.nama_rencana LIKE ? OR COALESCE(rencana.nama_rencana_kegiatan, '') LIKE ?)";
        $whereTypes  .= "ss";
        $keyword = '%' . $filters['filter_uraian'] . '%';
        $whereParams[] = $keyword;
        $whereParams[] = $keyword;
    }

    // --- SORTING AMAN ---
    // Nilai mentah dari filters
    $sortByRaw = isset($filters['sortBy']) ? trim($filters['sortBy']) : '';

    // Daftar kolom yang diizinkan
    $allowedSortColumns = [
        'rencana.id',
        'kegiatan.nama_kegiatan',
        'rekening.nama_rekening',
        'rencana.nama_rencana',
        'rencana.harga_satuan',
        'rencana.bulan',
        'users.username',
    ];

    // Kalau kosong atau tidak ada di whitelist, pakai default
    if ($sortByRaw === '' || !in_array($sortByRaw, $allowedSortColumns, true)) {
        $sortBy = 'rencana.id';
    } else {
        $sortBy = $sortByRaw;
    }

    // Urutan ASC / DESC
    $orderRaw = isset($filters['order']) ? strtolower($filters['order']) : 'desc';
    $order    = ($orderRaw === 'asc') ? 'ASC' : 'DESC';

    $orderBy = "ORDER BY {$sortBy} {$order}";

    // --- LIMIT / OFFSET ---
    $useLimit   = isset($filters['limit']);
    $limitClause = $useLimit ? "LIMIT ?, ?" : "";

    // ==============================
    // QUERY DATA UTAMA
    // ==============================
    $sqlData = "
        SELECT
            rencana.*,
            kegiatan.kode_kegiatan,
            kegiatan.nama_kegiatan,
            kegiatan.program,
            kegiatan.sub_program,
            rekening.kode_rekening,
            rekening.nama_rekening,
            users.username
        {$baseQuery}
        {$whereClause}
        {$orderBy}
        {$limitClause}
    ";

    $stmtData = $this->conn->prepare($sqlData);
    if (!$stmtData) {
        throw new Exception("Prepare gagal (data): " . $this->conn->error);
    }

    if ($useLimit) {
        $dataTypes  = $whereTypes . "ii";
        $dataParams = $whereParams;
        $dataParams[] = (int)$filters['offset'];
        $dataParams[] = (int)$filters['limit'];

        if ($dataTypes !== "") {
            $stmtData->bind_param($dataTypes, ...$dataParams);
        }
    } else {
        if ($whereTypes !== "") {
            $stmtData->bind_param($whereTypes, ...$whereParams);
        }
    }

    $stmtData->execute();
    $resultData = $stmtData->get_result();

    // ==============================
    // QUERY TOTAL ROWS
    // ==============================
    $sqlCount = "
        SELECT COUNT(rencana.id) AS total
        {$baseQuery}
        {$whereClause}
    ";
    $stmtCount = $this->conn->prepare($sqlCount);
    if (!$stmtCount) {
        throw new Exception("Prepare gagal (count): " . $this->conn->error);
    }

    if ($whereTypes !== "") {
        $stmtCount->bind_param($whereTypes, ...$whereParams);
    }

    $stmtCount->execute();
    $rowCount  = $stmtCount->get_result()->fetch_assoc();
    $totalRows = (int)($rowCount['total'] ?? 0);

    // ==============================
    // QUERY GRAND TOTAL
    // ==============================
    $sqlSum = "
        SELECT SUM(rencana.total_biaya) AS grand_total
        {$baseQuery}
        {$whereClause}
    ";
    $stmtSum = $this->conn->prepare($sqlSum);
    if (!$stmtSum) {
        throw new Exception("Prepare gagal (sum): " . $this->conn->error);
    }

    if ($whereTypes !== "") {
        $stmtSum->bind_param($whereTypes, ...$whereParams);
    }

    $stmtSum->execute();
    $rowSum     = $stmtSum->get_result()->fetch_assoc();
    $grandTotal = (int)($rowSum['grand_total'] ?? 0);

    return [
        'data'        => $resultData,
        'total_rows'  => $totalRows,
        'grand_total' => $grandTotal
    ];
}


    /**
     * Memperbarui data rencana di database.
     * @param array $data Data dari form edit.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function update($data) {
    $jumlah_rencana   = (int)$data['jumlah_rencana'];
    $jumlah_kegiatan  = (int)$data['jumlah_kegiatan'];
    $harga_satuan     = (int)$data['harga_satuan'];

    $total_biaya = $jumlah_rencana * $jumlah_kegiatan * $harga_satuan;
    $nama_rencana_kegiatan = !empty($data['nama_rencana_kegiatan']) ? $data['nama_rencana_kegiatan'] : null;

    $sql = "
        UPDATE rencana SET 
            kegiatan_id           = ?,
            rekening_id           = ?,
            nama_rencana          = ?,
            nama_rencana_kegiatan = ?,
            jumlah_rencana        = ?,
            jumlah_kegiatan       = ?,
            satuan                = ?,
            harga_satuan          = ?,
            total_biaya           = ?,
            bulan                 = ?
        WHERE id = ?
    ";
    
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare gagal (update): " . $this->conn->error);
    }

    // Tipe parameter:
    // 1  kegiatan_id           -> i
    // 2  rekening_id           -> i
    // 3  nama_rencana          -> s
    // 4  nama_rencana_kegiatan -> s
    // 5  jumlah_rencana        -> i
    // 6  jumlah_kegiatan       -> i
    // 7  satuan                -> s
    // 8  harga_satuan          -> i
    // 9  total_biaya           -> i
    // 10 bulan                 -> s
    // 11 id                    -> i
    $stmt->bind_param(
        "iissiisiisi",
        $data['kegiatan_id'],
        $data['rekening_id'],
        $data['nama_rencana'],
        $nama_rencana_kegiatan,
        $jumlah_rencana,
        $jumlah_kegiatan,
        $data['satuan'],
        $harga_satuan,
        $total_biaya,
        $data['bulan'],
        $data['id']
    );
    
    return $stmt->execute();
}

}
