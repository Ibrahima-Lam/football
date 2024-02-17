<?php

namespace App\Controllers\api;

class EquipeController extends apiController
{

    public function index(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $this->response($equipes);
    }
}
