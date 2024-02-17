<?php

namespace App\Controllers\api;



class GroupeController extends ApiController
{


    public function index(): void
    {

        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $this->response($groupes);
    }
}
