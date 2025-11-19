<?php
require_once 'config/db.php';

class RekeningController
{
    private $conn;

    public function __construct($db_conn)
    {
        $this->conn = $db_conn;
    }

    /**
     * Menyimpan rekening baru dengan nama_belanja.
     */
    // DIUBAH: Menambahkan parameter $nama_belanja dan $nama_rekening
    public function simpan($kode, $nama_belanja, $nama_rekening, $user_id)
    {
        // DIUBAH: Query INSERT disesuaikan
        $stmt = $this->conn->prepare("INSERT INTO rekening (kode_rekening, nama_belanja, nama_rekening, created_by) VALUES (?, ?, ?, ?)");
        
        // DIUBAH: bind_param disesuaikan menjadi "sssi"
        $stmt->bind_param("sssi", $kode, $nama_belanja, $nama_rekening, $user_id);
        
        return $stmt->execute();
    }

    /**
     * Mengupdate data rekening dengan nama_belanja.
     */
    // DIUBAH: Menambahkan parameter $nama_belanja dan $nama_rekening
    public function update($id, $kode, $nama_belanja, $nama_rekening)
    {
        // DIUBAH: Query UPDATE disesuaikan
        $stmt = $this->conn->prepare("UPDATE rekening SET kode_rekening = ?, nama_belanja = ?, nama_rekening = ? WHERE id = ?");
        
        // DIUBAH: bind_param disesuaikan menjadi "sssi"
        $stmt->bind_param("sssi", $kode, $nama_belanja, $nama_rekening, $id);
        
        return $stmt->execute();
    }

    /**
     * Menghapus data rekening berdasarkan ID.
     */
    public function delete($id)
    {
        // TIDAK PERLU DIUBAH
        $stmt = $this->conn->prepare("DELETE FROM rekening WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Mengambil satu data rekening berdasarkan ID.
     */
    public function getById($id)
    {
        // TIDAK PERLU DIUBAH: SELECT * sudah mencakup semua kolom.
        $stmt = $this->conn->prepare("SELECT * FROM rekening WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Mengambil semua data rekening.
     */
    public function getAll($user_id = null, $is_superadmin = false)
    {
        // TIDAK PERLU DIUBAH: SELECT * sudah mencakup semua kolom.
        if ($is_superadmin) {
            $sql = "SELECT * FROM rekening ORDER BY id DESC";
            return $this->conn->query($sql);
        } else {
            // Sebaiknya gunakan prepared statement juga di sini untuk konsistensi
            $stmt = $this->conn->prepare("SELECT * FROM rekening WHERE created_by = ? ORDER BY id DESC");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->get_result();
        }
    }

    /**
     * Mengimpor data dari file CSV dengan format baru (3 kolom).
     */
    // DIUBAH: Disesuaikan untuk memproses 3 kolom dari CSV
    public function importCSV($filepath, $user_id)
    {
        if (($handle = fopen($filepath, "r")) !== FALSE) {
            fgetcsv($handle); // Lewati baris header

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Pastikan baris memiliki 3 kolom
                if (count($data) >= 3) {
                    $kode = trim($data[0]);
                    $nama_belanja = trim($data[1]);
                    $nama_rekening = trim($data[2]);

                    // Panggil fungsi simpan yang baru dengan semua parameter
                    if (!empty($kode) && !empty($nama_belanja) && !empty($nama_rekening)) {
                        $this->simpan($kode, $nama_belanja, $nama_rekening, $user_id);
                    }
                }
            }
            fclose($handle);
            return true;
        }
        return false;
    }
}