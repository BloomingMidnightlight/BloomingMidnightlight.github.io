<?php
session_start();

// Admin-only access
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
    $name = trim($_POST['membername'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $membershiptype = trim($_POST['membershiptype'] ?? '');
    $membershipperiod = trim($_POST['membershipperiod'] ?? '');
    $joindate = $_POST['joindate'] ?? date('Y-m-d');

    // Validation
    if ($name === '')
        $errors[] = 'Name is required.';
    if ($email === '')
        $errors[] = 'Email is required.';

    // Insert into DB
    if (empty($errors)) {
        $stmt = $conn->prepare('
            INSERT INTO members
            (membername, email, phone, joindate, membershiptype, membershipperiod)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        $stmt->bind_param('ssssss', $name, $email, $phone, $joindate, $membershiptype, $membershipperiod);

        if ($stmt->execute()) {
            $success = true;
            // ✅ Log the action (use $name instead of undefined $membername)
            $description = "Added member: " . $name;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'Add', 'Member', $description, $user);
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<h2>Add Member</h2>

<?php if ($success): ?>
    <p class="success">
        Member added successfully.
        <a href="members.php">Back to list</a>
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

    <label for="membername">Name</label><br>
    <input type="text" id="membername" name="membername" value="<?= esc($_POST['membername'] ?? '') ?>"
        required><br><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" value="<?= esc($_POST['email'] ?? '') ?>" required><br><br>

    <label for="phone">Phone</label><br>
    <input type="text" id="phone" name="phone" value="<?= esc($_POST['phone'] ?? '') ?>"><br><br>

    <label for="joindate">Join Date</label><br>
    <input type="date" id="joindate" name="joindate" value="<?= esc($_POST['joindate'] ?? date('Y-m-d')) ?>"><br><br>

    <label for="membershiptype">Membership Type</label><br>
    <input type="text" id="membershiptype" name="membershiptype" value="<?= esc($_POST['membershiptype'] ?? '') ?>"
        placeholder="e.g., Platinum, Gold"><br><br>

    <label for="membershipperiod">Membership Period</label><br>
    <input type="text" id="membershipperiod" name="membershipperiod"
        value="<?= esc($_POST['membershipperiod'] ?? '') ?>" placeholder="e.g., One year, Six months"><br><br>

    <button class="btn" type="submit">Add Member</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>