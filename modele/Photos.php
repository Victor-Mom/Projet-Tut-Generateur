<?php

class Photos{

    public string $photos;
    public $panneau = [];
    public $pointNav = [];

    public function __construct($photos)
    {
        $this->photos = $photos;
    }

    public function addPanneau($panneau){
        array_push($this->panneau, $panneau);
    }

    public function addPointNav($pointNav){
        array_push($this->pointNav, $pointNav);
    }

    public function getNom()
    {
        return $this->photos;
    }

}
