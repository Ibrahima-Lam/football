<?php

namespace src\Service;

trait TraitModel
{

    public static function loadModel($class): mixed
    {
        $model = "App\Modele\\$class";
        return new $model();
    }
}
