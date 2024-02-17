<?php

use  src\Service\Database;

require_once "../autoload/autoloder.php";

$p = $_GET["p"] ?? "app/index";
$args = explode("/", $p);
$class = $args[0] ?? null;

$controller = "App\Controllers\home\\" . $class . "Controller";
$methode = $args[1] ?? "index";

if (strtoupper($args[0]) == strtoupper('api')) {
    $class = $args[1] ?? null;
    $methode = $args[2] ?? "index";
    $controller = "App\Controllers\api\\" . $class . "Controller";
    unset($args[2]);
}
unset($args[0]);
unset($args[1]);

$instance = new $controller;
try {
    call_user_func_array([$instance, $methode], $args ?? []);
} catch (\Throwable $th) {

    if (strtoupper($class) === "API") echo "{res:error}";
    else echo "error 404 " . $th;
}
