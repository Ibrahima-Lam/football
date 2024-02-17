<?php

namespace App\Controllers\api;


class JoueurController extends apiController
{

    public function index(): void
    {
        $joueurs = $this->loadModel("joueur")->findAll();
        $this->response($joueurs);
    }

    public function sanction($team = null): void
    {
        $joueurs = $this->loadModel("sanction")->findAllSanctionAndSuspension($team);
        $this->response($joueurs);
    }
    public function sanctionner($team = null): void
    {
        $joueurs = $this->loadModel("sanction")->findAllSanction($team);
        $this->response($joueurs);
    }
    public function avertissement(): void
    {
        $sanctions = $this->loadModel("sanction")->findAllAvertissement();
        $this->response($sanctions);
    }

    public function suspension(): void
    {
        $sanctions = $this->loadModel("sanction")->findAllSuspension();
        $this->response($sanctions);
    }

    public function but(): void
    {
        $joueurs = $this->loadModel("but")->findAllGoalGame();
        $this->response($joueurs);
    }


    public function buteur(): void
    {
        $buteurs = $this->loadModel("but")->findAll();

        $buteurs = (sizeof($buteurs) == 0) ? [] : array_map(function ($elmt, $a): mixed {
            $elmt->num = $a;
            return $elmt;
        }, $buteurs, range(1, sizeof($buteurs)));
        $this->response($buteurs);
    }
}
