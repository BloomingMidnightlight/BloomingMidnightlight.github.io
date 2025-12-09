<?php
session_start();
if(!isset($_SESSION['admin_username'])){
    die("Access denied. Admins only.");
}
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// define esc() only if it does not exist
if (!function_exists('esc')) {
    function esc($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

// get staff ID from query string
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo '<p>Invalid staff ID</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// fetch staff data
$stmt = $conn->prepare('SELECT * FROM staff WHERE staff_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();

if (!$staff) {
    echo '<p>Staff not found</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$errors = [];
$success = false;

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $duty = trim($_POST['duty'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '') $errors[] = 'Name is required.';
    if ($duty === '') $errors[] = 'Duty is required.';
    if ($email === '') $errors[] = 'Email is required.';

    if (empty($errors)) {
        $update = $conn->prepare('UPDATE staff SET name=?, duty=?, phone=?, email=? WHERE staff_id=?');
        $update->bind_param('ssssi', $name, $duty, $phone, $email, $id);
        $update->execute();
        $success = true;

        // refresh data
        $stmt->execute();
        $staff = $stmt->get_result()->fetch_assoc();
    }
}
?>

<h2>Edit Staff</h2>

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
    <input type="text" name="name" value="<?= esc($staff['name']) ?>" required>
</label>

<label>
    <div>Duty</div>
    <select name="duty" required>
        <option value="">-- Select Duty --</option>
        <option value="Keeper"      <?= $staff['duty']=='Keeper' ? 'selected' : '' ?>>Keeper</option>
        <option value="Veterinarian" <?= $staff['duty']=='Veterinarian' ? 'selected' : '' ?>>Veterinarian</option>
        <option value="Feeder"      <?= $staff['duty']=='Feeder' ? 'selected' : '' ?>>Feeder</option>
        <option value="Cleaner"     <?= $staff['duty']=='Cleaner' ? 'selected' : '' ?>>Cleaner</option>
        <option value="Guide"       <?= $staff['duty']=='Guide' ? 'selected' : '' ?>>Guide</option>
        <option value="Manager"     <?= $staff['duty']=='Manager' ? 'selected' : '' ?>>Manager</option>
    </select>
</label>

<label>
    <div>Phone</div>
    <input type="text" name="phone" value="<?= esc($staff['phone']) ?>">
</label>

<label>
    <div>Email</div>
    <input type="email" name="email" value="<?= esc($staff['email']) ?>" required>
</label>
<br>

<button class="btn" type="submit">Save Changes</button>

</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
