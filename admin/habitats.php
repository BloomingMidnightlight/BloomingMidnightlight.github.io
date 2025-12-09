<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// optional sorting
$allowed_sorts = ['name', 'location'];
$sort = 'name';
if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts)) {
  $sort = $_GET['sort'];
}

// map sorting to database columns
$order_sql = match ($sort) {
  'location' => 'location',
  default => 'habitatname'
};

$stmt = $conn->prepare("SELECT * FROM habitats ORDER BY $order_sql COLLATE utf8mb4_general_ci");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="habitats-page">
  <h2>Habitats</h2>

  <div class="toolbar">
    <div>Sort:
      <a href="?sort=name">Name</a> |
      <a href="?sort=location">Location</a>
    </div>
    <?php if (isset($_SESSION['admin_username'])): ?>
      <div>
        <a class="action-link add" href="/MY-APP/updatedzoodb/zoo-site/admin/add_habitat.php">+ Add Habitat</a>
      </div>
    <?php endif; ?>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Location</th>
        <?php if (isset($_SESSION['admin_username'])): ?>
          <th>Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= esc($row['habitat_id']) ?></td>
          <td><?= esc($row['habitatname']) ?></td>
          <td><?= esc($row['location']) ?></td>
          <?php if (isset($_SESSION['admin_username'])): ?>
            <td>
              <a class="action-link edit"
                href="/MY-APP/updatedzoodb/zoo-site/admin/edit_habitat.php?id=<?= $row['habitat_id'] ?>">Edit</a>
              <form class="inline-form" method="post" action="/MY-APP/updatedzoodb/zoo-site/admin/delete_habitat.php"
                onsubmit="return confirm('Delete this habitat?');">
                <input type="hidden" name="id" value="<?= $row['habitat_id'] ?>">
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