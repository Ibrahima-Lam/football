<?php

namespace App\Controllers\home;

use src\App\App;

class GroupeController extends Controller
{

    public function index(): void
    {

        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $edition = App::getCompetition()->getCompetition() ?? null;
        $this->render("groupe/liste", compact("groupes", "edition"));
    }
    public function details(): void
    {
        $groupe = $_REQUEST['groupe'] ?? null;
        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $this->render("groupe/details", compact('groupes', 'groupe'));
    }
    public function equipe(): void
    {
        $groupe = $_REQUEST['groupe'] ?? null;
        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $this->render("groupe/equipe", compact('groupes', 'groupe'));
    }

    public function change(): void
    {
        $grp = $_GET["groupe"] ?? null;
        $groupe = App::getGroupe()->changeGroupe($grp)->idGroupe ?? null;
        var_dump($groupe);

        header('location:?p=groupe');
        exit();
    }
}
