<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "772013470aa", "cafeteria");

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les informations soumises par le formulaire
$username = $_POST['username'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

// Vérifier les informations d'identification et rediriger en conséquence
if ($user_type === 'admin') {
    // Vérifier les informations d'identification de l'administrateur dans la base de données
    $sql = "SELECT * FROM administrateurs WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Informations d'identification de l'administrateur valides, rediriger vers la page d'accueil pour l'administrateur
        $_SESSION['admin'] = true;
        header('Location: accueil.php?admin=true');
        exit();
    }
} elseif ($user_type === 'client') {
    // Vérifier les informations d'identification du client dans la base de données
    $sql = "SELECT * FROM clients WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Informations d'identification du client valides, rediriger vers la page d'accueil pour le client
        $_SESSION['client'] = true;
        header('Location: accueil.php?client=true');
        exit();
    }
}

// Informations d'identification incorrectes, rediriger vers la page de connexion avec un message d'erreur
header('Location: connexion.php?error=true');
exit();

// Fermer la connexion à la base de données
$conn->close();
?>
