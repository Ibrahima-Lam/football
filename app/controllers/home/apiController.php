<?php

namespace App\Controllers\home;

class ApiController extends Controller
{

    public function __construct()
    {
        header('Content-Type:application/json');
    }

    private function send($data): void
    {
        $json = json_encode($data);
        echo $json;
    }

    public function match(): void
    {
        $matchs = $this->loadModel("matchs")->findAll();
        $this->send($matchs);
    }

    public function joueur($post = null): void
    {
        if ($post) {
            $data = $_GET["data"] ?? "[]";
            $data = json_decode($data, true);
            extract($data);
            $res = $this->loadModel("joueur")->insert($nom, $equipe, $localite);
            $this->send(compact("res"));
            return;
        }
        $joueurs = $this->loadModel("joueur")->findAll();
        $this->send($joueurs);
    }

    public function equipe(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $this->send($equipes);
    }
    public function marque($post = null): void
    {
        if ($post) {
            $data = $_GET["data"] ?? "[]";
            $data = json_decode($data, true);
            extract($data);
            $res = $this->loadModel("but")->insert($joueur, $match, $equipe, $minute, $marque);
            $this->send(compact("res"));
            return;
        }
        $marques = $this->loadModel("but")->findAllMarque();
        $this->send($marques);
    }
    public function but($post = null): void
    {
        if ($post) {
            $data = $_GET["data"] ?? "[]";
            $data = json_decode($data, true);
            extract($data);
            $res = $this->loadModel("but")->insert($joueur, $match, $equipe, $minute, $marque);
            $this->send(compact("res"));
            return;
        }
    }
    public function sanction($post = null): void
    {
        if ($post) {
            $data = $_GET["data"] ?? "[]";
            $data = json_decode($data, true);
            extract($data);
            $res = $this->loadModel("sanction")->insert($joueur, $match, $sanction, $minute);
            $this->send(compact("res"));
            return;
        }
        $sanctions = $this->loadModel("sanction")->findAll();
        $this->send($sanctions);
    }
}
