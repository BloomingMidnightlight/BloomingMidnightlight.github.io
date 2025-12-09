<?php
// Start session only once
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/auth.php';
include __DIR__ . '/../includes/db.php';

// Redirect safeguard: only allow logged-in admins
if (!isset($_SESSION['admin_username'])) {
  header("Location: home.php");
  exit();
}

$isAdmin = isset($_SESSION['admin_username']);

// Species
$result = $conn->query("SELECT COUNT(*) AS total FROM species");
$totalSpecies = $result->fetch_assoc()['total'];

// Habitats
$result = $conn->query("SELECT COUNT(*) AS total FROM habitats");
$totalHabitats = $result->fetch_assoc()['total'];

// Events
$result = $conn->query("SELECT COUNT(*) AS total FROM events");
$totalEvents = $result->fetch_assoc()['total'];

// Sponsors
$result = $conn->query("SELECT COUNT(*) AS total FROM sponsors");
$totalSponsors = $result->fetch_assoc()['total'];

// Animals
$result = $conn->query("SELECT COUNT(*) AS total FROM animals");
$totalAnimals = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) AS new FROM animals 
                        WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
                        AND YEAR(created_at) = YEAR(CURRENT_DATE())");
$newAnimals = $result->fetch_assoc()['new'];

$result = $conn->query("SELECT COUNT(*) AS prev FROM animals 
                        WHERE MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                        AND YEAR(created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)");
$prevAnimals = $result->fetch_assoc()['prev'];

$growthAnimals = $prevAnimals > 0 ? (($newAnimals - $prevAnimals) / $prevAnimals) * 100 : 0;

// Staff
$result = $conn->query("SELECT COUNT(*) AS total FROM staff");
$totalStaff = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) AS new FROM staff 
                        WHERE MONTH(hired_at) = MONTH(CURRENT_DATE()) 
                        AND YEAR(hired_at) = YEAR(CURRENT_DATE())");
$newStaff = $result->fetch_assoc()['new'];

$result = $conn->query("SELECT COUNT(*) AS prev FROM staff 
                        WHERE MONTH(hired_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                        AND YEAR(hired_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)");
$prevStaff = $result->fetch_assoc()['prev'];

$growthStaff = $prevStaff > 0 ? (($newStaff - $prevStaff) / $prevStaff) * 100 : 0;

// Members
$result = $conn->query("SELECT COUNT(*) AS total FROM members");
$totalMembers = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) AS new FROM members 
                        WHERE MONTH(joindate) = MONTH(CURRENT_DATE()) 
                        AND YEAR(joindate) = YEAR(CURRENT_DATE())");
$newMembers = $result->fetch_assoc()['new'];

$result = $conn->query("SELECT COUNT(*) AS prev FROM members 
                        WHERE MONTH(joindate) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                        AND YEAR(joindate) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)");
$prevMembers = $result->fetch_assoc()['prev'];

$growthMembers = $prevMembers > 0 ? (($newMembers - $prevMembers) / $prevMembers) * 100 : 0;

// Interactions
$result = $conn->query("SELECT COUNT(*) AS total FROM interactions");
$totalInteractions = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) AS new FROM interactions 
                        WHERE MONTH(interaction_date) = MONTH(CURRENT_DATE()) 
                        AND YEAR(interaction_date) = YEAR(CURRENT_DATE())");
$newInteractions = $result->fetch_assoc()['new'];

$result = $conn->query("SELECT COUNT(*) AS prev FROM interactions 
                        WHERE MONTH(interaction_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                        AND YEAR(interaction_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)");
$prevInteractions = $result->fetch_assoc()['prev'];

$growthInteractions = $prevInteractions > 0 ? (($newInteractions - $prevInteractions) / $prevInteractions) * 100 : 0;
?>

<main class="main">
  <!-- Welcome -->
  <section class="welcome">
    <h1>Welcome back Admin</h1>
  </section>

  </script>
  <!-- Top Row (compact cards) -->
  <section class="stats-grid top-row">
    <div class="stat-card compact">
      <h3 class="card-title">Current Species</h3>
      <p class="card-number"><?= $totalSpecies ?></p>
    </div>
    <div class="stat-card compact">
      <h3 class="card-title">Current Habitats</h3>
      <p class="card-number"><?= $totalHabitats ?></p>
    </div>
    <div class="stat-card compact">
      <h3 class="card-title"> Current Events</h3>
      <p class="card-number"><?= $totalEvents ?></p>
    </div>
    <div class="stat-card compact">
      <h3 class="card-title">Current Sponsors</h3>
      <p class="card-number"><?= $totalSponsors ?></p>
    </div>
  </section>

  <!-- Bottom Row (wider cards with graphs) -->
  <section class="stats-grid bottom-row">
    <div class="stat-card wide">
      <h3 class="card-title">Animals</h3>
      <p class="card-number"><?= $totalAnimals ?></p>
      <small class="card-growth <?= $growthAnimals >= 0 ? 'positive' : 'negative' ?>">
        <?= $growthAnimals >= 0 ? '↑' : '↓' ?> <?= round($growthAnimals, 1) ?>% vs last month
      </small>
      <canvas id="animalsChart"></canvas>
    </div>

    <div class="stat-card wide">
      <h3 class="card-title">Staff</h3>
      <p class="card-number"><?= $totalStaff ?></p>
      <small class="card-growth <?= $growthStaff >= 0 ? 'positive' : 'negative' ?>">
        <?= $growthStaff >= 0 ? '↑' : '↓' ?> <?= round($growthStaff, 1) ?>% vs last month
      </small>
      <canvas id="staffChart"></canvas>
    </div>

    <div class="stat-card wide">
      <h3 class="card-title">Members</h3>
      <p class="card-number"><?= $totalMembers ?></p>
      <small class="card-growth <?= $growthMembers >= 0 ? 'positive' : 'negative' ?>">
        <?= $growthMembers >= 0 ? '↑' : '↓' ?> <?= round($growthMembers, 1) ?>% vs last month
      </small>
      <canvas id="membersChart"></canvas>
    </div>

    <div class="stat-card wide">
      <h3 class="card-title">Interactions</h3>
      <p class="card-number"><?= $totalInteractions ?></p>
      <small class="card-growth <?= $growthInteractions >= 0 ? 'positive' : 'negative' ?>">
        <?= $growthInteractions >= 0 ? '↑' : '↓' ?> <?= round($growthInteractions, 1) ?>% vs last month
      </small>
      <canvas id="interactionsChart"></canvas>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Animals line chart
  new Chart(document.getElementById('animalsChart'), {
    type: 'line',
    data: {
      labels: ['Last Month', 'This Month'],
      datasets: [{
        label: 'Animals',
        data: [<?= $prevAnimals ?>, <?= $newAnimals ?>],
        borderColor: '#c2a83e',
        backgroundColor: 'rgba(194,168,62,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });

  // Staff line chart
  new Chart(document.getElementById('staffChart'), {
    type: 'line',
    data: {
      labels: ['Last Month', 'This Month'],
      datasets: [{
        label: 'Staff',
        data: [<?= $prevStaff ?>, <?= $newStaff ?>],
        borderColor: '#4a6b5c',
        backgroundColor: 'rgba(74,107,92,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });

  // Members line chart
  new Chart(document.getElementById('membersChart'), {
    type: 'line',
    data: {
      labels: ['Last Month', 'This Month'],
      datasets: [{
        label: 'Members',
        data: [<?= $prevMembers ?>, <?= $newMembers ?>],
        borderColor: '#4a6b5c',
        backgroundColor: 'rgba(74,107,92,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });

  // Interactions line chart
  new Chart(document.getElementById('interactionsChart'), {
    type: 'line',
    data: {
      labels: ['Last Month', 'This Month'],
      datasets: [{
        label: 'Interactions',
        data: [<?= $prevInteractions ?>, <?= $newInteractions ?>],
        borderColor: '#0a2a2d',
        backgroundColor: 'rgba(10,42,45,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
</script>

<!-- Recent Activity Section -->
<section class="recent">
  <h2>Recent Activity</h2>
  <ul class="activity-list">
    <?php
    $result = $conn->query("SELECT * FROM activity_log ORDER BY action_date DESC LIMIT 20");
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // Map action types to badge classes
        $badgeClass = strtolower($row['action_type']);
        echo "<li>
                  <span class='activity-text'>
                    {$row['description']} 
                    <small>{$row['action_date']} • {$row['user']}</small>
                  </span>
                  <span class='badge {$badgeClass}' title='" . ucfirst($row['action_type']) . "'>
                    " . ucfirst($row['action_type']) . "
                  </span>
                </li>";
      }
    } else {
      echo "<li><em>No recent activity found.</em></li>";
    }
    ?>
  </ul>
</section>

<div class="archives-button">
  <a href="archives.php" class="btn-archives">Archives</a>
</div>



<?php include __DIR__ . '/../includes/footer.php'; ?>