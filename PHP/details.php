<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .retour-button {
            position: absolute;
            top: 10px;
            left: 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            z-index: 999; /* Assurez-vous que le bouton est au-dessus de tout le reste */
        }

        .container {
            max-width: 800px;
            margin: 80px auto 20px; /* Marge supérieure plus grande pour éviter de cacher le contenu */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Permet de positionner le contenu par rapport à ce conteneur */
        }

        .details-produit {
            text-align: center;
            margin-bottom: 20px;
        }

        .details-produit img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .details-produit p {
            margin: 10px 0;
        }

        .commander-button {
            display: block;
            margin: 0 auto;
            text-decoration: none;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .commander-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Bouton "Retour" -->
<a href="accueil.php" class="retour-button">Retour</a>

<?php
// Informations de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "772013470aa"; // Mot de passe MySQL
$base_de_donnees = "cafeteria"; // Nom de la base de données

// Connexion à la base de données
$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer l'identifiant du plat depuis l'URL
if(isset($_GET['id'])) {
    $id_plat = $_GET['id'];
    
    // Requête SQL pour récupérer les détails du plat spécifique
    $sql = "SELECT * FROM plat WHERE id_plat = $id_plat";
    $resultat = $conn->query($sql);

    // Traiter les résultats et afficher les détails du plat
    if ($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();
        // Afficher les détails du plat
        echo '<div class="container">';
        echo '<div class="details-produit">';
        echo '<h2>Détails du plat</h2>';
        echo '<img src="../IMG/hambourger.jpg'. $row["id_plat"]. $row["nom"] . '">'; // Supposer que vos images sont nommées avec l'ID du plat
    
        echo '<p>Nom : ' . $row["nom"] . '</p>';
        echo '<p>Description : ' . $row["description"] . '</p>';
        echo '<p>Prix : ' . $row["prix"] . '€</p>';
        echo '</div>';
        
        // Bouton "Commander" avec le prix en paramètre d'URL
        echo '<a href="commander.php?id=' . $id_plat . '&prix=' . $row["prix"] . '" class="commander-button">Commander</a>';
        echo '</div>';
    } else {
        echo "<p>Aucun détail trouvé pour ce plat.</p>";
    }
} else {
    echo "<p>Aucun identifiant de plat spécifié.</p>";
}

// Fermer la connexion à la base de données
$conn->close();
?>

</body>
</html>
