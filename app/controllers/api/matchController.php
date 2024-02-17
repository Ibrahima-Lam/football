<?php

namespace App\Controllers\api;

class MatchController extends apiController
{

    public function index(): void
    {
        $matchs = $this->loadModel("matchs")->findAll();
        $this->response($matchs);
    }
}
