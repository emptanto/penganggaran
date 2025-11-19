<?php
define('BASE_URL', '/rkas/');

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php';

$userId = $_SESSION['user_id'] ?? 0;
$permissions = [];

if ($userId) {
    $stmt = $conn->prepare("SELECT menu_key, allowed FROM user_access WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $permissions[$row['menu_key']] = (bool)$row['allowed'];
    }
}