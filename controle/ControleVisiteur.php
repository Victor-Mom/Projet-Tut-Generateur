<?php


class ControleVisiteur
{
    public $tableauErreur = array();

    function __construct()
    {
        global $chemin, $lesVues;
        $action = $_REQUEST['action'];

        try {
            switch ($action) {

                case NULL:
                    $this->accueil();
                    break;

                case "formulaireAjoutPhotos":
                    $this->formulaireAjout();
                    break;

                case "valider" :
                    $this->validerFormulaire();
                    break;

                case "ValiderCeChoix" :
                    $this->validerFormulaireCarte();
                    break;

                case "TUTORIEL" :
                    $this->tuto();
                    break;

                case "COMMENCER" :
                    $this->debutPano();
                    break;

                case "SAVE" :
                    $this->boucle();
                    break;

                case "SaveCarte" :
                    $this->saveCarte();
                    break;

                case "boutonTelecharger" :
                    $this->generation();
                    break;

                default:
                    $this->tableauErreur[] = "Mauvais appel php";
                    require($chemin . $lesVues['erreur']);
                    break;
            }

        } catch (Exception $e) {
            $this->tableauErreur[] = "Erreur inattendue";
            require($chemin . $lesVues['erreur']);
        }
        exit(0);
    }

    public function accueil()
    {
        global $chemin, $lesVues;


        if (!empty($this->tableauErreur)) {
            require($chemin . $lesVues['erreur']);
        } else {
            require($chemin . $lesVues['accueil']);
        }
    }

    public function formulaireAjout() {
        global $chemin, $lesVues;
        require($chemin . $lesVues['form']);
    }

    public function validerFormulaire()
    {
        global $chemin, $lesVues;

        $nomProjet=Validation::val_texte($_POST['nomProjet']);
        echo $nomProjet;
        if (!isset($nomProjet)) {
            $this->tableauErreur='nom de projet invalide/vide';
        }

        $cpt = 0;
        $maxFileSize = 20000000;
        $fileExt = array('.jpg', '.png', '.jpeg');
        $total_fichier_upload = count($_FILES['photos']['tmp_name']);

        for ($i = 0; $i < $total_fichier_upload; $i++) {
            $fileName = $_FILES['photos']['name'][$i];
            $extFichierSubmit = "." . strtolower(substr(strrchr($fileName, "."), 1));

            if (!in_array($extFichierSubmit, $fileExt)) {
                $this->tableauErreur = $fileName . " : n'est pas une image au format .png, .jpg ou .jpeg";
                require($chemin . $lesVues['form']);
                break;
            }
            if ($maxFileSize < $_FILES['photos']['size'][$i]) {
                $this->tableauErreur= $fileName . " : Fichier trop volumineux";
                require($chemin . $lesVues['form']);
                break;
            } else {
                if(!file_exists ( "photosUpload" )){
                    mkdir("photosUpload");
                }
                $fileName = "photosUpload/" . $fileName;
                $reussi = move_uploaded_file($_FILES['photos']['tmp_name'][$i], $fileName);
                if ($reussi) {
                    $cpt = $cpt +1;
                }
            }
        }
        if($cpt == $total_fichier_upload){
            $dir_nom = __DIR__."/../photosUpload";
            $dir =  opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas');
            $lesPhotos = [];

            while(false !== ($element = readdir($dir))) {
                if($element != '.' && $element != '..') {
                    $cheminPhoto = "";
                    $cheminPhoto .= $element;
                    $photo = new Photos($cheminPhoto);
                    $lesPhotos [] = $photo;
                }
            }
            $_SESSION['photos']=$lesPhotos;

            $_SESSION['titre']=$nomProjet;

            closedir($dir);
            require($chemin . $lesVues['panorama']);
        }
    }

    public function formulaireAjoutPhotoCarte() {
        global $chemin, $lesVues;

        require($chemin . $lesVues['formCarte']);
    }

    public function validerFormulaireCarte()
    {
        global $chemin, $lesVues;


        $maxFileSize = 20000000;
        $fileExt = array('.jpg', '.png', '.jpeg');

        $fileName = $_FILES['photoCarte']['name'];
        $extFichierSubmit = "." . strtolower(substr(strrchr($fileName, "."), 1));

        if (!in_array($extFichierSubmit, $fileExt)) {
            $this->tableauErreur = $fileName . " : n'est pas une image au format .png, .jpg ou .jpeg";
            require($chemin . $lesVues['formCarte']);
        }


        if ($maxFileSize < $_FILES['photoCarte']['size']) {
            $this->tableauErreur = $fileName . " : Fichier trop volumineux";
            require($chemin . $lesVues['formCarte']);

        } else {
            if (!file_exists("photosUpload")) {
                mkdir("photosUpload");
            }
            $fileName = "photosUpload/" . $fileName;
            $reussi = move_uploaded_file($_FILES['photoCarte']['tmp_name'], $fileName);
        }

        if ($reussi) {
            $fileName = substr($fileName, strpos($fileName, "/")+1);
            $carte = new Photos($fileName);
            $_SESSION['carte'] = $carte;
            $this->afficherCarte();
            return;
        }
        $this->tableauErreur = $fileName . " : erreur création fichier";
        require($chemin . $lesVues['formCarte']);

    }

    public function afficherCarte(){
        global $chemin, $lesVues;
        $laCarte = $_SESSION['carte'];
        require($chemin.$lesVues['carte']);
    }

    public function debutPano()
    {
        global $chemin, $lesVues;

        $lesPhotos=$_SESSION['photos'];

        $cheminPhoto = filter_var($_POST['photo1'],FILTER_SANITIZE_STRING);

        foreach ($lesPhotos as $p){
            if($p->getChemin() == $cheminPhoto) {

                $photoEnCours=$p;
            }
        }
        $index=array_search($photoEnCours,$lesPhotos);
        unset($lesPhotos[$index]);
        array_unshift($lesPhotos,$photoEnCours);
        $_SESSION['photos']=$lesPhotos;

        require($chemin.$lesVues['debutpano']);
    }

    public function boucle(){
        global $chemin, $lesVues;
        $lesPhotos=$_SESSION['photos'];

        if(!isset($_SESSION['compteur'])){ $_SESSION['compteur']=1;}

        $indexPhoto = filter_var($_SESSION['compteur'],FILTER_SANITIZE_NUMBER_INT);

        $photoTerminee = $lesPhotos[$indexPhoto-1];

        $nbItem = filter_var($_POST['nbElements'],FILTER_SANITIZE_NUMBER_INT);

        if ($nbItem != 0) {
            for ($i=0 ; $i < $nbItem ; $i++) {
                $nom = 'item'. $i;
                $type = $_POST[$nom];
                $i++;
                $nom = 'item'. $i;
                $valeur = filter_var($_POST[$nom],FILTER_SANITIZE_STRING);
                $i++;
                $nom = 'item'. $i;
                $coord = filter_var($_POST[$nom],FILTER_SANITIZE_STRING);
                if ($type == 'panneau') {
                    $panneau  = new Panneau($valeur,$coord);
                    $photoTerminee->panneau[] = $panneau;
                }
                elseif ($type == 'point') {
                    $point = new PointDeNavigation($valeur,$coord);
                    $photoTerminee->pointNav[] = $point;
                }
            }
        }

        $lesPhotos[$indexPhoto-1] = $photoTerminee;

        if($indexPhoto==count($lesPhotos)){
            unset($_SESSION['compteur']);
            $this->formulaireAjoutPhotoCarte();
            return;
        }

        $photoEnCours=$lesPhotos[$indexPhoto];
        $_SESSION['compteur'] = $indexPhoto + 1;
        $_SESSION['photos'] = $lesPhotos;

        require($chemin.$lesVues['debutpano']);
    }

    public function saveCarte() {
        global $chemin, $lesVues;

        $laCarte = $_SESSION['carte'];

        $nbItem = filter_var($_POST['nbElements'],FILTER_SANITIZE_NUMBER_INT);
        if ($nbItem != 0) {
            for ($i=0 ; $i < $nbItem ; $i++) {
                $nom = 'item'. $i;
                $dest = $_POST[$nom];
                $i++;
                $nom = 'item'. $i;
                $coord = filter_var($_POST[$nom],FILTER_SANITIZE_STRING);
                $point = new PointDeNavigation($dest,$coord);
                $laCarte->pointNav[] = $point;
            }
        }

        $_SESSION['carte'] = $laCarte;

        require($chemin . $lesVues['fin']);
    }

    public function tuto() {
        global $chemin, $lesVues;
        require($chemin . $lesVues['tuto']);
    }

    public function generation() {
        global $chemin, $lesVues;

        $lesPhotos = $_SESSION['photos'];
        $nbPhotos = count($lesPhotos);
        $laCarte = $_SESSION['carte'];

        $entete = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panorama</title>
    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-slice9-component/dist/aframe-slice9-component.min.js"></script>
    <script src="https://unpkg.com/aframe-look-at-component@0.5.1/dist/aframe-look-at-component.min.js"></script>
    <script src="https://unpkg.com/aframe-animation-component@^4.1.2/dist/aframe-animation-component.min.js"></script>
    <script src="js/spots.js"></script>
</head>
<body>
<a-scene>';
        $asset = '<a-assets>
        <img id="fleche" src="icones/fleche.png" height="357" width="367" alt=""/>
        <img id="map" src="icones/map.png" height="256" width="256" alt=""/>
        <img id="fondBlanc" src="icones/fondBlanc.png" height="256" width="256" alt=""/>
        <img id="logoJaune" src="icones/logoJaune.png" alt=""/>';
        foreach ($lesPhotos as $photo) {
            $asset .= '<img id="' . $photo->sansExtension() . '" src="photos/' . $photo->getChemin() . '" height="2688" width="5376" alt=""/>';
        }
        $asset .= '<img id="' . $laCarte->sansExtension() . '" src="photos/' . $laCarte->getChemin() . '" height="400" width="800" alt=""/>';
        $asset .= '</a-assets>';

        $skyBox = '<a-sky id="skybox" src="#' . $lesPhotos[0]->sansExtension() . '"></a-sky>';
        $camera = '<a-entity id="cam" camera position="0 1.6 0" look-controls wasd-controls="enabled:false">
        <a-entity cursor="fuse:true;fuseTimeout:2000"
                  geometry="primitive:ring;radiusInner:0.01;radiusOuter:0.02"
                  position="0 0 -1.8"
                  material="shader:flat;color:blue">
        </a-entity>
    </a-entity>';

        $lesGroupes = '<a-entity id="spots" hotspots>';
        $lesGroupes .= '<a-entity id="group-' . $lesPhotos[0]->sansExtension() . '" scale="1 1 1">';
        $lesGroupes .= '<a-image spot="linkto:#fondBlanc;spotgroup:group-fondBlanc" 
                position="-1 -3 -6" src="#map" look-at="#cam"></a-image>';
        foreach ($lesPhotos[0]->panneau as $p){
            $lesGroupes .=  '<a-entity slice9="width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: icones/tooltip.png"
                          text="value:' . $p->message . ';wrap-count:15; width:5; align:center;zOffset:0.05" ; 
                          look-at="#cam" position="' . $p->position . '"></a-entity>';
        }
        foreach ($lesPhotos[0]->pointNav as $nav) {
            $lesGroupes .=  '<a-image spot="linkto:#' . $nav->sansExtension() .
                ';spotgroup:group-' . $nav->sansExtension() . '"
                    position="' . $nav->position . '" src="#fleche" look-at="#cam"></a-image>';
        }
        $lesGroupes .=  '</a-entity>';

        for ($i = 1 ; $i < $nbPhotos ; $i++) {
            $lesGroupes .= '<a-entity id="group-' . $lesPhotos[$i]->sansExtension() . '" scale="0 0 0">';
            $lesGroupes .= '<a-image spot="linkto:#fondBlanc;spotgroup:group-fondBlanc" 
                        position="-1 -3 -6" src="#map" look-at="#cam"></a-image>';
            foreach ($lesPhotos[$i]->panneau as $p){
                $lesGroupes .= '<a-entity slice9="width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: icones/tooltip.png"
                          text="value:' . $p->message . ';wrap-count:15; width:5; align:center;zOffset:0.05" ; 
                          look-at="#cam" position="' . $p->position . '"></a-entity>';
            }
            foreach ($lesPhotos[$i]->pointNav as $nav) {
                $lesGroupes .= '<a-image spot="linkto:#' . $nav->sansExtension() . ';spotgroup:group-' . $nav->sansExtension() . '"
                         position="' . $nav->position . '" src="#fleche" look-at="#cam"></a-image>';
            }
            $lesGroupes .= '</a-entity>';
        }

        $lesGroupes .= '<a-entity id="group-fondBlanc" scale="0 0 0">';
        $lesGroupes .= '<a-plane position="-1.89574 1.6 -1.96425" src="#' . $laCarte->sansExtension() . '" look-at="#cam" height="4" width="6"  rotation="0 43.98317825991033 0">
    </a-plane>';
        foreach ($laCarte->pointNav as $nav) {
            $lesGroupes .= '<a-image spot="linkto:#' . $nav->sansExtension() . ';spotgroup:group-' . $nav->sansExtension() . '"
                             height="0.480" width="0.300" position="' . $nav->position . '" src="#logoJaune" look-at="#cam"></a-image>';
        }
        $lesGroupes .= '</a-entity>';
        $lesGroupes .= '</a-entity>';

        $fin = '</a-scene>

</body>
</html>';

        $sauvegarde = $entete . $asset . $skyBox . $camera . $lesGroupes . $fin;

        file_put_contents("index.html",$sauvegarde);

        //CREATION DU FICHIER ZIP

        $zip = new ZipArchive();
        $ret = $zip->open(Validation::val_texte($_SESSION['titre']).'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($ret !== TRUE) {
            echo "A échoué avec le code d'erreur " . $ret;
        } else {

            //On ajoute les icones au fichier zip
            $options = array('add_path' => 'icones/', 'remove_all_path' => TRUE);
            $zip->addGlob('Vues/photos/fleche.png', GLOB_BRACE, $options);
            $zip->addGlob('Vues/photos/fondBlanc.png', GLOB_BRACE, $options);
            $zip->addGlob('Vues/photos/map.png', GLOB_BRACE, $options);
            $zip->addGlob('Vues/photos/tooltip.png', GLOB_BRACE, $options);
            $zip->addGlob('Vues/photos/logoJaune.png', GLOB_BRACE, $options);

            //On ajoute le script JS
            $options = array('add_path' => 'js/', 'remove_all_path' => TRUE);
            $zip->addGlob('Vues/js/spots.js', GLOB_BRACE, $options);

            //On ajoute les photos uploadées au fichier zip
            $options = array('add_path' => 'photos/', 'remove_all_path' => TRUE);
            $zip->addGlob('./photosUpload/*.{png,PNG,jpg,JPG}', GLOB_BRACE, $options);

            //On ajoute le fichier résultat
            $options = array('add_path' => ' ', 'remove_all_path' => TRUE);
            $zip->addGlob('index.html', GLOB_BRACE, $options);
        }

        $zip->close();

        $file = Validation::val_texte($_SESSION['titre']).'.zip';

        if (file_exists($file)) {
            ob_start();
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            while (ob_get_level()) {
                ob_end_clean();
            }
            readfile($file);
            exit;
        }

        session_unset();

        require($chemin . $lesVues['accueil']);
    }
}