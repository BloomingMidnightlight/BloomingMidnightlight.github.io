<?php
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestra Historia</title>
    <link rel="stylesheet" href="../public/public-assets/css/styles.css">   
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="../public/public-assets/images/parquelogo.png" alt="Logo del Parque de las Leyendas" id="logo"
                width="130" height="130">
            <h3>Parque de las Leyendas</h3>
        </div>
        <?php include("./components/navbar.php"); ?>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="about-hero">
            <img src="../public/public-assets/images/parqueAerial.jpg" alt="Vista aérea del parque" class="about-bg">
            <div class="about-overlay">
                <h1>Sobre el Parque de las Leyendas</h1>
                <p>El Parque de las Leyendas, inaugurado en 1964, es uno de los zoológicos más importantes de Perú...
                </p>
                <p>El parque se extiende sobre un área de más de 68 hectáreas...</p>
                <p>A lo largo de los años, el parque ha evolucionado...</p>
            </div>
        </section>

        <!-- Hours of Operation -->
        <section class="horario">
        <h2>Horario de Atención</h2>
            <table class="horario-table">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Horario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Lunes</td>
                        <td>Cerrado</td>
                    </tr>
                    <tr>
                        <td>Martes - Viernes</td>
                        <td>9:00 AM – 5:00 PM</td>
                    </tr>
                    <tr>
                        <td>Sábado</td>
                        <td>9:00 AM – 6:00 PM</td>
                    </tr>
                    <tr>
                        <td>Domingo y Feriados</td>
                        <td>9:00 AM – 6:00 PM</td>
                    </tr>
                </tbody>
            </table>

            <p class="horario-note">
                *Los horarios pueden variar en días festivos especiales o eventos del parque.*
            </p>
        </section>


        <!-- Highlights & Attractions -->
        <section class="about-info">
            <h2>Atracciones y Destacados</h2>
            <p>El Parque de las Leyendas ofrece una experiencia única con:</p>
            <ul>
                <li>Más de 200 especies de fauna peruana e internacional</li>
                <li>Zonas temáticas: Costa, Sierra, Selva e Internacional</li>
                <li>Áreas arqueológicas con huacas prehispánicas</li>
                <li>Jardines botánicos y espacios de recreación</li>
                <li>Eventos culturales y educativos durante todo el año</li>
            </ul>
        </section>
    </main>

    <?php include("./components/footer.php"); ?>

    <script>
document.addEventListener("DOMContentLoaded", () => {
  // Animate hero background
  const heroBg = document.querySelector(".about-bg");
  if (heroBg) {
    setTimeout(() => {
      heroBg.classList.add("visible");
    }, 200); // slight delay for smoothness
  }

  // Animate hero overlay text with stagger
  const heroOverlay = document.querySelector(".about-overlay");
  if (heroOverlay) {
    const elements = heroOverlay.querySelectorAll("h1, p");
    elements.forEach((el, index) => {
      setTimeout(() => {
        el.style.transition = "all 0.8s ease";
        el.style.opacity = "1";
        el.style.transform = "translateY(0)";
      }, index * 400 + 600); // stagger after background starts
    });
  }

  // Animate info sections on scroll
  const sections = document.querySelectorAll(".about-info");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    });
  }, { threshold: 0.2 });

  sections.forEach(section => observer.observe(section));
});
</script>




</body>

</html>