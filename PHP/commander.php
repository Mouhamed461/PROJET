<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commander</title>
    <link rel="stylesheet" href="../CSS/commande.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .hidden {
            display: none;
        }

        .retour-button {
            position: absolute;
            top: 10px;
            left: 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            z-index: 999; /* Assurez-vous que le bouton est au-dessus de tout le reste */
        }

    </style>
</head>

<?php
if(isset($_GET['id']) && isset($_GET['prix'])) {
    $id_plat = $_GET['id'];
    $prix_produit = $_GET['prix'];
} else {
    // Gérer le cas où les paramètres ne sont pas définis
}
?>

<body>
<div class="container">
    <h2>Commander</h2>
    <a href="accueil.php" class="retour-button">Retour</a>

    <form id="commandeForm" action="commander.php" method="post">
        <div class="form-group">
            <label for="methode_paiement">Méthode de paiement :</label>
            <select name="methode_paiement" id="methode_paiement">
                <option selected disabled hidden>Choisir une méthode de paiement</option>
                <option value="carte">Carte de crédit</option>
                <option value="orange_money">Orange Money</option>
                <option value="wave">Wave</option>
            </select>
        </div>

        <div class="form-group hidden" id="champsCarteCredit">
            <label for="numero_carte">Numéro de carte :</label>
            <input type="text" name="numero_carte" id="numero_carte">
            <label for="titulaire_carte">Titulaire de la carte :</label>
            <input type="text" name="titulaire_carte" id="titulaire_carte">
            <label for="expiration_carte">Date d'expiration :</label>
            <input type="date" name="expiration_carte" id="expiration_carte">
            <label for="cvv_carte">Code de sécurité (CVV) :</label>
            <input type="text" name="cvv_carte" id="cvv_carte">
        </div>

        <div class="form-group hidden" id="champsMobileMoney">
            <label for="prenom_nom">Prénom et Nom :</label>
            <input type="text" name="prenom_nom" id="prenom_nom">
        </div>

        <div class="form-group hidden" id="champsMobileMoneyPhone">
            <label for="numero_telephone">Numéro de téléphone :</label>
            <input type="text" name="numero_telephone" id="numero_telephone">
        </div>

        <div class="form-group">
            <label for="lieu_livraison">Lieu de livraison :</label>
            <input type="text" name="lieu_livraison" id="lieu_livraison">
        </div>
        <div class="form-group">
            <label for="montant_total">Montant total à payer :</label>
            <!-- Utilisez le prix du produit récupéré à partir de $_GET -->
            <input type="text" name="montant_total" id="montant_total" readonly value="<?php echo $prix_produit; ?>€">
        </div>
        <button type="submit" class="valider-commande">Valider la commande</button>
    </form>
</div>

<script>

document.addEventListener("DOMContentLoaded", function() {
    var methodePaiement = document.getElementById("methode_paiement");
    var champsCarteCredit = document.getElementById("champsCarteCredit");
    var champsMobileMoney = document.getElementById("champsMobileMoney");
    var champsMobileMoneyPhone = document.getElementById("champsMobileMoneyPhone");

    // Événement lors du changement de la méthode de paiement
    methodePaiement.addEventListener("change", function() {
        var selectedValue = methodePaiement.value;

        // Masquer tous les champs spécifiques
        champsCarteCredit.classList.add("hidden");
        champsMobileMoney.classList.add("hidden");
        champsMobileMoneyPhone.classList.add("hidden");

        // Afficher les champs spécifiques en fonction de la méthode de paiement sélectionnée
        if (selectedValue === "carte") {
            champsCarteCredit.classList.remove("hidden");
        } else if (selectedValue === "orange_money" || selectedValue === "wave") {
            champsMobileMoney.classList.remove("hidden");
            champsMobileMoneyPhone.classList.remove("hidden");
        }
    });

    // Assurez-vous que les champs appropriés sont masqués ou affichés lors du chargement initial de la page
    methodePaiement.dispatchEvent(new Event("change"));
});

</script>

</body>
</html>
