<?php

class Panorama
{
    private $listPhotos = [];
    private $nom;
    private static $_instance = null;
    public Photos $photoencours;

    private function __construct($nom)
    {
        $this->nom = $nom;
    }


    public static function getInstance($nom) {
        if(isset(self::$_instance)) {
            self::$_instance = new Panorama($nom);
        }
        return self::$_instance;
    }

    public function getPhotoencours(): Photos
    {
        return $this->photoencours;
    }

    public function setPhotoencours(Photos $photoencours): void
    {
        $this->photoencours = $photoencours;
    }


    public function getListPhotos(): array
    {
        return $this->listPhotos;
    }


    public function addPhotos($photos){
        $photo = new Photos($photos);
        array_push($this->listPhotos, $photo);
    }


    public function find($nomPhoto){
        foreach ($this->listPhotos as $photo){
            if($photo->getNom() == $nomPhoto) return $photo;
        }
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        self::getInstance()->setNom($nom);
    }
}