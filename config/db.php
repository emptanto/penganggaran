<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host     = $_SERVER['HTTP_HOST'];

// Tentukan nama folder proyek Anda di sini (diawali dengan /)
// Pastikan namanya sama persis dengan nama folder di C:\laragon\www\
define('PROJECT_FOLDER', '/rkas'); 

define('BASE_URL', $protocol . "://" . $host . PROJECT_FOLDER . '/');

$host = 'localhost';
$db   = 'penganggaran_db';
$user = 'root'; // ganti jika berbeda
$pass = '';     // ganti jika ada password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

?>