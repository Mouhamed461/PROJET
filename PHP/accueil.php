<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../CSS/accueilplus.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .slider-img .slide {
            display: none;
        }
        .slider-img .slide.active {
            display: block;
        }
        .slider-img .slide img {
            width: 40%;
            height: auto;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="main-menu">
        <div class="logo">
            <img src="../IMG/coffe.jpg" alt="LOGO">
        </div>
        
        <ul>
            <li><a href="accueil.php">Accueil </a></li>
            <li><a href="Services.php">Services</a></li>
            <li><a href="Apropos.php">A propos</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <?php
        session_start();
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            echo '<form method="post" action="deconnexion.php">';
            echo '<button type="submit" name="deconnexion">Se déconnecter</button>';
            echo '</form>';
        } else {
            echo '<form method="post" action="deconnexion.php">';
            echo '<button type="submit" name="deconnexion">Se déconnecter</button>';
            echo '</form>';
        }
        ?>
    </div>
</header>

<div class="container">
    <div class="slider-container">
        <div class="slider-img">
            <div class="slide active">
                <img src="../IMG/TARTRE.jpeg" alt="Image 1">
            </div>
            <div class="slide">
                <img src="../IMG/hambourger.jpg" alt="Image 2">
            </div>
            <div class="slide">
                <img src="../IMG/bolognaise.jpg" alt="Image 3">
            </div>
        </div>
        <div class="slider-dots-container">
            <span class="slider-dot active" onclick="currentSlide(1)"></span>
            <span class="slider-dot" onclick="currentSlide(2)"></span>
            <span class="slider-dot" onclick="currentSlide(3)"></span>
        </div>
    </div>
</div>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("slider-dot");
        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
            dots[i].classList.remove("active");
        }
        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1 }
        slides[slideIndex - 1].classList.add("active");
        dots[slideIndex - 1].classList.add("active");
        setTimeout(showSlides, 5000);
    }

    function currentSlide(n) {
        slideIndex = n;
        showSlides();
    }
</script>

<div class="container">
    <div class="plat-container">
        <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "772013470aa"; 
        $base_de_donnees = "cafeteria"; 

        $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        $sql = "SELECT * FROM plat";
        $resultat = $conn->query($sql);

        if ($resultat->num_rows > 0) {
            while ($row = $resultat->fetch_assoc()) {
                echo '<div class="plat">';
                if ($row["nom"] === "Croissant") {
                    echo '<img src="../IMG/croissant.jpeg" alt="Spaghetti bolognaise">';
                } elseif ($row["nom"] === "Salade César") {
                    echo '<img src="../IMG/TARTRE.JPEG" alt="Salade César">';
                } elseif ($row["nom"] === "Hambourger") {
                    echo '<img src="../IMG/Comment-faire-un-menu-gastronomique.jpg" alt="Burger classique">';
                } elseif ($row["nom"] === "thieboudieune") {
                    echo '<img src="../IMG/THIEBE.JPEG" alt="PLAT NATIONALE SENEGALAISE">';
                } elseif ($row["nom"] === "Yassa") {
                    echo '<img src="../IMG/YASSA.jpeg" alt="YASSA POULET">';
                } elseif ($row["nom"] === "Maafe") {
                    echo '<img src="../IMG/3639a9acf0785cfe4d3e72e464f2e4d1.jpg" alt="Maafee TOP">';
                } elseif ($row["nom"] === "Expresso") {
                    echo '<img src="../IMG/cafe.jpg" alt="Maafee TOP">';
                } elseif ($row["nom"] === "Mbaxal") {
                    echo '<img src="../IMG/mbaxal.jpeg" alt="Maafee TOP">';
                } else {
                    echo 'Aucune image trouvée';
                }

                echo '<div class="plat-info">';
                echo '<h2>' . $row["nom"] . '</h2>';
                echo '<p>' . $row["description"] . '</p>';
                echo '<p class="prix">' . $row["prix"] . '€</p>';
                echo '<p class="categorie">' . $row["categorie"] . '</p>';

                echo '<div class="plat-buttons">';
                if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                    echo '<button class="custom-button" type="button"><a href="modifier_plat.php?id=' . $row["id_plat"] . '">Modifier</a></button>';
                    echo '<button class="custom-button" type="button" onclick="confirmDelete(' . $row["id_plat"] . ')">Supprimer</button>';
                } else {
                    echo '<button class="custom-button" type="button"><a href="details.php?id=' . $row["id_plat"] . '">Détails</a></button>';
                    echo '<button class="custom-button" type="button"><a href="commander.php?id=' . $row["id_plat"] . '&prix=' . $row["prix"] . '">Commander</a></button>';
                }
                echo '</div>'; 
                echo '</div>'; 
                echo '</div>'; 
            }
        } else {
            echo "<p>Aucun plat trouvé.</p>";
        }
        
        $conn->close();
        ?>
    </div> 
</div> 

<div class="button-container">
    <?php
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        echo '<form method="post" action="ajouter_plat.php" class="add-button">';
        echo '<button type="submit" name="ajouter" class="custom-button">Ajouter un Plat</button>';
        echo '</form>';
    }
    ?>
</div>

</body>
</html>

<body>
    <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Restauration</a></li>
                            <li><a href="#">Livraison</a></li>
                            <li><a href="#">Cafeteria</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Company</a></li>
                            <li><a href="#">Team</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Cafeteria Iep</h3>
                        <p> Etudiants , Membre , Personnel , Administrations votre restaurant dans  l'ISEP vous ouvre ses portes . <br>
                         'Resto ISEP' : cafeteria , restaurant est à votre dispostion DU Lundi au 8H/8.</p> <br>
                    </div>
                    <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                </div>
                <p class="copyright">CAFETERIA ISEP 2024</p>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
