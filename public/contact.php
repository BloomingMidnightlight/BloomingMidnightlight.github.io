<?php
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos</title>
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

    <main class="contact-page">
        <h1>Contáctanos</h1>
        <p>¿Tienes preguntas, comentarios o planes especiales? ¡Estamos aquí para ayudarte!</p>

        <form method="post" action="submit_contact.php" class="form-container">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn">Enviar</button>
        </form>

        <section class="contact-info">
            <h2>Información de contacto</h2>
            <p>Teléfono: (01) 644-9200</p>
            <p>Correo: contacto@parquedeleyendas.pe</p>
            <p>Dirección: Av. Parque de las Leyendas 580, San Miguel, Lima - Perú</p>
        </section>
    </main>

    <?php include("./components/footer.php"); ?>
</body>

</html>