<?php


class ControleVisiteur
{
    function __construct(?string $action)
    {
        global $chemin, $lesVues;

        try {
            switch ($action) {

                case NULL:
                    $this->accueil(); //appeler page d'accueil
                    break;

                case AJOUT_PHOTOS :
                    $this->ajoutPhotos();
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