<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa del Parque</title>
    <!-- CSS files -->
    <link rel="stylesheet" href="zoo-styles.css">
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

    <main class="map-page">
        <h1>Mapa del Parque</h1>
        <div class="map-container"></div>
            <img src="../public/public-assets/images/mapaZonas.png" width="1000" height="750"
            alt="Mapa de Zonas del Parque">    
    </main>

    <footer>
        <p>Av. Parque de las Leyendas 580, San Miguel. Lima - Perú</p>
        <p>©2025 Parque de las Leyendas. Todos los derechos reservados.</p>
        <p>Teléfono Central: (01) 644-9200</p>
    </footer>
</body>

</html>