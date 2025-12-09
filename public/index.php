<?php
// Connect backend logic
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parque de las Leyendas</title>

    <!-- Public CSS -->
    <link rel="stylesheet" href="../public/public-assets/css/styles.css">
    


    <!-- GSAP CDN for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
    <div class="logo-container">
        <img src="../public/public-assets/images/parquelogo.png" alt="Logo del Parque de las Leyendas" id="logo" width="130" height="130">
        <h3>Parque de las Leyendas</h3>
    </div>
    <?php include("./components/navbar.php"); ?>
    </header>


    <!-- Hero Section -->
<section class="hero">
    <div class="hero-slideshow">
        <img src="../public/public-assets/images/tiger.jpg" class="heroimage active" alt="Imagen de un tigre">
        <img src="../public/public-assets/images/elephant.jpg" class="heroimage" alt="Imagen de un elefante">
        <img src="../public/public-assets/images/snake.jpg" class="heroimage" alt="Imagen de un serpiente">
        <img src="../public/public-assets/images/Gorilla.jpg" class="heroimage" alt="Imagen de un gorila">
    </div>
    <div class="hero-overlay">
        <h1>Ven y descubre...</h1>
        <p>-la fauna legendaria de Perú-</p>
        <a href="visit.php" class="btn">Planifica tu visita</a>
    </div>
</section>



    <!-- Zones -->
    <main>
    <section class="zone costa">
        <a href="gallery.php#costa">
            <div class="zone-content">
                <h2>Zona Costa</h2>
                <p>Explora la diversidad de la costa peruana.</p>
            </div>
        </a>
    </section>

    <section class="zone sierra">
        <a href="gallery.php#sierra">
            <div class="zone-content">
                <h2>Zona Sierra</h2>
                <p>Descubre los animales de las montañas andinas.</p>
            </div>
        </a>
    </section>

    <section class="zone selva">
        <a href="gallery.php#selva">
            <div class="zone-content">
                <h2>Zona Selva</h2>
                <p>Sumérgete en la selva amazónica.</p>
            </div>
        </a>
    </section>

    <section class="zone internacional">
        <a href="gallery.php#internacional">
            <div class="zone-content">
                <h2>Zona Internacional</h2>
                <p>Conoce especies de todo el mundo.</p>
            </div>
        </a>
    </section>
</main>


    <?php include("./components/footer.php"); ?>

    <!-- Animations -->
    <script>
    const slides = document.querySelectorAll('.heroimage');
    let current = 0;

    function showNextSlide() {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }

    // Rotate every 5 seconds
    setInterval(showNextSlide, 5000);

    // Initial fade-in animation for overlay text
    gsap.from(".hero-overlay h1", {opacity:0, y:-50, duration:1});
    gsap.from(".hero-overlay p", {opacity:0, y:30, duration:1, delay:0.5});
    gsap.from(".hero-overlay .btn", {opacity:0, scale:0.8, duration:1, delay:1});
</script>


    
</body>

</html>