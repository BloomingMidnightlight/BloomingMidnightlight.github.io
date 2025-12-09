<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';
?>

<link rel="stylesheet" href="..assets/css/admin.css">

<?php
$errors = [];
$success = false;

// Fetch species list
$species_stmt = $conn->prepare('SELECT species_id, speciestype FROM species ORDER BY speciestype');
$species_stmt->execute();
$species_res = $species_stmt->get_result();

// Fetch habitats list
$habitat_stmt = $conn->prepare('SELECT habitat_id, habitatname FROM habitats ORDER BY habitatname');
$habitat_stmt->execute();
$habitat_res = $habitat_stmt->get_result();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $species_id = intval($_POST['species_id'] ?? 0);
    $habitat_id = intval($_POST['habitat_id'] ?? 0);
    $environment = trim($_POST['environment'] ?? '');
    $dob = $_POST['dob'] ?? null;
    $gender = in_array($_POST['gender'] ?? '', ['Male', 'Female', 'Unknown']) ? $_POST['gender'] : 'Unknown';
    $arrivedon = $_POST['arrivedon'] ?? null;
    $photo_url = trim($_POST['photo_url'] ?? '');

    // Validation
    if ($name === '')
        $errors[] = 'Name is required.';
    if ($species_id <= 0)
        $errors[] = 'Please select a species.';
    if ($habitat_id <= 0)
        $errors[] = 'Please select a habitat.';
    if ($dob === '')
        $errors[] = 'Date of birth is required.';
    if ($arrivedon === '')
        $errors[] = 'Arrival date is required.';

    if (empty($errors)) {
        $stmt = $conn->prepare('
            INSERT INTO animals 
            (commonname, species_id, habitat_id, environment, dob, gender, arrivedon, photo_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $stmt->bind_param(
            'siisssss',
            $name,
            $species_id,
            $habitat_id,
            $environment,
            $dob,
            $gender,
            $arrivedon,
            $photo_url
        );

        if ($stmt->execute()) {
            $success = true;

            $description = "Added animal: " . $name;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'add', 'Animal', $description, $user);

        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<div class="form-container">
    <h2>Add Animal</h2>

    <?php if ($success): ?>
        <p class="success">
            Animal added successfully.
            <a href="animals.php">Back to list</a>
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

    <form method="post">

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= esc($_POST['name'] ?? '') ?>" required>

        <label for="species_id">Species</label>
        <select id="species_id" name="species_id" required>
            <option value="">-- choose --</option>
            <?php while ($s = $species_res->fetch_assoc()): ?>
                <option value="<?= $s['species_id'] ?>" <?= (($_POST['species_id'] ?? '') == $s['species_id']) ? 'selected' : '' ?>>
                    <?= esc($s['speciestype']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="habitat_id">Habitat</label>
        <select id="habitat_id" name="habitat_id" required>
            <option value="">-- choose --</option>
            <?php while ($h = $habitat_res->fetch_assoc()): ?>
                <option value="<?= $h['habitat_id'] ?>" <?= (($_POST['habitat_id'] ?? '') == $h['habitat_id']) ? 'selected' : '' ?>>
                    <?= esc($h['habitatname']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="environment">Environment</label>
        <input type="text" id="environment" name="environment" value="<?= esc($_POST['environment'] ?? '') ?>">

        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?= esc($_POST['dob'] ?? '') ?>" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="Unknown" <?= (($_POST['gender'] ?? '') == 'Unknown') ? 'selected' : '' ?>>Unknown</option>
            <option value="Male" <?= (($_POST['gender'] ?? '') == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (($_POST['gender'] ?? '') == 'Female') ? 'selected' : '' ?>>Female</option>
        </select>

        <label for="arrivedon">Arrived On</label>
        <input type="date" id="arrivedon" name="arrivedon" value="<?= esc($_POST['arrivedon'] ?? '') ?>" required>

        <label for="photo_url">Photo URL</label>
        <input type="url" id="photo_url" name="photo_url" placeholder="/assets/images/your.jpg"
            value="<?= esc($_POST['photo_url'] ?? '') ?>">

        <button class="btn" type="submit">Add Animal</button>

    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>