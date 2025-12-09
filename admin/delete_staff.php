<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php'; // logActivity helper
include __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        // 🔎 Fetch staff name before deletion
        $fetch = $conn->prepare('SELECT name FROM staff WHERE staff_id = ?');
        $fetch->bind_param('i', $id);
        $fetch->execute();
        $result = $fetch->get_result();
        $staff = $result->fetch_assoc();
        $staffName = $staff['staffname'] ?? 'Unknown';
        $fetch->close();

        // Check if staff has interactions
        $check = $conn->prepare('SELECT COUNT(*) AS cnt FROM interactions WHERE staff_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $res = $check->get_result()->fetch_assoc();

        if ($res['cnt'] > 0) {
            die("Cannot delete staff: they have interactions assigned.");
        }

        // Staff has no interactions, safe to delete
        $stmt = $conn->prepare('DELETE FROM staff WHERE staff_id = ?');
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // ✅ Log deletion
            $description = "Deleted staff: " . $staffName . " (ID: " . $id . ")";
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'delete', 'Staff', $description, $user);
        }
    }
}

// Redirect back to staff list
header('Location: /MY-APP/updatedzoodb/zoo-site/admin/staff.php');
exit;
?>