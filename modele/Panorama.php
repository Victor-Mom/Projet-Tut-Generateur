<?php

class Panorama
{
    private $listPhotos = [];
    private $nom;
    private static $_instance = null;

    /**
     * @return array
     */
    public function getListPhotos(): array
    {
        return $this->listPhotos;
    }

    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    public function addPhotos($photos){
        $photo = new Photos($photos);
        array_push($this->listPhotos, $photo);
    }

    public static function getInstance($nomPano) {
        if(is_null(self::$_instance)) {
            self::$_instance = new Panorama($nomPano);
        }
        return self::$_instance;
    }



    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }
}