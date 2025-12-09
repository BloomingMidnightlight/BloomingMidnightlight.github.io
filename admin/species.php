<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Allowed sorting
$allowed_sorts = ['speciestype', 'scientificname', 'diettype', 'category'];
$sort = 'speciestype'; // default

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts)) {
  $sort = $_GET['sort'];
}

// Map sort to column name
switch ($sort) {
  case 'scientificname':
    $order_sql = 'scientificname';
    break;
  case 'diettype':
    $order_sql = 'diettype';
    break;
  case 'category':
    $order_sql = 'category';
    break;
  default:
    $order_sql = 'speciestype';
}

$stmt = $conn->prepare("SELECT * FROM species ORDER BY $order_sql COLLATE utf8mb4_general_ci");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="species-page">
  <h2>Species</h2>

  <div class="toolbar">
    <div>Sort:
      <a href="?sort=speciestype">Type</a> |
      <a href="?sort=scientificname">Scientific Name</a> |
      <a href="?sort=diettype">Diet Type</a> |
      <a href="?sort=category">Category</a>
    </div>

    <?php if (isset($_SESSION['admin_username'])): ?>
      <div>
        <a class="action-link add" href="/MY-APP/updatedzoodb/zoo-site/admin/add_species.php">+ Add Species</a>
      </div>
    <?php endif; ?>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Scientific Name</th>
        <th>Diet Type</th>
        <th>Lifespan</th>
        <th>Category</th>
        <?php if (isset($_SESSION['admin_username'])): ?>
          <th>Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= esc($row['species_id']) ?></td>
          <td><?= esc($row['speciestype']) ?></td>
          <td><?= esc($row['scientificname']) ?></td>
          <td><?= esc($row['diettype']) ?></td>
          <td><?= esc($row['lifespan']) ?></td>
          <td><?= esc($row['category']) ?></td>
          <?php if (isset($_SESSION['admin_username'])): ?>
            <td>
              <a class="action-link edit"
                href="/MY-APP/updatedzoodb/zoo-site/admin/edit_species.php?id=<?= $row['species_id'] ?>">Edit</a>
              <form class="inline-form" method="post" action="/MY-APP/updatedzoodb/zoo-site/admin/delete_species.php"
                onsubmit="return confirm('Delete this species?');">
                <input type="hidden" name="id" value="<?= $row['species_id'] ?>">
                <button class="action-link delete" type="submit">Delete</button>
              </form>
            </td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>