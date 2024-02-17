<?php

namespace App\Controllers\api;

class StatController extends apiController
{

    public function index(): void
    {
        $matchs = $this->loadModel("matchs")->findAll();
        $equipes = $this->loadModel("participation")->findAllRegroupement();
        $groupes = $this->loadModel("groupe")->findAll();
        $data = [];
        foreach ($groupes as $key => $value) {
            $games = array_filter($matchs, function ($element) use ($value): bool {
                return $element->idGroupe === $value->idGroupe;
            });

            $teams = array_filter($equipes, function ($element) use ($value): bool {
                return $element->idGroupe === $value->idGroupe;
            });

            $clss = new \src\Service\Classeur($games, $teams);
            $data[$value->nomGroupe] = $clss->classer();
        }
        $this->response($data);
    }
}
