<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['sponsorname'] ?? '');
    $plan = trim($_POST['sponsorplan'] ?? '');

    if ($name === '')
        $errors[] = 'Sponsor name is required';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO sponsors (sponsorname, sponsorplan) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $plan);
        if ($stmt->execute()) {
            $success = true;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Add', 'Sponsor', "Added sponsor: $sponsorname", $user);
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>
<h2>Add Sponsor</h2>
<?php if ($success): ?>
    <p class="success">Sponsor added successfully.</p><?php endif; ?>
<form method="post">
    <label>Name <input type="text" name="sponsorname" required></label><br>
    <label>Plan <input type="text" name="sponsorplan"></label><br>
    <button type="submit">Add Sponsor</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>