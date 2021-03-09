<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="Vues/css/bootstrap.css">
    <link rel="stylesheet" href="Vues/css/style.css">

    <title>Générateur de panorama</title>
</head>

<!-- MENU NAV #FFD700 -->

<body >
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <div id="logo">
                <img id="logo" src="Vues/photos/logo.png">
            </div>
            <a class="nav-item nav-link active" href="index.php">Accueil</a>

        </div>
    </div>
</nav>
<br>

<div>
    <div>
        <form method="POST" action="index.php?action=ValiderCeChoix" enctype="multipart/form-data">
            <br/>

            <br/>
            <br/>
            <br/>

            <div class="text-center text-white">
                <h4 class="text-center">Veuillez selectionner l'image de fond de la carte: (.png / .jpg)</h4>
                <input class="btn btn-warning" type="file"  name="photoCarte" >
                <br/>
                <?php
                if (isset($this->tableauErreur)) {
                    if (!empty($this->tableauErreur)) {
                        echo "<p>$this->tableauErreur</p>";
                    }
                }
                ?>
            </div>


            <br/>
            <div class="text-center">
                <div class="button-login">
                    <input class="btn btn-warning" type="submit" name="action" value="ValiderCeChoix">
                </div>
            </div>


        </form>
    </div>
</div>
</body>
<footer class="align-bottom fixed-bottom"><p>FERRERE Clément - MOMMALIER Victor - PONCET Clara - VELUT Lucile </p> |<p> DUT Informatique de Clermont-Ferrand </p></footer>

</html>

