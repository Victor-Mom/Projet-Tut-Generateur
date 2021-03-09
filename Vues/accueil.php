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

	<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <div id="logo">
                    <img id="logo" src="Vues/photos/logo.png">
                </div>
                <a class="nav-item nav-link active" href="#accueil">Accueil</a>
                <a class="nav-item nav-link active" href="#creation">Créer mon panorama</a>
                <a class="nav-item nav-link active" href="#explications">Comment ça marche ?</a>
                <a class="nav-item nav-link active" href="#exemples">Exemples</a>
            </div>
        </div>
    </nav>
<br>
<!-- ACCUEIL -->

		<section id="accueil">
            <br/>
			<div id="presentation">
				<p><strong>Bienvenue sur notre générateur de panorama !</strong></p>
				<p><strong>Créer sa propre visite virtuelle n'a jamais été aussi simple : </strong></p>
				<p><strong>En 3 clics, découvrer vos photos 360° comme vous ne les avez jamais vues</strong></p>
				<p><strong>Découvrer, explorer ... et partager des moments inoubliables</strong></p>
				<div id="fleches">
						<img id="logo" src="Vues/photos/fleches.png">
				</div>
			</div>


		</section>
<br>
<br>
<br>

<!-- CREER SON PANORAMA -->
		<section id="creation">
                <form method="POST">
				    <div id="boutonCreer">
					    <button name="action" value="TUTORIEL" type="submit" class="btn btn-warning"><strong>Créer mon propre panorama</strong></button>
				    </div>
                </form>
			
		</section>
	
<br>
<br>
<br>


<!-- EXPLICATIONS -->
		<section id="explications">
			<img id="dd" src="Vues/photos/xpli.png">
		</section>
<br>
<br>
<br>

<!-- EXEMPLES -->

		<section id="exemples">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			  <ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				
			  </ol>
			  <div class="carousel-inner">
				<div class="carousel-item active">
				  <img src="Vues/photos/pano.png" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
				  <img src="Vues/photos/carte.png" class="d-block w-100" alt="...">
				</div>
			
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
		</section>
<br>
<br>
<br>
	

<!-- FOOTER -->
 		<footer><p>FERRERE Clément - MOMMALIER Victor - PONCET Clara - VELUT Lucile </p> |<p> DUT Informatique de Clermont-Ferrand </p></footer>

	
<!-- SCRIPTS JS -->
	<!--    <script src="js/jquery-3.4.1.min.js"></script>
	    <script src="js/popper.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/scroll-animate.js"></script> -->
	</body>
</html>
