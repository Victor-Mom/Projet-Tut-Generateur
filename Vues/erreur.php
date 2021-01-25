
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vues/css/bootstrap.css">
    <link rel="stylesheet" href="vues/css/style.css">
    <title>Erreur</title>
</head>
<body>
    <h1> Erreur </h1>

    <?php

    if (isset($this->tableauErreur)) {
        foreach ($this->tableauErreur as $value){
            echo "<p>$value</p>";
        }
    }
    ?>

    <button type="button" class="btn btn-dark" onclick="location.href='?'">Retour à l'accueil</button>

</body>
</html>