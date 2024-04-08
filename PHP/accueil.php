<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../CSS/accueilplus.css">
    <style>
        /* Styles pour le slider */
        .slider-container {
            position: relative;
            max-width: 800px;
            margin: auto;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            flex: 0 0 100%;
            margin-right: 20px;
            overflow: hidden;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: 200px; /* Définissez une hauteur fixe pour toutes les images des plats */
            object-fit: cover; /* Assurez-vous que l'image couvre toujours la hauteur spécifiée */
}
        }

        .slider button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: white;
            z-index: 1;
            transition: color 0.3s ease;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }

        .prev:hover,
        .next:hover {
            color: #ccc;
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

<div class="slider-container">
    <div class="slider">
        <?php
        // Liste des chemins d'accès des images des plats du jour
        $images_plats_du_jour = [
            "../IMG/YASSA.jpeg",
            "../IMG/mafe.jpeg",
            "../IMG/mbaxal.jpeg",
            // Ajoutez d'autres images ici si nécessaire
        ];

        // Affichage des images des plats du jour
        foreach ($images_plats_du_jour as $image_path) {
            echo '<div class="slide">';
            echo '<img src="' . $image_path . '" alt="Plat du Jour">';
            echo '</div>'; // Fin de slide
        }
        ?>
    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>
</div>

<div class="plat-du-jour">
    <h2>Plats du jour</h2>
</div>

<div class="container">
    <div class="plat-container">
        <?php
        // Connexion à la base de données
        $serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "772013470aa"; // Mot de passe MySQL
        $base_de_donnees = "cafeteria"; // Nom de la base de données

        $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Requête SQL pour récupérer tous les plats
        $sql = "SELECT * FROM plat";
        $resultat = $conn->query($sql);

        // Traiter les résultats
        if ($resultat->num_rows > 0) {
            // Afficher chaque plat avec ses informations
            while ($row = $resultat->fetch_assoc()) {
                echo '<div class="plat">';
                // Afficher l'image du plat en fonction de son nom
                if ($row["nom"] === "Spaghetti bolognaise") {
                    // Ajouter l'image spécifique pour "Spaghetti bolognaise"
                    echo '<img src="../IMG/hambourger.jpg" alt="Spaghetti bolognaise">';
                } elseif ($row["nom"] === "Salade César") {
                    // Ajouter l'image spécifique pour "Salade César"
                    echo '<img src="../IMG/TARTRE.JPEG" alt="Salade César">';
                } elseif ($row["nom"] === "Hambourger") {
                    // Ajouter l'image spécifique pour "Burger classique"
                    echo '<img src="../IMG/Comment-faire-un-menu-gastronomique.jpg" alt="Burger classique">';
                } elseif ($row["nom"] === "thieboudieune") {
                    // Ajouter l'image spécifique pour "Burger classique"
                    echo '<img src="../IMG/THIEBE.JPEG" alt="PLAT NATIONALE SENEGALAISE">';
                } elseif ($row["nom"] === "Yassa") {
                    // Ajouter l'image spécifique pour "Burger classique"
                    echo '<img src="../IMG/YASSA.jpeg" alt="YASSA POULET">';
                } elseif ($row["nom"] === "Maafe") {
                    // Ajouter l'image spécifique pour "Burger classique"
                    echo '<img src="../IMG/3639a9acf0785cfe4d3e72e464f2e4d1.jpg" alt="Maafee TOP">';
                } elseif ($row["nom"] === "Expresso") {
                    // Ajouter l'image spécifique pour "Burger classique"
                    echo '<img src="../IMG/cafe.jpg" alt="Maafee TOP">';
                } elseif ($row["nom"] === "Mbaxal") {
                    // Ajouter l'image spécifique pour "Burger classique"
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
                    // Si l'utilisateur est un admin, afficher les boutons Modifier et Supprimer avec confirmation
                    echo '<button class="custom-button" type="button"><a href="modifier_plat.php?id=' . $row["id_plat"] . '">Modifier</a></button>';
                    echo '<button class="custom-button" type="button" onclick="confirmDelete(' . $row["id_plat"] . ')">Supprimer</button>';
                } else {
                    // Si l'utilisateur est un client, afficher les boutons Détails et Commander
                    echo '<button class="custom-button" type="button"><a href="details.php?id=' . $row["id_plat"] . '">Détails</a></button>';
                    echo '<button class="custom-button" type="button"><a href="commander.php?id=' . $row["id_plat"] . '&prix=' . $row["prix"] . '">Commander</a></button>';
                }
                echo '</div>'; // Fin de plat-buttons

                echo '</div>'; // Fin de plat-info
                echo '</div>'; // Fin de plat
            }
        } else {
            echo "<p>Aucun plat trouvé.</p>";
        }
        
        // Fermer la connexion à la base de données
        $conn->close();
        ?>
    </div> <!-- Fin de plat-container -->
</div> 

<div class="button-container">
    <?php
    // Afficher le bouton "Ajouter un Plat" seulement si l'utilisateur est un admin
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        echo '<form method="post" action="ajouter_plat.php" class="add-button">';
        echo '<button type="submit" name="ajouter" class="custom-button">Ajouter un Plat</button>';
        echo '</form>';
    }
    ?>
</div>

<script>
    function confirmDelete(id) {
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce plat ?");
        if (confirmation) {
            window.location.href = "supprimer_plat.php?id=" + id;
        }
    }

    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("slide");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1 }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 5000); // Change l'image toutes les 2 secondes (2000 milliseconds)
    }

    function moveSlide(n) {
        slideIndex += n;
        showSlides();
    }
</script>

</body>
</html>
