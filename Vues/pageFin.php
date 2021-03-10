<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="Vues/css/bootstrap.css">
    <link rel="stylesheet" href="Vues/css/style.css">

    <title>Panorama finalisé</title>
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
    <section id="accueil">
        <div id="presentation"">
            <p><strong>Bravo, votre panorama est terminé !</strong></p>
            <p><strong>Vous pouvez maintenant le télécharger en cliquant sur le bouton ci-dessous. </strong></p>
            <p><strong>Après l'avoir téléchargé, vous pourrez le visualiser via la page d'accueil en cliquant sur le bouton "Charger un panorama existant".</strong></p>
            <div id="fleches">
                <img id="logo" src="Vues/photos/fleches.png">
            </div>
        </div>
    </section>
    <br/>
    <br/>
    <br/>

    <section id="creation">
        <form method="POST">
            <div id="boutonCreer">
                <button name="action" value="boutonTelecharger" type="submit" class="btn btn-warning"><strong>Télécharger</strong></button>
            </div>
        </form>
    </section>
    <footer><p>FERRERE Clément - MOMMALIER Victor - PONCET Clara - VELUT Lucile </p> |<p> DUT Informatique de Clermont-Ferrand </p></footer>

</body>
</html>