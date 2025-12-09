<?php
session_start();
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

if (!isset($_SESSION['admin_username'])) {
    die("Access denied.");
}

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("UPDATE sponsors SET is_active = 0 WHERE sponsor_id = ?");
    $stmt->bind_param('i', $id);
    if ($update->execute()) {
        $user = $_SESSION['admin_username'] ?? 'System';
        logActivity($conn, 'Archive', 'Sponsor', "Archived sponsor: $sponsorname", $user);
    }
}
header('Location: sponsors.php');
exit;
?>