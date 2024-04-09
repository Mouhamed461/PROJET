<?php
session_start();

$conn = new mysqli("localhost", "root", "772013470aa", "cafeteria");

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql_admin = "SELECT * FROM administrateurs WHERE username='$nom_utilisateur' AND mot_de_passe='$mot_de_passe'";
    $result_admin = $conn->query($sql_admin);

    $sql_client = "SELECT * FROM clients WHERE nom_utilisateur='$nom_utilisateur' AND mot_de_passe='$mot_de_passe'";
    $result_client = $conn->query($sql_client);

    if ($result_admin->num_rows > 0) {
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        $_SESSION['admin'] = true;
        header("Location: accueil.php");
        exit();
    } elseif ($result_client->num_rows > 0) {
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        header("Location: accueil.php");
        exit();
    } else {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background-color: #000;
            color: #fff;
            list-style: none;
            text-decoration: none;
            border-radius: 8px;
        }

        .signup-link:hover {
            background-color: blue;
            color: #fff;
            transition: 0.8s;
            border-radius: 8px;
        }
    </style>
</head> 
<body>

<div class="container">
    <h1>Connexion</h1>

    <?php if(isset($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="nom_utilisateur" class="form-label">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe:</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <button type="submit" class="btn btn-primary" name="connexion">Se connecter</button>
    </form>

    <a href="inscription.php" class="signup-link">S'inscrire</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
