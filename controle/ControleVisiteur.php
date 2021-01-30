<?php


class ControleVisiteur
{
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
                    require($chemin.$lesVues['form']);
                    break;

                case "Valider" :
                    $maxFileSize = 500000;
                    $fileExt = array('.jpg','.png','.jpeg');
                    $total_fichier_uploade = count($_FILES['photos']['tmp_name']);

                    for ($i=0; $i < $total_fichier_uploade ; $i++) {
                        $fileName = $_FILES['photos']['name'][$i];
                        $extFichierSubmit = "." . strtolower(substr(strrchr($fileName, "."), 1));

                        if (!in_array($extFichierSubmit, $fileExt)) {
                            $taberr = $fileName." : n'est pas une image au format .png, .jpg ou .jpeg";
                            require($chemin . $lesVues['form']);
                            break;
                        }
                        if ($maxFileSize < $_FILES['photos']['size'][$i]) {
                            $taberr = $fileName." : Fichier trop volumineux";
                            require($chemin . $lesVues['form']);
                            break;
                        }
                        else {
                            $fileName = "photosUpload/" . $fileName;
                            $reussi = move_uploaded_file($_FILES['photos']['tmp_name'][$i], $fileName);
                            if ($reussi) {
                                require($chemin . $lesVues['panorama']);
                            }
                            //$this->ajoutPhotos();
                        }
                    }
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

    public function accueil() {
        global $chemin, $lesVues;


        if (!empty($this->tableauErreur)) {
            require($chemin . $lesVues['erreur']);
        }
        else {
            require($chemin . $lesVues['accueil']);
        }
    }

    public function ajoutPhotos() {
        $m = new ModeleDonnees();
        //On récupère les photos via le formulaire
        //On les valide
        $m->ajoutPhotos();
    }
}