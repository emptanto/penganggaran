<?php
// File: views/layouts/flash_messages.php

// Cek apakah ada pesan sukses di session
if (isset($_SESSION['success_message'])) {
    // Tampilkan pesan dengan gaya Bootstrap (alert sukses berwarna hijau)
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo '<strong>Sukses!</strong> ' . htmlspecialchars($_SESSION['success_message']);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    
    // Hapus pesan dari session agar tidak tampil lagi saat halaman di-refresh
    unset($_SESSION['success_message']);
}

// Cek apakah ada pesan error di session
if (isset($_SESSION['error_message'])) {
    // Tampilkan pesan dengan gaya Bootstrap (alert error berwarna merah)
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<strong>Error!</strong> ' . htmlspecialchars($_SESSION['error_message']);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    
    // Hapus pesan dari session agar tidak tampil lagi
    unset($_SESSION['error_message']);
}
?>