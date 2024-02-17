<?php

namespace App\Controllers\home;

use src\factory\But;
use src\factory\Equipe;
use src\factory\Joueur;
use src\factory\Matchs;

class ButController extends Controller
{

    public function index(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $this->render("but/liste", compact("equipes"));
    }
    public function old(): void
    {
        $buts = $this->loadModel("but")->findAll();
        $this->render("but/old", compact("buts"));
    }

    public function form(): void
    {
        extract(But::form());
        $this->render("but/form", compact("joueurs", "equipes", "matchs", "marques"));
    }
    public function traitement(): void
    {

        extract($_POST);
        $res = $this->loadModel("but")->insert($joueur, $match, $equipe, $minute, $marque);
        if ($res) {
            header('location:?p=but');
            exit();
        } else echo "Echec";
    }
}
