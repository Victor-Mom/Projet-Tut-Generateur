<?php


class Panneau
{
    public string $position;
    public string $message;
    //private $imageCorrespondante;

    public function __construct(string $text, string $pos)
    {
        $this->message = $text;
        $this->position = $pos;
    }
}