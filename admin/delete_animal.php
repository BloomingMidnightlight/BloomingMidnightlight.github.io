<?php
session_start();
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/auth.php';
include __DIR__ . '/../includes/functions.php'; // ✅ ensure logActivity() is available

// Admin-only check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        // 🔎 First fetch the animal name before deletion
        $fetch = $conn->prepare('SELECT commonname FROM animals WHERE animal_id = ?');
        $fetch->bind_param('i', $id);
        $fetch->execute();
        $result = $fetch->get_result();
        $animal = $result->fetch_assoc();
        $animalName = $animal['commonname'] ?? 'Unknown';
        $fetch->close();

        // ✅ Perform the deletion
        $stmt = $conn->prepare('DELETE FROM animals WHERE animal_id = ?');
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // ✅ Log the deletion with name + ID
            $description = "Deleted animal: " . $animalName . " (ID: " . $id . ")";
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'delete', 'Animal', $description, $user);
        }
    }
}

// Redirect back
header('Location: /MY-APP/updatedzoodb/zoo-site/admin/animals.php');
exit;
?>