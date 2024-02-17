<?php

namespace App\Controllers\home;

class EquipeController extends Controller
{

    public function index(): void
    {

        $this->render("equipe/liste");
    }
    public function details(): void
    {

        $equipe = $_GET["equipe"] ?? null;
        $equipes = $this->loadModel("equipe")->findAll();
        $this->render("equipe/details", compact('equipe', 'equipes'));
    }
    public function param(): void
    {


        $equipes = $this->loadModel("participation")->findAllRegroupement();
        $groupes = $this->loadModel("groupe")->findAllGroupe();

        $this->render("equipe/param", compact('groupes', 'equipes'));
    }
}
