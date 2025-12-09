<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Escape function (defined only once in functions.php, remove if already in functions.php)
if (!function_exists('esc')) {
    function esc($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

// Allowed sorting options
$allowed_sorts = ['staff','species','time'];
$sort = 'time'; // default

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sorts)) {
    $sort = $_GET['sort'];
}

// Map sorting to actual columns
switch($sort) {
    case 'staff':
        $order_sql = 's.name';
        break;
    case 'species':
        $order_sql = 'sp.speciestype';
        break;
    default:
        $order_sql = 'i.feedingtime';
}

// Build query (remove COLLATE for latin1 compatibility)
$sql = "
    SELECT i.feeding_id, s.name AS staff_name, sp.speciestype AS species_name,
           i.food, i.amount, i.feedingtime
    FROM interactions AS i
    JOIN staff AS s ON i.staff_id = s.staff_id
    JOIN species AS sp ON i.species_id = sp.species_id
    ORDER BY $order_sql
";

$result = $conn->query($sql);
if (!$result) die("Query failed: " . $conn->error);
?>

<h2>Feeding / Interactions</h2>

<div class="toolbar">
    <div>Sort:
        <a href="?sort=staff">Staff</a> |
        <a href="?sort=species">Species</a> |
        <a href="?sort=time">Time</a>
    </div>
</div>

<?php if ($result->num_rows === 0): ?>
    <p>No interactions found.</p>
<?php else: ?>
<table class="data-table">
    <thead>
        <tr>
            <th>Feeding ID</th>
            <th>Staff Name</th>
            <th>Species</th>
            <th>Food</th>
            <th>Amount</th>
            <th>Feeding Time</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= esc($row['feeding_id']) ?></td>
            <td><?= esc($row['staff_name']) ?></td>
            <td><?= esc($row['species_name']) ?></td>
            <td><?= esc($row['food']) ?></td>
            <td><?= esc($row['amount']) ?></td>
            <td><?= esc($row['feedingtime']) ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php';
