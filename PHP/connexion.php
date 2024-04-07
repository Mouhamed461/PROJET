<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "772013470aa", "cafeteria");

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    // Récupérer les informations soumises par le formulaire
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparer et exécuter la requête SQL pour vérifier les informations d'identification de l'utilisateur
    $sql_admin = "SELECT * FROM administrateurs WHERE username='$nom_utilisateur' AND mot_de_passe='$mot_de_passe'";
    $result_admin = $conn->query($sql_admin);

    $sql_client = "SELECT * FROM clients WHERE nom_utilisateur='$nom_utilisateur' AND mot_de_passe='$mot_de_passe'";
    $result_client = $conn->query($sql_client);

    if ($result_admin->num_rows > 0) {
        // Informations d'identification de l'administrateur valides, enregistrer le nom d'utilisateur dans la session et rediriger vers la page d'accueil avec les privilèges d'administration
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        $_SESSION['admin'] = true;
        header("Location: accueil.php");
        exit();
    } elseif ($result_client->num_rows > 0) {
        // Informations d'identification du client valides, enregistrer le nom d'utilisateur dans la session et rediriger vers la page d'accueil
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        header("Location: accueil.php");
        exit();
    } else {
        // Informations d'identification incorrectes, afficher un message d'erreur
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head> 
<body>

<h1>Connexion</h1>

<?php if(isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nom_utilisateur">Nom d'utilisateur:</label>
    <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>
    <label for="mot_de_passe">Mot de passe:</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>
    <input type="submit" value="Se connecter" name="connexion">
</form>

<a href="inscription.php">S'inscrire</a>

</body>
</html>
