<?php

namespace App\Modele;

use src\App\App;

class But extends Modele
{
    public $num;


    public function findAll($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select *,count(idJoueur) as nombre from goal where codeEdition='$comp'";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        $req .= "   group by idJoueur,typeMarque order by nombre desc, dateGame desc, idGame desc,minute desc,idBut desc ";
        return $this->selectAll($req, self::class);
    }
    public function findAllGoalGame($game = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from goal where codeEdition='$comp'";
        $req .= ($game) ? " and idGame='$game'" : "";
        return $this->selectAll($req, self::class);
    }
    public function findOne($id): false|self
    {
        $req = "select * from But where idBut='$id'";
        return $this->selectOne($req, self::class);
    }

    public function findAllGoalByJoueur($id): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from goal where codeEdition='$comp'";
        $req .=  " and idJoueur='$id'";
        return $this->selectAll($req, self::class);
    }

    public function findAllMarque(): false|array
    {
        $req = "select *  from marque";
        return $this->selectAll($req, self::class);
    }

    public function insert($id, $joueur, $match, $equipe, $minute, $marque): bool
    {
        return $this->prepare("insert into but values(?,?,?,?,?,?)")->execute([$id, $joueur, $match, $equipe, $minute, $marque]);
    }
    public function update($id, $joueur, $match, $equipe, $minute, $marque): bool
    {
        return   $this->prepare("update but set  idJoueur=?,idGame=?,numParticipant=?,minute=?,codeMarque=? where idBut=? ")
            ->execute([$joueur, $match, $equipe, $minute, $marque, $id]);
    }
}
