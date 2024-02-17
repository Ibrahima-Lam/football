<?php

namespace App\Controllers\api;

use src\Service\TraitModel;

use function PHPSTORM_META\type;

class ApiController
{
    use TraitModel;
    public function __construct()
    {
        header('Content-Type:application/json');
    }


    public function response($data): void
    {
        echo is_string($data) ? $data : json_encode($data);
    }
}
