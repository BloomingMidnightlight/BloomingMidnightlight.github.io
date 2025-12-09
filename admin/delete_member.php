<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php'; // ✅ logActivity helper
include __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        // 🔎 Fetch member name before deletion
        $fetch = $conn->prepare("SELECT membername FROM members WHERE member_id=?");
        $fetch->bind_param('i', $id);
        $fetch->execute();
        $result = $fetch->get_result();
        $member = $result->fetch_assoc();
        $memberName = $member['membername'] ?? 'Unknown';
        $fetch->close();

        // ✅ Delete member
        $stmt = $conn->prepare("DELETE FROM members WHERE member_id=?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // ✅ Log deletion
            $description = "Deleted member: " . $memberName . " (ID: " . $id . ")";
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'delete', 'Member', $description, $user);
        }
    }
}

// redirect back to members page
header('Location: /MY-APP/updatedzoodb/zoo-site/admin/members.php');
exit;
?>