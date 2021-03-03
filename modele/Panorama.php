<?php

class Panorama
{
    private static $_listPhotos = [];
    private static $_nom = "blabla";
    private static $_instance = null;
    private static $_photoencours = null;

    public static function getInstance($nom): Panorama {
        if(self::$_instance == null) {
            self::$_instance = new self();
            self::$_nom = $nom;
        }
        return self::$_instance;
    }

    public static function getPhotoencours(): Photos
    {
        return self::$_photoencours;
    }

    public static function setPhotoencours(Photos $photoencours)
    {
        self::$_photoencours = $photoencours;
    }


    public static function getListPhotos(): array
    {
        return self::$_listPhotos;
    }


    public static function addPhotos($photos){
        $photo = new Photos($photos);
        array_push(self::$_listPhotos, $photo);
    }


    public static function find($nomPhoto) : ?Photos {
        foreach (self::$_listPhotos as $photo){
            if($photo->getNom() == $nomPhoto) return $photo;
        }
        return null;
    }

    public static function getNom()
    {
        return self::$_nom;
    }
}