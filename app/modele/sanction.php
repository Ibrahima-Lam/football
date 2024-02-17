<?php

namespace App\Modele;

use src\App\App;

class Sanction extends Modele
{
    public $nombreCarton = 1;

    public function findOne(?string $id): false|self
    {
        return $this->selectOne("select * from player_sanction where idSanctionner='$id'", self::class);
    }
    public function findOneSanctionner(?string $id): false|self
    {
        return $this->selectOne("select * from sanctionner where idSanctionner='$id'", self::class);
    }

    public function findAll(): false|array
    {
        return $this->selectAll("select * from sanction", self::class);
    }
    public function findAllByGame(string $game): false|array
    {
        return $this->selectAll("select * from player_sanction where idGame='$game'", self::class);
    }



    public function findAllSanction($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player_sanction where codeEdition='$comp'";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        return $this->selectAll($req, self::class);
    }
    public function findAllSanctionByJoueur($id): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player_sanction where codeEdition='$comp'";
        $req .=  " and idJoueur='$id'";
        return $this->selectAll($req, self::class);
    }
    public function findAllSanctionAndSuspension($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select *,count(idSanctionner) as nombreCarton from player_sanction where codeEdition='$comp'";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        $req .= " group by idJoueur , codeSanction ";
        $req .= " order by dateGame asc ";
        return $this->selectAll($req, self::class);
    }

    public function findAllSuspension($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player_sanction where codeEdition='$comp' and typeSanction='suspension' ";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        return $this->selectAll($req, self::class);
    }
    public function findAllAvertissement($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player_sanction where codeEdition='$comp' and typeSanction='avertissement' ";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        return $this->selectAll($req, self::class);
    }

    public function insert($id, $joueur, $match, $sanction, $minute): bool
    {
        return $this->prepare("insert into sanctionner values(?,?,?,?,?)")->execute([$id, $joueur, $match, $sanction, $minute]);
    }
    public function update($id, $joueur, $match, $sanction, $minute): bool
    {
        return   $this->prepare("update sanctionner set  idJoueur=?,idGame=?,codeSanction=?,minute=? where idSanctionner=? ")
            ->execute([$joueur, $match, $sanction, $minute, $id]);
    }
}
