<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    // Not an admin: redirect or show message
    echo '<p>Access denied. Admins only.</p>';
    exit;
}
?>

<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo '<p>Invalid ID</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// fetch current animal
$stmt = $conn->prepare('SELECT * FROM animals WHERE animal_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$animal = $res->fetch_assoc();
if (!$animal) {
    echo '<p>Not found</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// fetch species and habitats for dropdowns
$species_stmt = $conn->prepare('SELECT species_id, speciestype FROM species ORDER BY speciestype');
$species_stmt->execute();
$species_res = $species_stmt->get_result();

$habitat_stmt = $conn->prepare('SELECT habitat_id, habitatname FROM habitats ORDER BY habitatname');
$habitat_stmt->execute();
$habitat_res = $habitat_stmt->get_result();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $species_id = intval($_POST['species_id'] ?? 0);
    $habitat_id = intval($_POST['habitat_id'] ?? 0);
    $environment = trim($_POST['environment'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = in_array($_POST['gender'] ?? '', ['Male', 'Female', 'Unknown']) ? $_POST['gender'] : 'Unknown';
    $arrivedon = $_POST['arrivedon'] ?? '';
    $photo_url = $animal['photo_url']; // default to old photo

    // Handle file upload
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        if (!is_dir(__DIR__ . '/uploads'))
            mkdir(__DIR__ . '/uploads');
        $filename = basename($_FILES['image']['name']);
        $target_path = "uploads/$filename";

        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/' . $target_path)) {
            $photo_url = $target_path;
        } else {
            $errors[] = 'Failed to upload the photo.';
        }
    }

    // Validation
    if ($name === '') $errors[] = 'Name is required.';
    if ($species_id <= 0) $errors[] = 'Please select a species.';
    if ($habitat_id <= 0) $errors[] = 'Please select a habitat.';
    if ($dob === '') $errors[] = 'Date of birth is required.';
    if ($arrivedon === '') $errors[] = 'Arrival date is required.';
}
    if (empty($errors)) {
        $update = $conn->prepare('UPDATE animals 
            SET commonname=?, species_id=?, habitat_id=?, environment=?, dob=?, gender=?, arrivedon=?, photo_url=? 
            WHERE animal_id=?');
        $update->bind_param('siisssssi', $name, $species_id, $habitat_id, $environment, $dob, $gender, $arrivedon, $photo_url, $id);
    
        if ($update->execute()) {
            $success = true;
    
            // Log the update action
            $description = "Updated animal: " . $name . " (ID: " . $id . ")";
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'update', 'Animal', $description, $user);
    
            // Refresh animal data
            $stmt->execute();
            $animal = $stmt->get_result()->fetch_assoc();
        } else {
            $errors[] = 'Database error: ' . $update->error;
        }
    }
    
?>

<h2>Edit Animal</h2>

<?php if($success): ?>
  <p class="success">Updated successfully.</p>
<?php endif; ?>

<?php if($errors): ?>
    <div class="errors">
        <ul>
            <?php foreach($errors as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" class="card form-card" enctype="multipart/form-data">

<label>Name<br>
<input type="text" name="name" value="<?= esc($animal['commonname']) ?>" required>
</label><br>

<label>Species<br>
    <select name=" species_id" required>
        <option value="">-- choose --</option>
        <?php while ($s = $species_res->fetch_assoc()): ?>
            <option value="<?= $s['species_id'] ?>" <?= $s['species_id'] == $animal['species_id'] ? 'selected' : '' ?>><?= esc($s['speciestype']) ?></option>
        <?php endwhile; ?>
    </select>
</label><br>

<label>Habitat<br>
    <select name="habitat_id" required>
        <option value="">-- choose --</option>
        <?php while ($h = $habitat_res->fetch_assoc()): ?>
            <option value="<?= $h['habitat_id'] ?>" <?= $h['habitat_id'] == $animal['habitat_id'] ? 'selected' : '' ?>><?= esc($h['habitatname']) ?></option>
        <?php endwhile; ?>
    </select>
</label><br>

   <label>Environment<br>
   <select name="environment">
       <option value="">-- choose --</option>
       <option value="Forest" <?= $animal['environment']=='Forest'?'selected':'' ?>>Forest</option>
       <option value="Grasslands" <?= $animal['environment']=='Grasslands'?'selected':'' ?>>Grasslands</option>
       <option value="Desert" <?= $animal['environment']=='Desert'?'selected':'' ?>>Desert</option>
       <option value="Mountains" <?= $animal['environment']=='Mountains'?'selected':'' ?>>Mountains</option>
       <option value="Wetlands" <?= $animal['environment']=='Wetlands'?'selected':'' ?>>Wetlands</option>
   </select>
</label><br>

<label>Date of Birth<br><input type="date" name="dob" value="<?= esc($animal['dob']) ?>" required></label><br>

<label>Gender<br>
    <select name="gender">
        <option value="Unknown" <?= $animal['gender'] == 'Unknown' ? 'selected' : '' ?>>Unknown</option>
            <option value="Male" <?= $animal['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $animal['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
</label><br>

<label>Arrived On<br>
    <input type="date" name="arrivedon" value="<?= esc($animal['arrivedon']) ?>" required>
</label><br>

<label>Photo<br>
    <input type="file" name="image"><br>
    <small>Leave empty to keep current photo.</small><br>
    <?php if(!empty($animal['photo_url'])): ?>
        Current photo:<br>
        <img src="<?= esc($animal['photo_url']) ?>" alt="Current photo" style="max-width:150px;margin-top:5px;">
    <?php endif; ?>
</label><br>

<button class="btn" type="submit">Save Changes</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
