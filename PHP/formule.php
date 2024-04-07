<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "772013470aa", "cafeteria");

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formules</title>
</head>
<body>
    <p>Abonnement Premium</p>
    <p>Abonnement Gold</p>
    <p>Abonnement Standard</p>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
