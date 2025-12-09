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

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $speciestype     = trim($_POST['speciestype'] ?? '');
    $scientificname  = trim($_POST['scientificname'] ?? '');
    $diettype        = trim($_POST['diettype'] ?? '');
    $lifespan        = trim($_POST['lifespan'] ?? '');
    $category        = trim($_POST['category'] ?? '');

    // Validation
    if ($speciestype === '') $errors[] = 'Type is required.';
    if ($scientificname === '') $errors[] = 'Scientific name is required.';

    // Insert into DB
    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO species (speciestype, scientificname, diettype, lifespan, category) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $speciestype, $scientificname, $diettype, $lifespan, $category);

        if ($stmt->execute()) {
            $success = true;
            // Log the action
            $description = "Added species: " . $speciestype;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Add', 'Species', $description, $user);
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>


<h2>Add Species</h2>

<?php if ($success): ?>
    <p class="success">
        Species added successfully. 
        <a href="species.php">Back to list</a>
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

    <label for="speciestype">Type</label><br>
    <input type="text" id="speciestype" name="speciestype" value="<?= esc($_POST['speciestype'] ?? '') ?>" required><br><br>

    <label for="scientificname">Scientific Name</label><br>
    <input type="text" id="scientificname" name="scientificname" value="<?= esc($_POST['scientificname'] ?? '') ?>" required><br><br>

    <label for="diettype">Diet Type</label><br>
    <input type="text" id="diettype" name="diettype" value="<?= esc($_POST['diettype'] ?? '') ?>"><br><br>

    <label for="lifespan">Lifespan</label><br>
    <input type="text" id="lifespan" name="lifespan" value="<?= esc($_POST['lifespan'] ?? '') ?>"><br><br>

    <label for="category">Category</label><br>
    <input type="text" id="category" name="category" value="<?= esc($_POST['category'] ?? '') ?>"><br><br>

    <button class="btn" type="submit">Add Species</button>

</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
