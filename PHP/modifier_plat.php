<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirige vers une page d'erreur ou de connexion si l'utilisateur n'est pas un administrateur
    header("Location: erreur.php");
    exit; // Assurez-vous de quitter le script après la redirection
}

// Vérifie si l'ID du plat à modifier est spécifié dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "root";
    $mot_de_passe = "772013470aa"; // Mot de passe MySQL
    $base_de_donnees = "cafeteria"; // Nom de la base de données

    $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupère l'ID du plat depuis l'URL
    $id_plat = $_GET['id'];

    // Vérifie si le formulaire a été soumis
    if(isset($_POST['modifier'])) {
        // Assurez-vous que les champs ne sont pas vides
        if(!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['categorie'])) {
            // Préparation de la requête de mise à jour avec des paramètres
            $sql = "UPDATE plat SET nom=?, description=?, prix=?, categorie=? WHERE id_plat=?";
            $stmt = $conn->prepare($sql);

            // Liaison des valeurs et exécution de la requête
            $stmt->bind_param("ssdsi", $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie'], $id_plat);
            if ($stmt->execute()) {
                // Redirige vers la page d'accueil après la modification
                header("Location: accueil.php");
                exit(); // Assurez-vous de quitter le script après la redirection
            } else {
                $message = "Erreur lors de la modification du plat : " . $stmt->error;
            }
        } else {
            $message = "Veuillez remplir tous les champs du formulaire.";
        }
    }

    // Requête SQL pour récupérer les informations du plat à modifier
    $sql_select = "SELECT * FROM plat WHERE id_plat=?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id_plat);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        $plat = $result->fetch_assoc();
    } else {
        $message = "Plat non trouvé.";
    }

    // Ferme la connexion à la base de données
    $conn->close();
} else {
    $message = "ID du plat non spécifié.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Plat</title>
    <link rel="stylesheet" href="../CSS/modifier_plat.css"> <!-- Assurez-vous d'inclure votre feuille de style CSS ici -->
</head>
<body>

<div class="plat-du-jour">
    <h2>Modifier Plat</h2>
</div>

<div class="container">
    <div class="plat-container">
        <!-- Formulaire de modification de plat -->
        <form method="post" action="modifier_plat.php?id=<?php echo $id_plat; ?>">
            <label for="nom">Nom du plat:</label><br>
            <input type="text" id="nom" name="nom" value="<?php echo $plat['nom']; ?>" required><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" required><?php echo $plat['description']; ?></textarea><br>

            <label for="prix">Prix:</label><br>
            <input type="text" id="prix" name="prix" value="<?php echo $plat['prix']; ?>" required><br>

            <label for="categorie">Catégorie:</label><br>
            <input type="text" id="categorie" name="categorie" value="<?php echo $plat['categorie']; ?>" required><br>

            <input type="submit" name="modifier" value="Modifier">
        </form>
        <!-- Affichage du message -->
        <?php if(isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>
    </div>
</div>

<!-- Bouton de retour -->
<div class="button-container">
    <a href="accueil.php"><button>Retour</button></a>
</div>

</body>
</html>
