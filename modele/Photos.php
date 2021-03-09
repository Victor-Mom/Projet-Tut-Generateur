<?php

class Photos{

    private string $chemin;
    public array $panneau = [];
    public array $pointNav = [];

    public function __construct(string $chemin)
    {
        $this->chemin = $chemin;
    }

    public function addPanneau($panneau){
        array_push($this->panneau, $panneau);
    }

    public function addPointNav($pointNav){
        array_push($this->pointNav, $pointNav);
    }

    public function getChemin() : string
    {
        return $this->chemin;
    }

}
