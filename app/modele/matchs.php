<?php

namespace App\Modele;

use src\App\App;

class Matchs extends Modele
{
    public $idGame;
    public $idHome;
    public $idAway;

    public function findAll(): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        return $this->selectAll("select * from game_play where codeEdition='$comp' order by dateGame asc,heureGame asc,idGame asc", self::class);
    }
    public function findAllByGroupe($groupe): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        return $this->selectAll("select * from game_play where codeEdition='$comp' and nomGroupe='$groupe' order by dateGame asc,heureGame asc,idGame asc", self::class);
    }

    public function findOne($id): false|self
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        return $this->selectOne("select * from game_play where codeEdition='$comp' and idGame='$id'", self::class);
    }

    public function findAllNiveau(): false|array
    {

        return $this->selectAll("select * from niveau ", self::class);
    }

    public function insert($id, $home, $away, $date, $heure, $stade, $groupe, $niveau): bool
    {
        $req = "insert into game values(?,?,?,?,?,?,?,?)";
        return $this->prepare($req)->execute([$id, $home, $away, $date, $heure, $stade, $groupe, $niveau]);
    }

    public function update($id, $home, $away, $date, $heure, $stade, $groupe, $niveau): bool
    {
        $req = "update game set homeGame=?,awayGame=?,dateGame=?,heureGame=?,stadeGame=?,idGroupe=?,codeNiveau=? where idGame=?";
        return $this->prepare($req)->execute([$home, $away, $date, $heure, $stade, $groupe, $niveau, $id]);
    }


    public function delete($id): bool
    {
        $req = "delete from game  where idGame='$id'";
        return $this->exec($req);
    }
}
