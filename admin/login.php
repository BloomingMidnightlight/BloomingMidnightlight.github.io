<?php
// Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
if (session_status() === PHP_SESSION_NONE)
  session_start();

// Include DB and functions
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';

// Initialize error message
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($username && $password) {
    $stmt = $conn->prepare("SELECT admin_id, password FROM admins WHERE username=? LIMIT 1");
    if (!$stmt) {
      die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      if (password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_username'] = $username;
        header("Location: /MY-APP/updatedzoodb/zoo-site/admin/index.php");
        exit;
      }
    }

    $err = "Invalid username or password.";
  } else {
    $err = "Please enter username and password.";
  }
}

// Include header
include __DIR__ . '/../includes/header.php';
?>

<main class="admincontainer">
  <section class="login-hero">
    <h1>Admin Login</h1>
    <p>Access the Safari Kingdom Zoo management panel. Please enter your credentials below.</p>
  </section>

  <section class="login-form-section">
    <?php if ($err): ?>
      <p class="login-error"><?= esc($err) ?></p>
    <?php endif; ?>

    <form method="post" class="login-form">
      <label>Username
        <input type="text" name="username" required>
      </label>
      <label>Password
        <input type="password" name="password" required>
      </label>
      <button type="submit" class="btn-login">Login</button>
    </form>
  </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>