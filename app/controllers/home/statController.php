<?php

namespace App\Controllers\home;



class StatController extends Controller
{

    public function index(): void
    {
        $groupe = $_GET["groupe"] ?? null;

        $groupes = $this->loadModel("groupe")->findAll();

        $this->render("stat/details", compact("groupes", "groupe"));
    }
}
