<?php

class Photos{

    private $chemin;
    public $panneau = [];
    public $pointNav = [];
    public $isDone = false;

    public function __construct(string $chemin)
    {
        $this->chemin = $chemin;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone)
    {
        $this->isDone = $isDone;
    }

    public function addPanneau($panneau){
        array_push($this->panneau, $panneau);
    }

    public function addPointNav($pointNav){
        array_push($this->pointNav, $pointNav);
    }

    public function getChemin()
    {
        return $this->chemin;
    }

}
