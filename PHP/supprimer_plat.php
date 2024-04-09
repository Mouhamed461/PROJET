<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "772013470aa";
$base_de_donnees = "cafeteria";

$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_plat = $_GET['id'];

    $sql = "DELETE FROM plat WHERE id_plat = $id_plat";

    if ($conn->query($sql) === TRUE) {
        header("Location: accueil.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du plat : " . $conn->error;
    }
} else {
    echo "ID du plat non spécifié.";
}

$conn->close();
?>
