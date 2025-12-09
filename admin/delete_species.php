<?php
session_start();
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/auth.php';
include __DIR__ . '/../includes/functions.php'; // ✅ logActivity helper

// Admin-only check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        // Optional: check foreign key constraints first
        $check = $conn->prepare('SELECT * FROM animals WHERE species_id = ? LIMIT 1');
        $check->bind_param('i', $id);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            die("Cannot delete: This species is assigned to an animal.");
        }

        // Get species name for logging
        $nameStmt = $conn->prepare('SELECT speciestype FROM species WHERE species_id = ?');
        $nameStmt->bind_param('i', $id);
        $nameStmt->execute();
        $nameRes = $nameStmt->get_result();
        $speciesName = $nameRes->fetch_assoc()['speciestype'] ?? 'Unknown';

        $stmt = $conn->prepare('DELETE FROM species WHERE species_id = ?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            // ✅ Log the action
            $description = "Deleted species: " . $speciesName;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Delete', 'Species', $description, $user);
        }
    }
}

// Redirect back
header('Location: /MY-APP/updatedzoodb/zoo-site/admin/species.php');
exit;
?>
