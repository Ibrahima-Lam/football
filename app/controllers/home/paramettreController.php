<?php

namespace App\Controllers\home;

use src\App\App;
use  src\Service\Generateur;

class ParamettreController extends Controller
{
    public function __construct()
    {
        $user = App::getUser()->getUser()->id ?? null;
        $res = <<<Text
            <p class="titre">Vous etes pas connectés, veuillez vous connecter svp!</p>  
            <a href="?p=app/login" class="link mg flex">Se connecter</a>
         Text;
        if (!$user) $this->response($res);
    }

    public function index(): void
    {

        $this->render("paramettre/liste");
    }

    public function generateur(): void
    {
        $games = [];
        $equipes = $this->loadModel("participation")->findAllRegroupement();
        $groupes = $this->loadModel("groupe")->findAll();
        foreach ($groupes as $value) {
            $grp = $value->idGroupe;
            $team = array_filter($equipes, function ($equipe) use ($grp): bool {
                return $equipe->idGroupe === $grp;
            });
            $team = array_combine(range(0, sizeof($team) - 1), $team);
            $tab = Generateur::getMatches($team);
            $games[$value->nomGroupe] = $tab;
        }
        $this->render("paramettre/generateur", compact("games"));
    }
    public function teste(): void
    {
        $games = Generateur::getGames();
        $this->render("paramettre/teste", compact("games"));
    }
    public function team($id): void
    {
        $games = Generateur::getGames();
        $games = array_filter($games, function ($elmt) use ($id): bool {
            return $elmt["home"] == $id || $elmt["away"] == $id;
        });
        $this->render("paramettre/teste", compact("games"));
    }
    public function day($id): void
    {
        $games = Generateur::getGames();
        $games = array_filter($games, function ($elmt) use ($id): bool {
            return $elmt["day"] == $id;
        });
        $this->render("paramettre/teste", compact("games"));
    }
}
