<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/auth.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = $_POST['event_date'] ?? null;
    $location = trim($_POST['location'] ?? '');

    if ($title === '')
        $errors[] = 'Title is required';
    if ($event_date === '')
        $errors[] = 'Date is required';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO events (eventname, description, eventdate, location) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $title, $description, $event_date, $location);
        if ($stmt->execute()) {
            $success = true;
            $user = $_SESSION['admin_username'] ?? 'System';
            logActivity($conn, 'add', 'Event', "Added event: $title", $user);
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="form-container">
    <h2>Add Event</h2>

    <?php if ($success): ?>
        <p class="success">
            Event added successfully.
            <a href="events.php">Back to list</a>
        </p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>

        <label for="event_date">Date</label>
        <input id="event_date" type="date" name="event_date" value="<?= htmlspecialchars($_POST['event_date'] ?? '') ?>"
            required>

        <label for="location">Location</label>
        <input id="location" type="text" name="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

        <button class="btn" type="submit">Add Event</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>