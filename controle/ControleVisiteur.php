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
                /*
                case "formulaireAjoutPhotoCarte":
                    $this->formulaireAjoutPhotoCarte();
                    break; */

                case "ValiderCeChoix" :
                    $this->validerFormulaireCarte();
                    break;

                case "COMMENCER" :
                    $this->debutPano();
                break;

                case "SAVE" :

                    $this->boucle();
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

            $panorama = Panorama::getInstance("");
            $_SESSION['panorama']=$panorama;
            while(false !== ($element = readdir($dir))) {
                if($element != '.' && $element != '..') {
                    $cheminPhoto = "";
                    $cheminPhoto .= $element;
                    $photo = new Photos($cheminPhoto);
                    $panorama::addPhotos($photo);
                }
            }
            //var_dump($panorama::getListPhotos());
            $_SESSION['photos']=$panorama::getListPhotos();

            //var_dump($panorama::getNom());
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

            var_dump($fileName);
            $this->afficherCarte();
            return;
        }
        $this->tableauErreur = $fileName . " : le fichier veut pas bouger (dsl)";
        require($chemin . $lesVues['formCarte']);

    }

    public function afficherCarte(){
        global $chemin, $lesVues;
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
        if($_SESSION['compteur']==count($lesPhotos)){
            unset($_SESSION['compteur']);
            $this->formulaireAjoutPhotoCarte();
            return;
        }
        $photoEnCours=$lesPhotos[$_SESSION['compteur']];
        $_SESSION['compteur']+=1;

        require($chemin.$lesVues['debutpano']);
    }
}