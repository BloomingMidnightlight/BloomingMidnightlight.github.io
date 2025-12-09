<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Safari Kingdom Zoo</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo-title">
        <img src="../assets/images/parquelogo.png" alt="Zoo Logo">
        <h1>Parque de La Leyendas Zoo</h1>
        <div class="tagline">A World of Wildlife Adventure</div>
      </div>

      <nav class="admin-nav">
      <!-- Conditional Home link -->
      <?php if (isset($_SESSION['admin_username'])): ?>
        <a href="index.php" class="home-link"><i class="fas fa-home"></i> Home</a>
      <?php else: ?>
        <a href="../admin/home.php" class="home-link"><i class="fas fa-home"></i> Home</a>
      <?php endif; ?>


        <?php if (isset($_SESSION['admin_username'])): ?>
          <!-- Show admin navigation only when logged in -->
          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-leaf"></i> Zoo Data ▾</button>
            <div class="dropdown-content">
              <a href="animals.php"><i class="fas fa-paw"></i> Animals</a>
              <a href="species.php"><i class="fas fa-dna"></i> Species</a>
              <a href="habitats.php"><i class="fas fa-tree"></i> Habitats</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-users"></i> Management ▾</button>
            <div class="dropdown-content">
              <a href="staff.php"><i class="fas fa-user-tie"></i> Staff</a>
              <a href="members.php"><i class="fas fa-id-card"></i> Members</a>
              <a href="events.php"><i class="fas fa-calendar-alt"></i> Events</a>
              <a href="sponsors.php"><i class="fas fa-handshake"></i> Sponsors</a>
              <a href="interactions.php"><i class="fas fa-comments"></i> Interactions</a>
            </div>
          </div>

          <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
          <!-- Show login link when logged out -->
          <a href="login.php" class="login-link"><i class="fas fa-sign-in-alt"></i> Admin Login</a>
        <?php endif; ?>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="container">
<style>
.dashboard {
  display: grid;
  grid-template-columns: 240px 1fr;
  min-height: 100vh;
}

.sidebar {
  position: sticky;   /* makes it stick within its parent */
  top: 0;             /* distance from the top of the viewport */
  height: 100vh;      /* full viewport height */
  overflow-y: auto;   /* scroll inside if content is taller */
  background: rgba(10, 42, 45, 1); /* deep green-blue */
  color: #f4f1e1; /* sand beige text */
  padding: 1rem;
}

.sidebar .logo-title {
  text-align: center;
  margin-bottom: 2rem;
}

.sidebar .logo-title img {
  max-width: 80px;
  margin-bottom: 0.5rem;
}

.sidebar h1 {
  font-size: 1.2rem;
  margin: 0;
}

.sidebar .tagline {
  font-size: 0.8rem;
  color: #fbc02d; /* golden accent */
}

.admin-nav {
  display: flex;
  flex-direction: column;
  gap: 0.6rem; /* spacing between buttons */
}

.admin-nav a, .dropbtn {
  background: #4a6b5c; /* muted sage green */
  color: #f4f1e1;
  padding: 0.7rem 1rem;
  border-radius: 10px; /* rounded corners */
  text-decoration: none;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.5rem; /* space between icon and text */
  transition: all 0.2s ease;
}

.admin-nav a:hover, .dropbtn:hover {
  background: #5c7d6d; /* lighter sage */
  box-shadow: 0 2px 4px rgba(0,0,0,0.15);
  transform: scale(1.02); /* subtle hover */
}

/* Home & Login buttons */
.home-link {
  background: #c2a83e; /* golden accent */
  color: #0a2a2d; /* dark text for contrast */
  padding: 0.6rem 1rem;
  border-radius: 4px;
  font-weight: 600;
  display: block;
  margin-bottom: 1rem;
  text-decoration: none;
}
.home-link:hover {
  background: #d4b94f; /* lighter gold */
}

.login-link {
  background: #7a5747; /* clay brown */
  color: #f4f1e1;
  padding: 0.6rem 1rem;
  border-radius: 4px;
  font-weight: 600;
  display: block;
  margin-top: 1rem;
  text-decoration: none;
}
.login-link:hover {
  background: #8b6858; /* lighter clay */
}



/* Dropdown Styling */
.dropdown {
  margin-bottom: 1rem;
}

.dropbtn {
  background: none;
  border: none;
  color: #f4f1e1;
  font-size: 1rem;
  text-align: left;
  width: 100%;
  padding: 0.7rem 1rem;
  cursor: pointer;
  border-radius: 10px;
  transition: background 0.2s ease;
  margin-bottom: 0.4rem; /* extra gap below button itself */
}

.dropbtn:hover {
  background: rgba(255,255,255,0.1); /* subtle tint */
}

.dropdown-content {
  display: none;
  flex-direction: column;
  background: transparent;
  margin-left: 0.5rem;
  gap: 0.6rem; /* increased gap between each option */
  padding-top: 0.6rem; /* space between Zoo Data button and Animals */
  padding-bottom: 0.6rem; /* space before next section */
}


.dropdown-content a {
  background: rgba(255,255,255,0.1);
  color: #f4f1e1;
  padding: 0.6rem 1rem;
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.dropdown-content a:hover {
  background: #114c3cff; /* slightly lighter green */
  box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* subtle shadow */
  transform: scale(1.02); /* gentle hover */
}


/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
  display: flex;
}

</style>

<main class="container">
