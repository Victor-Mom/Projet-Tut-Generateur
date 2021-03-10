<?php


class PointDeNavigation
{
    public string $position;
    public string $destination;

    public function __construct(string $dest, string $pos) {
        $this->destination = $dest;
        $this->position = $pos;
    }

    public function sansExtension() : string
    {
        $nom = substr($this->destination, 0, strpos($this->destination, "."));
        $nom = substr($nom, strpos($this->destination, "/")+1);
        return $nom;
    }
}