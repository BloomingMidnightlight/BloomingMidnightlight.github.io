<?php
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';

$res = $conn->query("SELECT * FROM events WHERE status='active' ORDER BY eventdate ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="../public/public-assets/css/styles.css">
</head>


<body>
    <header>
        <div class="logo-container">
            <img src="../public/public-assets/images/parquelogo.png" alt="Logo del Parque de las Leyendas" id="logo" width="130" height="130">
            <h3>Parque de las Leyendas</h3>
        </div>
        <?php include("./components/navbar.php"); ?>
    </header>

  <main class="events-page"> 
        <h2>Próximos Eventos</h2>
        <div class="events-grid">
            <?php while ($e = $res->fetch_assoc()): ?>
                <div class="event-card">
                    <h3><?= htmlspecialchars($e['eventname']) ?></h3>
                    <p><?= htmlspecialchars($e['description']) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($e['eventdate']) ?>
                        <strong>Hora:</strong> <?= htmlspecialchars($e['eventtime']) ?>
                    </p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($e['location']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </main>


    <?php include("./components/footer.php"); ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Animate title
  const title = document.querySelector("h2");
  if (title) {
    setTimeout(() => {
      title.classList.add("visible");
    }, 300);
  }

  // Animate event cards with stagger
  const cards = document.querySelectorAll(".event-card");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const card = entry.target;
        const index = Array.from(cards).indexOf(card);
        setTimeout(() => {
          card.classList.add("visible");
        }, index * 200); // stagger: 0.2s between each card
      }
    });
  }, { threshold: 0.2 });

  cards.forEach(card => observer.observe(card));
});
</script>

</body>

</html>