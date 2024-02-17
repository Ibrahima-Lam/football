<?php

namespace App\Controllers\home;

class JoueurController extends Controller
{

    public function index(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();

        $this->render("joueur/liste", compact("equipes"));
    }
    public function details(): void
    {
        $joueur = $_GET["joueur"] ?? null;
        $player = $this->loadModel("joueur")->findOne($joueur);
        $buts = $this->loadModel("but")->findAllGoalByJoueur($joueur);
        $sanctions = $this->loadModel("sanction")->findAllSanctionByJoueur($joueur);
        $this->render("joueur/details", compact("buts", "sanctions", 'player'));
    }

    public function param(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $joueurs = $this->loadModel("joueur")->findAll();
        $this->render("joueur/param", compact("joueurs", "equipes"));
    }

    public function formulaire(): void
    {
        $this->render("joueur/form");
    }


    public function form(): void
    {
        $team = $_GET["team"] ?? null;

        $equipes = $this->loadModel("equipe")->findAll($team);
        $equipes = ($team) ? array_filter($equipes, function ($element) use ($team): bool {
            return  $element->idParticipant == $team;
        }) : $equipes;

        $this->render("joueur/joueurform", compact("equipes"));
    }

    public function traitement(): void
    {

        extract($_POST);
        $res = $this->loadModel("joueur")->insert($nom, $equipe, $localite);
        if ($res) {
            header('location:?p=joueur');
            exit();
        } else echo "Echec";
    }
}
