
<?php
session_start();

// Admin check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Admin check
if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

// define esc() only if it does not exist
if (!function_exists('esc')) {
    function esc($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $duty  = trim($_POST['duty'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validation
    if ($name === '')  $errors[] = 'Name is required.';
    if ($duty === '')  $errors[] = 'Duty is required.';
    if ($email === '') $errors[] = 'Email is required.';

    // Insert into DB
    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO staff (name, duty, phone, email) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $duty, $phone, $email);

        if ($stmt->execute()) {
            $success = true;
            //Log the action
            $description = "Added staff: " . $name;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Add', 'Staff', $description, $user);

        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<h2>Add Staff</h2>

<?php if ($success): ?>
    <p class="success">
        Staff added successfully. 
        <a href="staff.php">Back to list</a>
    </p>
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
    <label for="name">Name</label><br>
    <input type="text" id="name" name="name" value="<?= esc($_POST['name'] ?? '') ?>" required><br><br>

    <label for="duty">Duty</label><br>
    <input type="text" id="duty" name="duty" value="<?= esc($_POST['duty'] ?? '') ?>" required><br><br>

    <label for="phone">Phone</label><br>
    <input type="text" id="phone" name="phone" value="<?= esc($_POST['phone'] ?? '') ?>"><br><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" value="<?= esc($_POST['email'] ?? '') ?>" required><br><br>

    <button class="btn" type="submit">Add Staff</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
