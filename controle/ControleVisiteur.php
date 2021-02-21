<?php


class ControleVisiteur
{
    public $tableauErreur = array();
    public $listPhotos = array();
    private $panorama;

    function __construct()
    {
        global $chemin, $lesVues;

        $action = $_REQUEST['action'];

        try {
            switch ($action) {

                case NULL:
                    $this->accueil(); //appeler page d'accueil
                    break;

                case "formulaireAjoutPhotos":
                    $this->formulaireAjout();
                    break;

                case "valider" :
                    $this->validerFormulaire();
                    break;

                case "COMMENCER" :
                    require($chemin.$lesVues['debutpano']);
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
            require($chemin . $lesVues['panorama']);
        }
    }
}