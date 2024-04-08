<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirige vers une page d'erreur ou de connexion si l'utilisateur n'est pas un administrateur
    header("Location: erreur.php");
    exit; // Assurez-vous de quitter le script après la redirection
}

// Vérifie si le formulaire a été soumis
if(isset($_POST['ajouter'])) {
    // Assurez-vous que les champs ne sont pas vides
    if(!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['categorie'])) {
        // Connexion à la base de données
        $serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "772013470aa"; // Remplacez "mot_de_passe" par le véritable mot de passe
        $base_de_donnees = "cafeteria";

        $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        // Vérifie la connexion
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Préparation de la requête d'insertion avec des paramètres
        $sql = "INSERT INTO plat (nom, description, prix, categorie) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Liaison des valeurs et exécution de la requête
        $stmt->bind_param("ssds", $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie']);
        if ($stmt->execute()) {
            // Redirige vers la page d'accueil après l'ajout
            header("Location: accueil.php");
            exit(); // Assurez-vous de quitter le script après la redirection
        } else {
            $message = "Erreur lors de l'ajout du plat : " . $stmt->error;
        }

        // Ferme la connexion à la base de données
        $conn->close();
    } else {
        $message = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Plat</title>
    <link rel="stylesheet" href="../CSS/ajout_plat.css">
</head>
<body>

<div class="plat-du-jour">
    <h2>Ajouter Plat</h2>
</div>

<div class="container">
    <div class="plat-container">
        <!-- Formulaire d'ajout de plat -->
       <!-- Formulaire d'ajout de plat avec champ d'ajout d'image -->
<form method="post" action="ajouter_plat.php" enctype="multipart/form-data">
    <label for="nom">Nom du plat:</label><br>
    <input type="text" id="nom" name="nom" required><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br>

    <label for="prix">Prix:</label><br>
    <input type="text" id="prix" name="prix" required><br>

    <label for="categorie">Catégorie:</label><br>
    <input type="text" id="categorie" name="categorie" required><br>

    <input type="submit" name="ajouter" value="Ajouter">
</form>
        <!-- Affichage du message -->
        <?php if(isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>
    </div>
</div>

<div class="button-container">
    <a href="accueil.php"><button>Retour</button></a>
</div>

</body>
</html>
