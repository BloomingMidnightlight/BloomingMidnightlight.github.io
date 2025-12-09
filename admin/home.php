<?php
session_start();
include __DIR__ . '/../includes/header.php';

$isAdmin = isset($_SESSION['admin_username']);
?>

<main class="container">

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to Parque De las Leyendas</h1>
        <p>Discover our amazing animals, explore habitats, meet our staff, and join our membership programs. Adventure
            awaits!</p>
        <?php if (!$isAdmin): ?>
            <a class="btn-primary" href="login.php">Admin Login</a>
        <?php else: ?>
            <a class="btn-primary" href="admin_dashboard.php">Admin Dashboard</a>
        <?php endif; ?>
    </section>

    <!-- Quick Links Section -->
    <section class="quick-links">
        <h2>Explore the Zoo Database</h2>
        <div class="links-grid">
            <a href="animals.php">Animals</a>
            <?php if ($isAdmin): ?>
                <a href="add_animal.php">Add New Animal</a>
            <?php endif; ?>
            <a href="habitats.php">Habitats</a>
            <a href="staff.php">Staff</a>
            <a href="members.php">Members</a>
            <a href="events.php">Events</a>
            <a href="sponsors.php">Sponsors</a>
            <a href="interactions.php">Interactions</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <h2>About Parque de La Leyenda </h2>
        <p>Parque de la Leyendas is a virtual experience showcasing modern web technologies including PHP, MySQL, and
            responsive HTML/CSS. Browse our collection of animals, check habitats and staff, or manage memberships if
            you're an admin. Come explore the wild side!</p>
    </section>

</main>

<style>
    .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
    font-family: 'Segoe UI', 'Roboto', sans-serif;
    color: #0a2a2d; /* deep green-blue text */
}

/* Hero Section */
.hero {
    position: relative;
    text-align: center;
    background: url('../assets/images/background-zoo.jpg') no-repeat center/cover; /* adjust path */
    color: #f4f1e1;
    padding: 4rem 1rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
    margin-bottom: 2rem;
    overflow: hidden;
}

.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(10, 42, 45, 0.7); /* semi-transparent overlay */
    border-radius: 15px;
    z-index: 0; /* keep overlay behind text */
}

.hero h1,
.hero p,
.hero .btn-primary {
    position: relative;
    z-index: 1; /* bring text above overlay */
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #f4f1e1; /* light accent */
    text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
}

.hero p {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    color: #fbc02d; /* golden accent */
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}



.btn-primary {
    background: #4a6b5c; /* muted sage green */
    color: #f4f1e1;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.btn-primary:hover {
    background: #5c7d6d; /* lighter sage */
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.3);
}

/* Quick Links Section */
.quick-links {
    margin: 3rem 0;
    text-align: center;
}

.quick-links h2 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #c2a83e; /* golden accent */
}

.links-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
}

.links-grid a {
    background: #114c3c; /* deep earthy green */
    color: #f4f1e1;
    text-decoration: none;
    font-weight: 500;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.links-grid a:hover {
    background: #0a2a2d; /* darker green-blue */
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.25);
}

/* About Section */
.about {
    background: #f4f1e1; /* sand beige background */
    padding: 2rem 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.about h2 {
    color: #4a6b5c; /* muted sage green */
    margin-bottom: 1rem;
}

.about p {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #0a2a2d;
}

</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>