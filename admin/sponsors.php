<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Handle archive request (only if logged in)
if (isset($_SESSION['admin_username']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_id'])) {
    $id = intval($_POST['archive_id']);
    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE sponsors SET is_active = 0 WHERE sponsor_id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $description = "Archived sponsor ID: " . $id;
            $user = $_SESSION['admin_username'];
            logActivity($conn, 'update', 'Sponsor', $description, $user);
        }
    }
}

// Determine filter (default active)
$showArchived = isset($_GET['archived']) && $_GET['archived'] == 1;
$sql = $showArchived ? "SELECT * FROM sponsors WHERE is_active = 0" : "SELECT * FROM sponsors WHERE is_active = 1";
$result = $conn->query($sql);
?>
<h2>Sponsors</h2>
<div class="filter-toggle">
    <a href="sponsors.php">Show Active</a> |
    <a href="sponsors.php?archived=1">Show Archived</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Sponsor Name</th>
            <th>Animal ID</th>
            <th>Animal Name</th>
            <th>Sponsor Plan</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['sponsor_id'] ?></td>
                <td><?= $row['sponsorname'] ?></td>
                <td><?= $row['animal_id'] ?></td>
                <td><?= $row['animalname'] ?></td>
                <td><?= $row['sponsorplan'] ?></td>
                <td>
                    <?php if (isset($_SESSION['admin_username']) && !$showArchived): ?>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="archive_id" value="<?= $row['sponsor_id'] ?>">
                            <button type="submit" class="btn-small">Archive</button>
                        </form>
                    <?php else: ?>
                        <!-- No archive option for logged-out users -->
                        <span class="text-muted">View Only</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>
