<html>
<body>
<?php

require_once(__DIR__.'/config/configuration.php');

//chargement autoloader pour autochargement des classes
require_once(__DIR__.'/config/Autoload.php');
Autoload::charger();
Panorama::getInstance("notrePanorama");

//début de la session
session_start();

$ctrl = new ControleVisiteur();



?>
</body>
</html>

