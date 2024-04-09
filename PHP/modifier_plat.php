<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: erreur.php");
    exit;
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $serveur = "localhost";
    $utilisateur = "root";
    $mot_de_passe = "772013470aa";
    $base_de_donnees = "cafeteria";

    $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $id_plat = $_GET['id'];

    if(isset($_POST['modifier'])) {
        if(!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['categorie'])) {
            $sql = "UPDATE plat SET nom=?, description=?, prix=?, categorie=? WHERE id_plat=?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("ssdsi", $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie'], $id_plat);
            if ($stmt->execute()) {
                header("Location: accueil.php");
                exit();
            } else {
                $message = "Erreur lors de la modification du plat : " . $stmt->error;
            }
        } else {
            $message = "Veuillez remplir tous les champs du formulaire.";
        }
    }

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .plat-du-jour {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn {
            width: 100%;
            margin-top: 20px;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            z-index: 999;
        }
    </style>
</head>
<body>

<div class="plat-du-jour">
    <h2>Modifier Plat</h2>
</div>

<div class="container">
    <div class="plat-container">
        <form method="post" action="modifier_plat.php?id=<?php echo $id_plat; ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du plat:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $plat['nom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $plat['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?php echo $plat['prix']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie:</label>
                <input type="text" class="form-control" id="categorie" name="categorie" value="<?php echo $plat['categorie']; ?>" required>
            </div>
            <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
        </form>
        <?php if(isset($message)) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    </div>
</div>

<a href="accueil.php" class="back-button">Retour</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
