<?php
session_start();
require 'config/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "Semua kolom wajib diisi.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Konfirmasi password tidak cocok.";
    }

    // Cek username sudah ada atau belum
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Username sudah digunakan.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            header("Location: register.php?register=success");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data: " . $conn->error;
        }
    }

    $_SESSION['register_errors'] = $errors;
    header("Location: register_baru.php");
    exit;
} else {
    header("Location: register_baru.php");
    exit;
}
