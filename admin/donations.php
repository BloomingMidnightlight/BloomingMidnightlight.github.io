<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

$success=false;
$errors=[];

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if ($name==='') $errors[]='Name required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]='Valid email required';
    if ($amount <= 0) $errors[]='Amount must be greater than 0';

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO donations (donor_name, email, amount, donation_date, message) VALUES (?, ?, ?, CURDATE(), ?)');
        $stmt->bind_param('ssds', $name, $email, $amount, $message);
        $stmt->execute();
        $success = true;
    }
}
?>

<h2>Donate</h2>

<?php if($success): ?><p class="success">Thank you for your donation!</p><?php endif; ?>
<?php if($errors): ?><div class="errors"><ul><?php foreach($errors as $e) echo '<li>'.esc($e).'</li>'; ?></ul></div><?php endif; ?>

<form method="post" class="card form-card">
  <label>Name<br><input name="name" required></label>
  <label>Email<br><input name="email" type="email" required></label>
  <label>Amount (USD)<br><input name="amount" type="number" step="0.01" required></label>
  <label>Message<br><textarea name="message" rows="3"></textarea></label>
  <button class="btn" type="submit">Donate</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>