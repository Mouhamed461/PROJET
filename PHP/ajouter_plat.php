<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Plat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            position: relative;
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

<div class="container">
    <div class="plat-du-jour">
        <h2>Ajouter Plat</h2>
    </div>

    <form method="post" action="ajouter_plat.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du plat:</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix:</label>
            <input type="text" class="form-control" id="prix" name="prix" required>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie:</label>
            <input type="text" class="form-control" id="categorie" name="categorie" required>
        </div>
        <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
    </form>

    <?php if(isset($message)) { ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>
</div>

<a href="accueil.php" class="back-button">Retour</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
