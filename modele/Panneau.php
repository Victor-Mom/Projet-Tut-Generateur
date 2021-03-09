<?php


class Panneau
{
    private string $position;
    private string $message;
    //private $imageCorrespondante;

    public function __construct(string $text, string $pos)
    {
        $this->message = $text;
        $this->position = $pos;
    }
}