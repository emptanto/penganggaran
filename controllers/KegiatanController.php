<?php
class KegiatanController
{
    /** @var mysqli */
    private $conn;

    public function __construct(mysqli $db_conn)
    {
        $this->conn = $db_conn;
    }

    /**
     * Simpan kegiatan baru.
     * PERBAIKAN: urutan bind_param disesuaikan dengan urutan kolom pada INSERT.
     */
    public function simpan(string $kode, string $program, string $sub_program, string $nama, int $user_id): bool
    {
        $sql = "INSERT INTO kegiatan (kode_kegiatan, program, sub_program, nama_kegiatan, created_by)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        // BENAR: kode, program, sub_program, nama, user_id
        $stmt->bind_param("ssssi", $kode, $program, $sub_program, $nama, $user_id);
        return $stmt->execute();
    }

    /**
     * Update kegiatan.
     */
    public function update(int $id, string $kode, string $program, string $sub_program, string $nama): bool
    {
        $sql  = "UPDATE kegiatan
                 SET kode_kegiatan = ?, program = ?, sub_program = ?, nama_kegiatan = ?
                 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $kode, $program, $sub_program, $nama, $id);
        return $stmt->execute();
    }

    /**
     * Hapus kegiatan.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM kegiatan WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Get by id.
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM kegiatan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    /**
     * Get all.
     */
    public function getAll(?int $user_id = null, bool $is_superadmin = false)
    {
        if ($is_superadmin) {
            return $this->conn->query("SELECT * FROM kegiatan ORDER BY id DESC");
        }
        $stmt = $this->conn->prepare("SELECT * FROM kegiatan WHERE created_by = ? ORDER BY id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Import CSV kegiatan.
     * - Deteksi delimiter (',' atau ';')
     * - Strip BOM
     * - Mapping berdasarkan NAMA HEADER (bukan urutan)
     * - Transaksi + upsert (kode_kegiatan unik)
     * @return int|false jumlah baris tersimpan, 0 kalau tidak ada baris valid, false kalau gagal
     */
    public function importCSV(string $filepath, int $user_id)
    {
        if (!is_readable($filepath)) return false;

        $h = fopen($filepath, "r");
        if (!$h) return false;

        // --- detect delimiter ---
        $first = fgets($h);
        if ($first === false) { fclose($h); return 0; }
        $first = preg_replace('/^\xEF\xBB\xBF/', '', $first); // strip BOM
        $comma = str_getcsv($first, ',');
        $semi  = str_getcsv($first, ';');
        $delim = (count($semi) > count($comma)) ? ';' : ',';
        fseek($h, 0);

        // --- read header ---
        $header = fgetcsv($h, 0, $delim);
        if ($header === false) { fclose($h); return false; }
        $header = array_map(function($v){
            $v = preg_replace('/^\xEF\xBB\xBF/', '', (string)$v);
            return strtolower(trim($v));
        }, $header);

        $need = ['kode_kegiatan','program','sub_program','nama_kegiatan'];
        $idx  = [];
        foreach ($need as $col) {
            $pos = array_search($col, $header, true);
            if ($pos === false) { fclose($h); return false; }
            $idx[$col] = $pos;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->conn->begin_transaction();

            // upsert berdasarkan kode_kegiatan
            $sql = "INSERT INTO kegiatan (kode_kegiatan, program, sub_program, nama_kegiatan, created_by)
                    VALUES (?,?,?,?,?)
                    ON DUPLICATE KEY UPDATE
                      program = VALUES(program),
                      sub_program = VALUES(sub_program),
                      nama_kegiatan = VALUES(nama_kegiatan)";
            $stmt = $this->conn->prepare($sql);

            $count = 0;
            while (($row = fgetcsv($h, 0, $delim)) !== false) {
                if (count($row) === 1 && trim($row[0]) === '') continue; // skip kosong
                // normalize cells
                foreach ($row as &$cell) $cell = trim((string)$cell);

                $kode = $row[$idx['kode_kegiatan']] ?? '';
                $prog = $row[$idx['program']]        ?? '';
                $sub  = $row[$idx['sub_program']]    ?? '';
                $nama = $row[$idx['nama_kegiatan']]  ?? '';

                if ($kode === '' || $prog === '' || $sub === '' || $nama === '') continue;

                $stmt->bind_param("ssssi", $kode, $prog, $sub, $nama, $user_id);
                $stmt->execute();
                $count++;
            }
            $stmt->close();

            $this->conn->commit();
            fclose($h);
            return $count;
        } catch (Throwable $e) {
            $this->conn->rollback();
            if (is_resource($h)) fclose($h);
            // optional: error_log($e->getMessage());
            return false;
        }
    }
}
