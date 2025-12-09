<?php
// Start session
if (session_status() === PHP_SESSION_NONE)
  session_start();

// Check login
if (!isset($_SESSION['admin_id'])) {
  header('Location: /my-app/zoo-site/login.php');
  exit;
}

// Include header
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/auth.php';
?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>.</p>

<ul>
  <li><a href="animals.php">Manage Animals</a></li>
  <li><a href="add_animal.php">Add Animal</a></li>
  <li><a href="members.php">Manage Members</a></li>
  <li><a href="staff.php">Manage Staff</a></li>
  <li><a href="events.php">Events</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<?php include __DIR__ . '/../includes/footer.php'; ?>