<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Sorting allowed
$allowed_sorts = ['name', 'duty', 'email'];
$sort = 'name';
if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts)) {
  $sort = $_GET['sort'];
}

// Map sorting column
switch ($sort) {
  case 'duty':
    $order_sql = 'duty';
    break;
  case 'email':
    $order_sql = 'email';
    break;
  default:
    $order_sql = 'name';
}

// Query staff table
$stmt = $conn->prepare("SELECT * FROM staff ORDER BY $order_sql COLLATE utf8mb4_general_ci");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="staff-page">
  <h2>Staff</h2>

  <div class="toolbar">
    <div>Sort:
      <a href="?sort=name">Name</a> |
      <a href="?sort=duty">Duty</a> |
      <a href="?sort=email">Email</a>
    </div>
    <?php if (isset($_SESSION['admin_username'])): ?>
      <div>
        <a class="action-link add" href="/MY-APP/updatedzoodb/zoo-site/admin/add_staff.php">+ Add Staff</a>
      </div>
    <?php endif; ?>
  </div>

  <table class="data-table rounded-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Duty</th>
        <th>Phone</th>
        <th>Email</th>
        <?php if (isset($_SESSION['admin_username'])): ?>
          <th>Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= esc($row['staff_id']) ?></td>
          <td><?= esc($row['name']) ?></td>
          <td><?= esc($row['duty']) ?></td>
          <td><?= esc($row['phone']) ?></td>
          <td><?= esc($row['email']) ?></td>
          <?php if (isset($_SESSION['admin_username'])): ?>
            <td>
              <a class="action-link edit"
                href="/MY-APP/updatedzoodb/zoo-site/admin/edit_staff.php?id=<?= $row['staff_id'] ?>">Edit</a>
              <form class="inline-form" method="post" action="/MY-APP/updatedzoodb/zoo-site/admin/delete_staff.php"
                onsubmit="return confirm('Delete this staff member?');">
                <input type="hidden" name="id" value="<?= $row['staff_id'] ?>">
                <button class="action-link delete" type="submit">Delete</button>
              </form>
            </td>
          <?php else: ?>
            <td><span style="color:gray;">Restricted</span></td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>