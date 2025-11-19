<?php
// Mulai session untuk mengambil ID pengguna yang login
session_start(); 
require '../../config/db.php';
require_once ROOT_PATH .  '/config/auth_check.php';



// Periksa apakah form dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ambil dan bersihkan semua input dari form
    $kode_kegiatan = trim($_POST['kode_kegiatan']);
    $program = trim($_POST['program']);         // BARU: Ambil data program
    $sub_program = trim($_POST['sub_program']); // BARU: Ambil data sub program
        $nama_kegiatan = trim($_POST['nama_kegiatan']);

    // 2. Validasi input: pastikan semua field yang wajib terisi tidak kosong
    if (!empty($kode_kegiatan) && !empty($program) && !empty($sub_program) && !empty($nama_kegiatan)) {
        
        // 3. Gunakan Prepared Statements untuk keamanan maksimal (mencegah SQL Injection)
        $sql = "INSERT INTO kegiatan (kode_kegiatan, program, sub_program, nama_kegiatan, created_by) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Jika prepare gagal
            die("Error preparing statement: " . $conn->error);
        }

        // Ambil ID pengguna dari session (hasil dari auth_check.php)
        // Jika tidak ada, gunakan NULL
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        // "ssssi" berarti 4 parameter string dan 1 parameter integer
        $stmt->bind_param("ssssi", $kode_kegiatan, $program, $sub_program, $nama_kegiatan, $user_id);

        // 4. Eksekusi query dan berikan feedback
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman daftar kegiatan
            header("Location: kegiatan_list.php?status=tambah_sukses"); // Sesuaikan nama file jika perlu
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Gagal menyimpan data: " . $stmt->error;
        }
        
        // Tutup statement
        $stmt->close();

    } else {
        // Jika ada data yang kosong
        echo "Semua kolom (Kode, Program, Sub Program, Nama) wajib diisi.";
    }
} else {
    // Jika halaman diakses langsung tanpa metode POST, redirect
    header("Location: kegiatan_list.php"); // Sesuaikan nama file jika perlu
    exit;
}

// Tutup koneksi database
$conn->close();
?>