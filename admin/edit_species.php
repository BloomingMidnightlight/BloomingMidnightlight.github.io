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

// Get species ID
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo '<p>Invalid ID</p>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}
$type_q = $conn->query("SELECT DISTINCT speciestype FROM species ORDER BY speciestype");
$all_types = [];
while ($row = $type_q->fetch_assoc()) {
    $all_types[] = $row['speciestype'];
}

// Fetch current species
$stmt = $conn->prepare('SELECT * FROM species WHERE species_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$species = $res->fetch_assoc();

if (!$species) {
    echo '<p>Species not found.</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $speciestype = trim($_POST['speciestype'] ?? '');
    $scientific = trim($_POST['scientificname'] ?? '');
    $diet = trim($_POST['diettype'] ?? '');
    $lifespan = trim($_POST['lifespan'] ?? '');
    $category = trim($_POST['category'] ?? '');

    // Validation
    if ($speciestype === '') $errors[] = 'Type is required.';
    if ($scientific === '') $errors[] = 'Scientific name is required.';



    if (empty($errors)) {
        $update = $conn->prepare('UPDATE species SET speciestype=?, scientificname=?, diettype=?, lifespan=?, category=? WHERE species_id=?');
        $update->bind_param('sssssi', $speciestype, $scientific, $diet, $lifespan, $category, $id);


        $update->execute();
        $success = true;
        // Log the action
        $description = "Edited species: " . $speciestype;
        $user = $_SESSION['admin_username'] ?? 'System';
        logActivity($conn, 'Edit', 'Species', $description, $user);

        // Refresh data
        $stmt->execute();
        $species = $stmt->get_result()->fetch_assoc();
    }
}
?>

<h2>Edit Species</h2>

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

<label>Type<br>
<select name="speciestype" required>
<?php foreach ($all_types as $t): ?>
        <option value="<?= esc($t) ?>" <?= ($t === $species['speciestype']) ? 'selected' : '' ?>>
            <?= esc($t) ?>
        </option>
    <?php endforeach; ?>
</select>
</label><br>
<label>Scientific Name<br>
    <select name="scientificname" required>
        <option value="">-- choose --</option>
        <?php
        $scientificNames = [
            "Gorilla Gorilla","Vultur Gryphus","Vicugna Pacos","Lycalopex Culpaeus",
            "Equus Quagga","Panthera Onca","Myrmecophaga Tridactyla","Panthera Leo",
            "Giraffa","Connochaetes","Sula nebouxii","Spheniscus Humboldti",
            "Larosterna Inca","Pelecanus Thagus","Otaria Flavescens","Rupicola Peruvianus",
            "Lagothrix Flavicauda","Dermochelys Coriacea","Eunectes Murinus","Melanosuchus Niger",
            "Hydrochoerus hydrochaeris","Cavia Porcellus","Hippopotamus Amphibius","Puma Concolor"
        ];
        foreach($scientificNames as $sn):
        ?>
            <option value="<?= $sn ?>" <?= $species['scientificname']==$sn?'selected':'' ?>><?= $sn ?></option>
        <?php endforeach; ?>
    </select>
</label><br>

<label>Diet Type<br>
    <select name="diettype">
        <option value="">-- choose --</option>
        <?php
        $dietTypes = ["Herbivorous","Carnivorous","Omnivorous","Insectivorous"];
        foreach($dietTypes as $dt):
        ?>
            <option value="<?= $dt ?>" <?= $species['diettype']==$dt?'selected':'' ?>><?= $dt ?></option>
        <?php endforeach; ?>
    </select>
</label><br>

<label>Lifespan<br>
    <select name="lifespan">
        <option value="">-- choose --</option>
        <?php
        $lifespans = ["7 years","10 years","11 years","12 years","14 years","15 years","17 years","20 years","25 years","30 years","40 years","50 years","80 years"];
        foreach($lifespans as $ls):
        ?>
            <option value="<?= $ls ?>" <?= $species['lifespan']==$ls?'selected':'' ?>><?= $ls ?></option>
        <?php endforeach; ?>
    </select>
</label><br>

<label>Category<br>
    <select name="category">
        <option value="">-- choose --</option>
        <?php
        $categories = ["Critically Endangered","Near Threatened","Non-Threatened","Least Concern","Endangered","Vulnerable","Conservation Dependent"];
        foreach($categories as $cat):
        ?>
            <option value="<?= $cat ?>" <?= $species['category']==$cat?'selected':'' ?>><?= $cat ?></option>
        <?php endforeach; ?>
    </select>
</label><br>

<button class="btn" type="submit">Save Changes</button>

</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
