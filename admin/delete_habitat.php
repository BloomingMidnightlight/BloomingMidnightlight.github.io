<?php
session_start();
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Admin check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        // Check if animals are linked
        $check = $conn->prepare('SELECT animal_id FROM animals WHERE habitat_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            echo '<p style="color:red;">Cannot delete this habitat: there are animals linked to it.</p>';
            echo '<p><a href="/my-app/zoo-site/habitats.php">Back to Habitats</a></p>';
            include __DIR__ . '/includes/footer.php';
            exit;
        }

        // Delete habitat
        $stmt = $conn->prepare('DELETE FROM habitats WHERE habitat_id = ?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            header('Location: /MY-APP/updatedzoodb/zoo-site/admin/habitats.php');
            exit;
        } else {
            die("Error deleting habitat: " . $stmt->error);
        }
    }
}

// Redirect if accessed directly
header('Location: /MY-APP/updatedzoodb/zoo-site/admin/habitats.php');
exit;
