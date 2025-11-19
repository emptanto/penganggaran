<?php
require_once __DIR__ . '/config/db.php';

// Pastikan tabel role_access ada
$conn->query("
CREATE TABLE IF NOT EXISTS role_access (
    role VARCHAR(50) NOT NULL,
    menu_key VARCHAR(100) NOT NULL,
    allowed TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (role, menu_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Ambil semua data dari user_access
$sql = "
SELECT ua.menu_key, ua.allowed, u.role
FROM user_access ua
JOIN users u ON ua.user_id = u.id
";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $insertStmt = $conn->prepare("
        INSERT INTO role_access (role, menu_key, allowed)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE allowed = VALUES(allowed)
    ");

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $role = $row['role'];
        $menu_key = $row['menu_key'];
        $allowed = (int) $row['allowed'];

        $insertStmt->bind_param("ssi", $role, $menu_key, $allowed);
        if ($insertStmt->execute()) {
            $count++;
        }
    }
    echo "Migrasi selesai. Total entri yang dimigrasi: {$count}\n";
} else {
    echo "Tidak ada data di user_access untuk dimigrasi.\n";
}
?>
