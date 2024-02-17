<?php
spl_autoload_register(function ($class) {
    $path = str_replace("\\", "/", $class);
    $remote = "../" . $path . ".php";
    if (file_exists($remote)) require_once $remote;
    else {
        throw new Exception("Fichier no  trouvé", 1);
    }
});
