<?php


class PointDeNavigation
{
    private string $position;
    private string $destination;

    public function __construct(string $dest, string $pos) {
        $this->destination = $dest;
        $this->position = $pos;
    }
}