<?php


class Panneau
{
    public string $position;
    public string $message;

    public function __construct(string $text, string $pos)
    {
        $this->message = $text;
        $this->position = $pos;
    }
}