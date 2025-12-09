<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

// Query members
$sql = "SELECT member_id, membername, email, phone, joindate, membershiptype, membershipperiod FROM members";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// esc helper
if (!function_exists('esc')) {
    function esc($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

$isAdmin = isset($_SESSION['admin_username']);
?>

<div class="members-page">
    <h2>Members</h2>

    <?php if ($isAdmin): ?>
        <p><a class="action-link add" href="/MY-APP/updatedzoodb/zoo-site/admin/add_member.php">+ Add Member</a></p>
    <?php endif; ?>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Join Date</th>
                <th>Membership Type</th>
                <th>Membership Period</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= esc($row['member_id']) ?></td>
                        <td><?= esc($row['membername']) ?></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['phone']) ?></td>
                        <td><?= esc($row['joindate']) ?></td>
                        <td><?= esc($row['membershiptype']) ?></td>
                        <td><?= esc($row['membershipperiod']) ?></td>
                        <?php if ($isAdmin): ?>
                            <td>
                                <a class="action-link edit"
                                    href="/MY-APP/updatedzoodb/zoo-site/admin/edit_member.php?id=<?= $row['member_id'] ?>">Edit</a>
                                <form class="inline-form" method="post" action="/MY-APP/updatedzoodb/zoo-site/admin/delete_member.php"
                                    onsubmit="return confirm('Delete this member?');">
                                    <input type="hidden" name="id" value="<?= $row['member_id'] ?>">
                                    <button class="action-link delete" type="submit">Delete</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= $isAdmin ? 8 : 7 ?>" style="text-align:center;">No members found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>