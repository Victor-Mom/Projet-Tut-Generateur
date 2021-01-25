<?php


class Validation
{
    //Validation de l'action
    static function val_action(string $action)
    {

        return filter_var($action, FILTER_SANITIZE_STRING);

    }



}
