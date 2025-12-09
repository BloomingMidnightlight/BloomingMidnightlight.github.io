<?php
session_start();
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Admin check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo '<p>Invalid Habitat ID</p>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Fetch current habitat
$stmt = $conn->prepare('SELECT * FROM habitats WHERE habitat_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$habitat = $res->fetch_assoc();
if (!$habitat) {
    echo '<p>Habitat not found</p>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');

    if ($name === '')
        $errors[] = 'Name is required.';
    if ($location === '')
        $errors[] = 'Location is required.';

    if (empty($errors)) {
        $update = $conn->prepare('UPDATE habitats SET habitatname=?, location=? WHERE habitat_id=?');
        $update->bind_param('ssi', $name, $location, $id);
        $update->execute();
        $success = true;

        // Log the action (use $name instead of undefined $habitatname)
        $description = "Edited habitat: " . $name;
        $user = $_SESSION['admin_username'] ?? 'System';
        logActivity($conn, 'Edit', 'Habitat', $description, $user);

        // Refresh data
        $stmt->execute();
        $habitat = $stmt->get_result()->fetch_assoc();
    }
}
?>

<h2>Edit Habitat</h2>

<?php if ($success): ?>
    <p class="success">Updated successfully.</p>
<?php endif; ?>

<?php if ($errors): ?>
    <div class="errors">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" class="card form-card">

<label>
    <div>Name</div>
    <input type="text" name="name" value="<?= esc($habitat['habitatname']) ?>" required>
</label>

<label>
    <div>Location</div>
    <select name="location" required>
        <option value="">-- Select Location --</option>
        <option value="North"   <?= $habitat['location']=='North' ? 'selected' : '' ?>>North</option>
        <option value="South"   <?= $habitat['location']=='South' ? 'selected' : '' ?>>South</option>
        <option value="East"    <?= $habitat['location']=='East' ? 'selected' : '' ?>>East</option>
        <option value="West"    <?= $habitat['location']=='West' ? 'selected' : '' ?>>West</option>
        <option value="Central" <?= $habitat['location']=='Central' ? 'selected' : '' ?>>Central</option>
    </select>
</label>
<br>

<button class="btn" type="submit">Save Changes</button>

</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>