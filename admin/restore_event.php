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
    $stmt = $conn->prepare("UPDATE events SET status='active' WHERE event_id=?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $user = $_SESSION['admin_username'];
        logActivity($conn, 'Restore', 'Event', "Restored event ID: $id", $user);
    }
}
header('Location: archives.php?view=events');
exit;
?>