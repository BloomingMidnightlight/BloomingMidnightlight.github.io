<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

if (!isset($_SESSION['admin_username'])) {
    die("Access denied. Admins only.");
}

// Determine which archive view to show
$allowed_views = ['events', 'sponsors', 'members', 'interactions'];
$view = $_GET['view'] ?? 'events';
if (!in_array($view, $allowed_views)) {
    $view = 'events';
}
?>

<h2>Archives</h2>

<div class="toolbar">
    <a class="action-link <?= $view === 'events' ? 'active' : '' ?>" href="?view=events">Events</a> |
    <a class="action-link <?= $view === 'sponsors' ? 'active' : '' ?>" href="?view=sponsors">Sponsors</a> |
    <a class="action-link <?= $view === 'members' ? 'active' : '' ?>" href="?view=members">Members</a> |
    <a class="action-link <?= $view === 'interactions' ? 'active' : '' ?>" href="?view=interactions">Interactions</a>
</div>

<?php if ($view === 'events'): ?>
    <h3>Archived Events</h3>
    <table class="data-table rounded-table">
      <thead><tr><th>ID</th><th>Name</th><th>Date</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php
        $res = $conn->query("SELECT * FROM events WHERE status='archived' ORDER BY eventdate DESC");
        while ($row = $res->fetch_assoc()):
        ?>
          <tr>
            <td><?= esc($row['event_id']) ?></td>
            <td><?= esc($row['eventname']) ?></td>
            <td><?= esc($row['eventdate']) ?> <?= esc($row['eventtime']) ?></td>
            <td><?= esc($row['location']) ?></td>
            <td><?= esc($row['status']) ?></td>
            <td>
              <form method="post" action="restore_event.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['event_id'] ?>">
                <button class="action-link edit" type="submit">Restore</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

<?php elseif ($view === 'sponsors'): ?>
    <h3>Archived Sponsors</h3>
    <table class="data-table rounded-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Animal</th>
                <th>Plan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM sponsors WHERE is_active=0 ORDER BY sponsor_id DESC");
            while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= esc($row['sponsor_id']) ?></td>
                    <td><?= esc($row['sponsorname']) ?></td>
                    <td><?= esc($row['animalname']) ?></td>
                    <td><?= esc($row['sponsorplan']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php elseif ($view === 'members'): ?>
    <h3>Archived Members</h3>
    <table class="data-table rounded-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Join Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM members WHERE membershipperiod=0 ORDER BY member_id DESC");
            while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= esc($row['member_id']) ?></td>
                    <td><?= esc($row['membername']) ?></td>
                    <td><?= esc($row['email']) ?></td>
                    <td><?= esc($row['joindate']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php elseif ($view === 'interactions'): ?>
    <h3>Archived Interactions</h3>
    <table class="data-table rounded-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Auto-archive interactions older than 30 days
            $conn->query("UPDATE interactions 
                          SET is_archived=1 
                          WHERE is_archived=0 
                          AND interaction_date < NOW() - INTERVAL 30 DAY");

            // Fetch archived interactions
            $res = $conn->query("SELECT * FROM interactions 
                                 WHERE is_archived=1 
                                 ORDER BY interaction_date DESC");

            while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= esc($row['feeding_id']) ?></td>
                    <td><?= esc($row['food']) ?></td>
                    <td><?= esc($row['interaction_date']) ?></td>
                    <td>
                        Amount: <?= esc($row['amount']) ?> |
                        Feeding time: <?= esc($row['feedingtime']) ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>



<?php include __DIR__ . '/../includes/footer.php'; ?>