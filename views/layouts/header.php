<?php
// File: views/layouts/header.php (Versi Sempurna)

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/menus.php'; // Memuat $allMenus

// Dapatkan nama file dari halaman yang sedang diakses
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$role = $_SESSION['role'] ?? 'guest'; // Beri nilai default 'guest'

// Logika untuk mengambil hak akses menu
$user_access = [];
if ($role === 'superadmin') {
    // Superadmin bisa akses semua, kita tandai dengan array kosong saja
    // Fungsi hasAccess akan menanganinya
} else if ($role !== 'guest') {
    // Ambil dari DB jika bukan guest
    global $conn; // Ambil koneksi DB dari scope global
    $stmt = $conn->prepare("SELECT menu_key FROM role_access WHERE role = ? AND allowed = 1");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $user_access[$row['menu_key']] = true;
    }
    $stmt->close();
}

function hasAccess(string $key): bool {
    global $role, $user_access;
    if ($role === 'superadmin') return true;
    return isset($user_access[$key]);
}

function renderMenu(array $menus, string $currentPage): void {
    foreach ($menus as $key => $menu) {
        if (!hasAccess($key)) continue;

        $activeClass = (basename($menu['url']) === $currentPage) ? 'active' : '';
        echo '<li class="nav-item">';
        echo '<a class="nav-link ' . $activeClass . '" href="' . htmlspecialchars($menu['url']) . '">' . htmlspecialchars($menu['label']) . '</a>';
        echo '</li>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Penganggaran App</title>
    <link rel="icon" href="favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" /> -->
    <link rel="stylesheet" href="assets/css/custom.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>dashboard.php">Penganggaran App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php renderMenu($allMenus, $currentPage); ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?php echo BASE_URL; ?>logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>