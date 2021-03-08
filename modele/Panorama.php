<?php

class Panorama
{
    private static array $_listPhotos = [];
    private static string $_nom = "blabla";
    private static ?Panorama $_instance = null;
    private static ?Photos $_photoencours = null;

    public static function getInstance($nom): Panorama {
        if(self::$_instance == null) {
            self::$_instance = new self();
            self::$_nom = $nom;
        }
        return self::$_instance;
    }

    public static function getPhotoencours(): ?Photos
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

    public static function addPhotos(Photos $photo){
        array_push(self::$_listPhotos, $photo);
    }


    public static function find(string $chemin) : ?Photos {
        foreach (Panorama::getListPhotos() as $p){
            if($p->getChemin() == $chemin) {
                var_dump($p->getChemin());
                return $p;
            }
        }
        return null;
    }

    public static function getNom() : string
    {
        return self::$_nom;
    }
}