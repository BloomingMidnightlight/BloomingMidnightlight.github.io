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


// define esc() if not exists
if (!function_exists('esc')) {
    function esc($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = 'Name is required.';
    }
    if ($location === '') {
        $errors[] = 'Location is required.';
    }

    // Insert into DB
    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO habitats (habitatname, location) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $location);

        if ($stmt->execute()) {
            $success = true;
            // Log the action (use $name instead of undefined $habitatname)
            $description = "Added habitat: " . $name;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Add', 'Habitat', $description, $user);
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<h2>Add Habitat</h2>

<?php if ($success): ?>
    <p class="success">
        Habitat added successfully.
        <a href="habitats.php">Back to list</a>
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

    <label for="location">Location</label><br>
    <input type="text" id="location" name="location" value="<?= esc($_POST['location'] ?? '') ?>" required><br><br>

    <button class="btn" type="submit">Add Habitat</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>