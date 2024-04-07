<?php
session_start();

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "772013470aa", "cafeteria");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les informations soumises par le formulaire
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $email = $_POST['email'];

    // Préparer et exécuter la requête SQL pour insérer les données dans la table clients
    $sql = "INSERT INTO clients (nom_utilisateur, mot_de_passe, email) VALUES ('$nom_utilisateur', '$mot_de_passe', '$email')";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page de connexion avec un message de succès
        header("Location: connexion.php?inscription_success=true");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

<h1>Inscription</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nom_utilisateur">Nom d'utilisateur:</label>
    <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>
    <label for="mot_de_passe">Mot de passe:</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <input type="submit" value="S'inscrire">
</form>

</body>
</html>
