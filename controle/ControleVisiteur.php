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

            $panorama = Panorama::getInstance($nomProjet);
            while(false !== ($element = readdir($dir))) {
                if($element != '.' && $element != '..') {
                    $cheminPhoto = "";
                    $cheminPhoto .= $element;
                    $photo = new Photos($cheminPhoto);
                    $panorama::addPhotos($photo);
                }
            }
            $_SESSION['panorama']=$panorama;

            $_SESSION['photos']=$panorama::getListPhotos();

            $_SESSION['titre']=$panorama::getNom();
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
        $this->tableauErreur = $fileName . " : le fichier veut pas bouger (dsl)";
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
        foreach ($lesPhotos[0]->panneau as $p){
            var_dump($p);
        }
        foreach ($lesPhotos[0]->pointNav as $nav){
            var_dump($nav);
        }
        var_dump($laCarte->sansExtension());
        var_dump($nbPhotos);
        require($chemin . $lesVues['resultat']);
    }
}