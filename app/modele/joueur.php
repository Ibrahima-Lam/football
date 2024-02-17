<?php

namespace App\Modele;

use src\App\App;

class Joueur extends Modele
{

    public function findAll($team = null): false|array
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player where codeEdition='$comp'";
        $req .= ($team) ? " and idParticipant='$team'" : "";
        return $this->selectAll($req, self::class);
    }
    public function findOne($id): false|self
    {
        $comp = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from player where codeEdition='$comp' and idJoueur='$id'";
        return $this->selectOne($req, self::class);
    }

    public function insert($id, $nom, $equipe, $localite): bool
    {
        return $this->prepare("insert into joueur values(?,?,?,?)")->execute([$id, $nom, $equipe, $localite]);
    }
    public function update($id, $nom, $equipe, $localite): bool
    {
        return   $this->prepare("update joueur set  nomJoueur=?,idParticipant=?,localiteJoueur=? where idJoueur=? ")
            ->execute([$nom, $equipe, $localite, $id]);
    }
}
