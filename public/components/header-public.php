<header class="site-header">
    <div class="logo-title">
        <img src="assets/images/logo.png" alt="Zoo Logo">
        <div>
            <h1>Safari Kingdom Zoo</h1>
            <div class="tagline">A World of Wildlife Adventure</div>
        </div>
    </div>
    <nav class="site-nav">
        <a href="index.php">Home</a>
        <a href="animals.php">Animals</a>
        <a href="species.php">Species</a>
        <a href="habitats.php">Habitats</a>
        <a href="staff.php">Staff</a>
        <a href="members.php">Members</a>
        <a href="events.php">Events</a>
        <a href="sponsors.php">Sponsors</a>
        <a href="interactions.php">Interactions</a>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="admin_dashboard.php">Admin Panel</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>