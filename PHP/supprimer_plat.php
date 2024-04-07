<?php
// Votre code de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "772013470aa";
$base_de_donnees = "cafeteria";

// Connexion à la base de données
$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérifier si l'ID du plat à supprimer a été spécifié dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_plat = $_GET['id'];

    // Requête SQL pour supprimer le plat de la base de données
    $sql = "DELETE FROM plat WHERE id_plat = $id_plat";

    if ($conn->query($sql) === TRUE) {
        // Rediriger vers la page d'accueil après la suppression
        header("Location: accueil.php");
        exit();
    } else {
        // Gérer les erreurs s'il y a un problème avec la suppression
        echo "Erreur lors de la suppression du plat : " . $conn->error;
    }
} else {
    // Gérer le cas où l'ID du plat n'est pas spécifié dans l'URL
    echo "ID du plat non spécifié.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
