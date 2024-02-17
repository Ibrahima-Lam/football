<?php

namespace App\Controllers\home;

use src\App\App;

class TraitementController extends Controller
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
    private function extraire(?string $data = null)
    {
        return json_decode($data ?? $_GET["data"] ?? '[]', true);
    }
    private function compacte($data)
    {
        return json_encode($data, true);
    }
    public function competition(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("competition")->update($code, $nom, $localite)
            :  $this->loadModel("competition")->insert($code, $nom, $localite);
        $this->response(['res' => $res]);
    }

    public function edition(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("competition")->updateEdition($code, $annee, $nom, $competition)
            :  $this->loadModel("competition")->insertEdition($code, $annee, $nom, $competition);
        $this->response(['res' => $res]);
    }
    public function groupe(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("groupe")->update($id, $nom, $phase, $edition)
            :  $this->loadModel("groupe")->insert(null, $nom, $phase,  $edition);
        $this->response(['res' => $res]);
    }
    public function equipe(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("equipe")->update($id, $nom, $libelle, $localite)
            :  $this->loadModel("equipe")->insert(null, $nom, $libelle, $localite);
        $this->response(['res' => $res]);
    }

    public function participant(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("equipe")->updateParticipant($id, $equipe, $edition)
            :  $this->loadModel("equipe")->insertParticipant(null, $equipe, $edition);
        $this->response(['res' => $res]);
    }

    public function participation(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("participation")->update($id, $groupe, $equipe)
            :  $this->loadModel("participation")->insert(null, $groupe, $equipe);
        $this->response(['res' => $res]);
    }
    public function joueur(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("joueur")->update($id, $nom, $equipe, $localite)
            :  $this->loadModel("joueur")->insert(null, $nom, $equipe, $localite);
        $this->response(['res' => $res]);
    }
    public function sanction(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("sanction")->update($id, $joueur, $match, $sanction, $minute)
            :  $this->loadModel("sanction")->insert(null, $joueur, $match, $sanction, $minute);
        $this->response(['res' => $res]);
    }
    public function but(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("but")->update($id, $joueur, $match, $equipe, $minute, $marque)
            :  $this->loadModel("but")->insert(null, $joueur, $match, $equipe, $minute, $marque);
        $this->response(['res' => $res]);
    }

    public function match(): void
    {
        $data = $this->extraire();
        extract($data);
        $res = $edit ?  $this->loadModel("matchs")->update($id, $home, $away, $date, $heure, $stade, $groupe, $niveau)
            :  $this->loadModel("matchs")->insert(null, $home, $away, $date, $heure, $stade, $groupe, $niveau);
        $this->response(['res' => $res]);
    }
    public function score(): void
    {
        $data = $this->extraire();
        extract($data);
        $edit = $this->loadModel('score')->findOne($id) ?? false;
        $res = $edit ?  $this->loadModel("score")->update($id, $home, $away)
            :  $this->loadModel("score")->insert($id, $home, $away);
        $this->response(['res' => $res]);
    }
    public function tiraubut(): void
    {
        $data = $this->extraire();
        extract($data);
        $edit = $this->loadModel('score')->findOneTiraubut($id) ?? false;
        $res = $edit ?  $this->loadModel("score")->updateTiraubut($id, $home, $away)
            :  $this->loadModel("score")->insertTiraubut($id, $home, $away);
        $this->response(['res' => $res]);
    }
}
