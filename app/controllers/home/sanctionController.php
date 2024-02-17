<?php

namespace App\Controllers\home;

use src\factory\Equipe;
use src\factory\Joueur;
use src\factory\Matchs;
use src\factory\Sanction;

class SanctionController extends Controller
{

    public function index(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $this->render("sanction/liste", compact("equipes"));
    }

    public function suspension(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $sanctions = $this->loadModel("sanction")->findAllSuspension();
        $this->render("sanction/list", compact("sanctions", "equipes"));
    }
    public function sanctionnes(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $matchs = $this->loadModel("matchs")->findAll();
        $sanctions = $this->loadModel("sanction")->findAllSanctionAndSuspension();
        $avertis = $this->loadModel("sanction")->findAllAvertissement();
        $sanctions = Sanction::filterAndMap($sanctions, $matchs, $avertis);
        $this->render("sanction/suspension", compact("sanctions", "equipes"));
    }
    public function suspendus(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $matchs = $this->loadModel("matchs")->findAll();
        $sanctions = $this->loadModel("sanction")->findAllSanctionAndSuspension();
        $avertis = $this->loadModel("sanction")->findAllAvertissement();
        $sanctions = Sanction::filterAndMap($sanctions, $matchs, $avertis);
        $sanctions = Sanction::filterSuspendus($sanctions);
        $this->render("sanction/suspension", compact("sanctions", "equipes"));
    }

    public function avertissement(): void
    {
        $equipes = $this->loadModel("equipe")->findAll();
        $sanctions = $this->loadModel("sanction")->findAllAvertissement();
        $this->render("sanction/list", compact("sanctions", "equipes"));
    }

    public function form(): void
    {
        extract(Sanction::form());
        $this->render("sanction/form", compact("joueurs", "sanctions", "matchs", "equipes"));
    }

    public function edit(): void
    {
        $edit = 1;
        $sct = $_GET["sanction"] ?? null;
        $matchs = $this->loadModel("matchs")->findAll();
        $equipes = $this->loadModel("equipe")->findAll();
        $joueurs = $this->loadModel("joueur")->findAll();
        $sanctions = $this->loadModel("sanction")->findAll();
        $sanction = $this->loadModel("sanction")->findOne($sct);
        $this->render("sanction/form", compact("edit", "sanction", "joueurs", "sanctions", "matchs", "equipes"));
    }

    public function traitement(): void
    {

        extract($_POST);
        if (!empty($edit)) {

            $res = $this->loadModel("sanction")->update($id, $joueur, $match, $sanction, $minute);
            if ($res) {
                header('location:?p=sanction');
                exit();
            } else echo "Echec";
        }
        $res = $this->loadModel("sanction")->insert($joueur, $match, $sanction, $minute);
        if ($res) {
            header('location:?p=sanction');
            exit();
        } else echo "Echec";
    }
}
