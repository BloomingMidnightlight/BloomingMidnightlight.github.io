<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Handle archive request (only if logged in)
if (isset($_SESSION['admin_username']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_id'])) {
  $id = intval($_POST['archive_id']);
  if ($id > 0) {
    $stmt = $conn->prepare("UPDATE events SET status = 'archived' WHERE event_id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
      $description = "Archived event ID: " . $id;
      $user = $_SESSION['admin_username'];
      logActivity($conn, 'update', 'Event', $description, $user);
    }
  }
}

// Determine filter (default active)
$showArchived = isset($_GET['archived']) && $_GET['archived'] == 1;
$stmt = $conn->prepare(
  $showArchived 
    ? "SELECT * FROM events WHERE status = 'archived' ORDER BY eventdate DESC" 
    : "SELECT * FROM events WHERE status = 'active' ORDER BY eventdate DESC"
);
$stmt->execute();
$res = $stmt->get_result();
?>
<h2>Events</h2>

<?php if (isset($_SESSION['admin_username'])): ?>
  <div class="add-event">
    <a href="add_event.php" class="btn-add">+ Add Event</a>
  </div>
<?php endif; ?>

<div class="filter-toggle">
  <a href="events.php">Show Active</a> |
  <a href="events.php?archived=1">Show Archived</a>
</div>

<?php while ($e = $res->fetch_assoc()): ?>
  <article class="card">
    <div class="card-header">
      <h3><?= htmlspecialchars($e['eventname']) ?></h3>
    </div>
    <p><?= htmlspecialchars($e['description']) ?></p>
    <p>
      <strong>Date:</strong> <?= htmlspecialchars($e['eventdate']) ?> 
      <strong>Time:</strong> <?= htmlspecialchars($e['eventtime']) ?>
    </p>
    <?php if (isset($_SESSION['admin_username']) && !$showArchived): ?>
      <form method="post" style="margin-top:0.5rem">
        <input type="hidden" name="archive_id" value="<?= $e['event_id'] ?>">
        <button type="submit" class="btn-small">Archive</button>
      </form>
    <?php else: ?>
      <!-- Logged-out users or archived view: no archive option -->
      <?php if (!$showArchived): ?>
        <span class="text-muted">View Only</span>
      <?php endif; ?>
    <?php endif; ?>
  </article>
<?php endwhile; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
