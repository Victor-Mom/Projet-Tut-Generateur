<?php

class Photos{

    private string $chemin;
    public array $panneau = [];
    public array $pointNav = [];

    public function __construct(string $chemin)
    {
        $this->chemin = $chemin;
    }

    public function getChemin() : string
    {
        return $this->chemin;
    }

    public function sansExtension() : string
    {
        $nom = substr($this->chemin, 0, strpos($this->chemin, "."));
        return $nom;
    }
}
