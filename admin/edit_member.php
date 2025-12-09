<?php
session_start();
if(!isset($_SESSION['admin_username'])){
    die("Access denied. Admins only.");
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php'; // DO NOT redeclare esc()
include __DIR__ . '/../includes/auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<p>Invalid member ID</p>";
    include __DIR__ . '/includes/footer.php';
    exit;
}

$stmt = $conn->prepare("SELECT * FROM members WHERE member_id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
if (!$member) {
    echo "<p>Member not found</p>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['membername'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $membershiptype = trim($_POST['membershiptype'] ?? '');
    $membershipperiod = trim($_POST['membershipperiod'] ?? '');

    if ($name === '') $errors[] = 'Name is required';
    if ($email === '') $errors[] = 'Email is required';

    if (empty($errors)) {
        $update = $conn->prepare("UPDATE members SET membername=?, email=?, phone=?, membershiptype=?, membershipperiod=? WHERE member_id=?");
        $update->bind_param('sssssi', $name, $email, $phone, $membershiptype, $membershipperiod, $id);
        if ($update->execute()) {
          $success = true;
          // Log the action
          $description = "Edited member: " . $name;
          $user = $_SESSION['admin_username'] ?? 'System';
          logActivity($conn, 'Edit', 'Member', $description, $user);

          //Refresh member data
          $stmt->execute();
          $member = $stmt->get_result()->fetch_assoc();
      }
  }
}
?>

<h2>Edit Member</h2>

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

<form method="post" class="card form-card">

<label>
    <div>Name</div>
    <input type="text" name="membername" value="<?= esc($member['membername']) ?>" required>
</label>

<label>
    <div>Email</div>
    <input type="email" name="email" value="<?= esc($member['email']) ?>" required>
</label>

<label>
    <div>Phone</div>
    <input type="text" name="phone" value="<?= esc($member['phone']) ?>">
</label>

<label>
    <div>Membership Type</div>
    <select name="membershiptype" required>
        <option value="">-- Select Type --</option>
        <option value="Basic"    <?= $member['membershiptype']=='Basic' ? 'selected' : '' ?>>Basic</option>
        <option value="Premium"  <?= $member['membershiptype']=='Premium' ? 'selected' : '' ?>>Premium</option>
        <option value="VIP"      <?= $member['membershiptype']=='VIP' ? 'selected' : '' ?>>VIP</option>
        <option value="Family"   <?= $member['membershiptype']=='Family' ? 'selected' : '' ?>>Family</option>
    </select>
</label>

<label>
    <div>Membership Period</div>
    <select name="membershipperiod" required>
        <option value="">-- Select Period --</option>
        <option value="1 Month"   <?= $member['membershipperiod']=='1 Month' ? 'selected' : '' ?>>1 Month</option>
        <option value="3 Months"  <?= $member['membershipperiod']=='3 Months' ? 'selected' : '' ?>>3 Months</option>
        <option value="6 Months"  <?= $member['membershipperiod']=='6 Months' ? 'selected' : '' ?>>6 Months</option>
        <option value="12 Months" <?= $member['membershipperiod']=='12 Months' ? 'selected' : '' ?>>12 Months</option>
    </select>
</label>
<br>


<button class="btn" type="submit">Save Changes</button>

</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
