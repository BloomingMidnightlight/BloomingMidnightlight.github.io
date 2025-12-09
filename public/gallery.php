<?php
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals</title>
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
<!--zone costa-->
<section id="costa" class="habitat">
    <h2 class="gallery-title">Zona Costa</h2>
    <div class="animal-card">
        <img src="../public/public-assets/images/peruvian-pelican.jpg" alt="Pelícano">
        <div class="animal-info">
            <h3>Peruvian Pelícano</h3>
            <p>It is a species of seabird in the Pelecanidae family that lives in South America, 
                breeding in loose colonies in Piura in northern Peru. Currently, it is considered 
                a separate species of pelican, not a subspecies of the brown pelican.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/sea-lion.jpg" alt="sea lion">
        <div class="animal-info">
            <h3>Sea Lion</h3>
            <p>Sea lions are pinnipeds characterized by external ear flaps, long foreflippers,
                the ability to walk on all fours, short and thick hair, and a big chest and belly.
                Together with the fur seals, they make up the family Otariidae, eared seals.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/humboldt-penguin.jpg" alt="humboldt penguin">
        <div class="animal-info">
            <h3>Humboldt Penguin</h3>
            <p>It is a medium-sized penguin. It resides in South America, 
                along the Pacific coast of Peru and Chile. The Humboldt penguin 
                and the cold water current it swims in both are named after the 
                explorer Alexander von Humboldt.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/leatherback-sea-turtle.jpg" alt="leatherback sea turtle">
        <div class="animal-info">
            <h3>Leatherback Sea Turtle</h3>
            <p>It is the largest of all living turtles and the heaviest non-crocodilian reptile, 
                reaching lengths of up to 2.7 metres and weights of 500 kilograms. It is the only living 
                species in the genus Dermochelys and family Dermochelyidae.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/bluefooted-booby.jpg" alt="blue-footed booby">
        <div class="animal-info">
            <h3>Blue-footed Booby</h3>
            <p>It is a marine bird native to tropical regions of the Pacific Ocean. It is one
                of six species of the genus Sula and it is recognizable by its distinctive bright blue feet, 
                which is a sexually trait and a product of their diet.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/inca-tern.jpg" alt="inca tern">
        <div class="animal-info">
            <h3>Inca Tern</h3>
            <p>It is a near-threatened species of tern in the subfamily Sterninae of the family Laridae. 
                It is found along the Pacific coasts of Chile, Ecuador and Perú, and has appeared as a vagrant 
                in Central America and Hawaii.
            </p>
        </div>
    </div>
</section>
<!--zone sierra-->
<section id="sierra" class="habitat">
    <h2 class="gallery-title">Zona Sierra</h2>
    <div class="animal-card">
        <img src="../public/public-assets/images/aldean-condor.jpg" alt="aldean condor">
        <div class="animal-info">
            <h3>Aldean Condor</h3>
            <p>It is a South American vulture and the only member of the genus Vultur. It is 
                found in the Andes mountains and adjacent coasts. With a wingspan of 3.3 m and weight 
                of 15 kg, the Andean condor is the largest flying bird.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/south-american-cougar.jpg" alt="south american cougar">
        <div class="animal-info">
            <h3>South American Cougar</h3>
            <p>Also known as the Andean mountain lion or puma, is a cougar subspecies 
                occurring in northern and western South America, from Colombia and Venezuela 
                to Peru, Bolivia, Argentina and Chile.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/alpaca.jpg" alt="alpaca">
        <div class="animal-info">
            <h3>Alpaca</h3>
            <p>It is a species of South American camelid mammal. Traditionally, alpacas were from the 
                level heights of the Andes of Peru, Bolivia, Ecuador, and Chile. Nowadays, Alpacas have become 
                popular around the world.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/andean-fox.jpg" alt="andean fox">
        <div class="animal-info">
            <h3>Andean fox</h3>
            <p>The culpeo, also known as the Andean fox or colpeo fox, is a species of South American fox. Despite 
                the name, it is not a true fox, but more related to wolves and jackals. Its appearance resembles that of 
                foxes due to evolution.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/guinea-pig.jpg" alt="guinea pig">
        <div class="animal-info">
            <h3>Guinea Pig</h3>
            <p>They are a kind of rodent. They are not pigs and are not from Guinea. The reason for why
                this is the name is unclear. They are also called cavies or cuyes. They are domesticated animals 
                which originated in the Andes.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/andean-cock-of-the-rock.jpg" alt="andean cock of the rock">
        <div class="animal-info">
            <h3>Andean Cock of the Rock</h3>
            <p>Also known as tunki, is a bird of the cotinga family native to Andean 
                cloud forests in South America. It is the national bird of Peru. It has four 
                subspecies and its closest relative is the Guianan cock-of-the-rock.
            </p>
        </div>
    </div>
</section>
<!--zone selva-->
<section id="selva" class="habitat">
    <h2 class="gallery-title">Zona Selva</h2>
    <div class="animal-card">
        <img src="../public/public-assets/images/jaguar.jpg" alt="jaguar">
        <div class="animal-info">
            <h3>Jaguar</h3>
            <p>It is a large cat species and the only member of the genus Panthera that is native 
                to the Americas. With a body length of 1.85 m and a weight of 158 kg, they are notorious 
                for their ambush techniques and powerful arsenal.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/capybara.jpg" alt="capybara">
        <div class="animal-info">
            <h3>Capybara</h3>
            <p>It is the largest living rodent, native to South America. It is a member of the genus Hydrochoerus. 
                They are known to be gentle and calm around other species, and capable of hold their breath for under five minutes.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/anaconda.jpg" alt="anaconda">
        <div class="animal-info">
            <h3>Anaconda</h3>
            <p>Anacondas or water boas are a group of large boas of the genus Eunectes. They are a semiaquatic group of snakes found 
                in tropical South America. Instead of using their venom, they constrict their victims with their bodies.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/yellow-tailed-woolly-monkey.jpg" alt="yellow tailed woolly monkey">
        <div class="animal-info">
            <h3>Yellow-tailed woolly monkey</h3>
            <p>This rare primate is found only in the Peruvian Andes and are critically endangered
                due to deforestation and hunting. They tend to live in high elevations, averaging around 
                two thousand meters above sea level.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/anteater.jpg" alt="anteater">
        <div class="animal-info">
            <h3>Anteater</h3>
            <p>They are the four extant mammal species in the suborder Vermilingua (meaning "worm tongue"), 
                commonly known for eating ants and termites. Together with sloths, they are within the order Pilosa.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/Black-caiman.jpg" alt="black caiman">
        <div class="animal-info">
            <h3>Black Caiman</h3>
            <p>It is a crocodilian reptile endemic to South America. With a maximum length of 6.5 m and a mass of over 450 kg, 
                it is the largest living species of the family Alligatoridae. As an adult, it has a dark greenish-black coloration.
            </p>
        </div>
    </div>
</section>

<!--zone international-->

<section id="internacional" class="habitat">
<h2 class="gallery-title">Zona Internacional</h2>
    <div class="animal-card">
        <img src="../public/public-assets/images/hippopotamus.jpg" alt="hippopotamus">
        <div class="animal-info">
            <h3>Hipopotamus</h3>
            <p>It is a large semiaquatic mammal native to sub-Saharan Africa. It is one of only two extant 
                species in the family Hippopotamidae, the other being the pygmy hippopotamus. Its name comes from 
                the ancient Greek for "river horse".
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/lion.jpg" alt="lion">
        <div class="animal-info">
            <h3>Lion</h3>
            <p>It is a cat of the genus Panthera, native to Africa and India. It has a muscular, 
                broad-chested body; a short, rounded head; round ears; and a dark, hairy tuft at the 
                tip of its tail. It is a social species, forming groups called prides.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/giraffes.jpg" alt="giraffe">
        <div class="animal-info">
            <h3>Giraffe</h3>
            <p>It is a large African hoofed mammal belonging to the genus Giraffa. It is the tallest 
                living terrestrial animal. The giraffe's characteristics are its extremely long neck and legs, 
                horn-like ossicones, and spotted coat patterns.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/wildebeest.jpg" alt="wildebeest">
        <div class="animal-info">
            <h3>Wildebeest</h3>
            <p>Also called gnu are antelopes of the genus Connochaetes and native to Eastern and Southern Africa. 
                They belong to the family Bovidae. There are two species of wildebeest: the black wildebeest, and the blue wildebeest.
            </p>
        </div>
    </div>


    <div class="animal-card">
        <img src="../public/public-assets/images/Gorilla.jpg" alt="gorilla">
        <div class="animal-info">
            <h3>Gorilla</h3>
            <p>They are herbivorous, predominantly ground-dwelling great apes that inhabit the tropical 
                forests of equatorial Africa. The genus Gorilla is divided into two species: the eastern gorilla 
                and the western gorilla.
            </p>
        </div>
    </div>

    <div class="animal-card">
        <img src="../public/public-assets/images/zebra.jpg" alt="zebra">
        <div class="animal-info">
            <h3>Zebra</h3>
            <p>They are African equines with black-and-white striped coats. 
                The three living species: Grévy's zebra, the plains zebra, and 
                the mountain zebra. Zebras share the genus Equus with horses and asses, 
                forming the family Equidae.
            </p>
        </div>
    </div>
</section>
</main>

<footer>
    <p>Av. Parque de las Leyendas 580, San Miguel. Lima- Peru</p>
    <p>©2025 Parque de las Leyendas. Todos los derechos reservados.</p>
    <p>Telefonica Central: (01) 644-9200</p>
</footer>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".animal-card, .habitat h2");

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    });
  }, { threshold: 0.2 });

  cards.forEach(card => observer.observe(card));
});
</script>


</body>
</html>