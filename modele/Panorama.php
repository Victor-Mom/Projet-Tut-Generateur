<?php

class Panorama
{
    private $listPhotos = [];
    private $panneau = [];
    private $pointNav = [];
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

    public static function getInstance($nomPano) {
        if(is_null(self::$_instance)) {
            self::$_instance = new Panorama($nomPano);
        }
        return self::$_instance;
    }

    public function addPanneau($panneau){
        array_push($this->panneau, $panneau);
    }

    public function addPointNav($pointNav){
        array_push($this->pointNav, $pointNav);
    }

    public function addPhotos($photos){
        array_push($this->listPhotos, $photos);
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }
}