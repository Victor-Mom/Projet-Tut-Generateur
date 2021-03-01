<?php

class Photos{

    public $photos = "";
    public $panneau = [];
    public $pointNav = [];
    public $isDone = false;


    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

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
