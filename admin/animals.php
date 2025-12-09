<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Sorting logic …
$allowed_sorts = ['name', 'species', 'habitat', 'dob'];
$sort = 'name';
if (isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts, true)) {
  $sort = $_GET['sort'];
}
switch ($sort) {
  case 'species': $order_sql = 'species_id'; break;
  case 'habitat': $order_sql = 'habitat_id'; break;
  case 'dob':     $order_sql = 'dob'; break;
  default:        $order_sql = 'commonname';
}
$stmt = $conn->prepare("
    SELECT a.*, s.speciestype, h.habitatname
    FROM animals a
    LEFT JOIN species s ON a.species_id = s.species_id
    LEFT JOIN habitats h ON a.habitat_id = h.habitat_id
    ORDER BY $order_sql
");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="animals-page">
  <h2>Animals</h2>

  <div class="toolbar">
    <div>
      Sort:
      <a href="?sort=name">Name</a> |
      <a href="?sort=species">Species</a> |
      <a href="?sort=habitat">Habitat</a> |
      <a href="?sort=dob">Date of Birth</a>
    </div>
    <div class="view-toggle">
      <button id="toggleView" class="action-link">Switch to Card View</button>
    </div>
    <?php if (isset($_SESSION['admin_username'])): ?>
      <div>
        <a class="action-link add" href="/MY-APP/updatedzoodb/zoo-site/admin/add_animal.php">+ Add Animal</a>
      </div>
    <?php endif; ?>
  </div>

  <!-- Table View -->
  <table class="data-table" id="tableView">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Species</th><th>Habitat</th>
        <th>Environment</th><th>DOB</th><th>Gender</th><th>Arrived On</th>
        <th>Photo</th>
        <?php if (isset($_SESSION['admin_username'])): ?><th>Actions</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= esc($row['animal_id']) ?></td>
          <td><?= esc($row['commonname']) ?></td>
          <td><?= esc($row['speciestype']) ?></td>
          <td><?= esc($row['habitatname']) ?></td>
          <td><?= esc($row['environment']) ?></td>
          <td><?= esc($row['dob']) ?></td>
          <td><?= esc($row['gender']) ?></td>
          <td><?= esc($row['arrivedon']) ?></td>
          <td>
            <?php if (!empty($row['photo_url'])): ?>
              <img src="../assets/images/animals/<?= htmlspecialchars($row['photo_url']) ?>"
                   alt="<?= esc($row['commonname']) ?>" class="animal-photo">
            <?php else: ?>
              <span class="no-image">No image</span>
            <?php endif; ?>
          </td>
          <?php if (isset($_SESSION['admin_username'])): ?>
            <td>
              <a class="action-link edit" href="edit_animal.php?id=<?= esc($row['animal_id']) ?>">Edit</a>
              <form class="inline-form" method="post" action="delete_animal.php"
                onsubmit="return confirm('Delete this animal?');">
                <input type="hidden" name="id" value="<?= esc($row['animal_id']) ?>">
                <button class="action-link delete" type="submit">Delete</button>
              </form>
            </td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Card View -->
  <div class="animals-grid" id="cardView" style="display:none;">
    <?php
    // Reset result pointer to loop again
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()): ?>
      <div class="animal-card">
        <?php if (!empty($row['photo_url'])): ?>
          <img src="../assets/images/animals/<?= htmlspecialchars($row['photo_url']) ?>"
               alt="<?= esc($row['commonname']) ?>">
        <?php else: ?>
          <div class="no-image">No image</div>
        <?php endif; ?>
        <div class="card-content">
          <h3><?= esc($row['commonname']) ?></h3>
          <p><strong>Species:</strong> <?= esc($row['speciestype']) ?></p>
          <p><strong>Habitat:</strong> <?= esc($row['habitatname']) ?></p>
          <p><strong>Environment:</strong> <?= esc($row['environment']) ?></p>
          <p><strong>DOB:</strong> <?= esc($row['dob']) ?></p>
          <p><strong>Gender:</strong> <?= esc($row['gender']) ?></p>
          <p><strong>Arrived:</strong> <?= esc($row['arrivedon']) ?></p>
        </div>
        <?php if (isset($_SESSION['admin_username'])): ?>
          <div class="card-actions">
            <a class="action-link edit" href="edit_animal.php?id=<?= esc($row['animal_id']) ?>">Edit</a>
            <form class="inline-form" method="post" action="delete_animal.php"
              onsubmit="return confirm('Delete this animal?');">
              <input type="hidden" name="id" value="<?= esc($row['animal_id']) ?>">
              <button class="action-link delete" type="submit">Delete</button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  const toggleBtn = document.getElementById('toggleView');
  const tableView = document.getElementById('tableView');
  const cardView = document.getElementById('cardView');

  toggleBtn.addEventListener('click', () => {
    if (tableView.style.display !== 'none') {
      tableView.style.display = 'none';
      cardView.style.display = 'grid';
      toggleBtn.textContent = 'Switch to Table View';
    } else {
      cardView.style.display = 'none';
      tableView.style.display = 'table';
      toggleBtn.textContent = 'Switch to Card View';
    }
  });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
