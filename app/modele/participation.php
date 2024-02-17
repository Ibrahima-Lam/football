<?php

namespace App\Modele;

use src\App\App;
use stdClass;

class Participation extends Modele
{

    public function findOneRegroupement($id): false|stdClass
    {
        return $this->selectOne("select * from regroupement where idParticipation='$id'");
    }


    public function findAllRegroupement(): false|array
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from regroupement where codeEdition='$competition'";
        return $this->selectAll($req, self::class);
    }
    public function findAllRegroupementByName($nom = null): false|array
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from regroupement where codeEdition='$competition'";
        $req .= ($nom) ? " and nomGroupe='$nom'" : "";
        return $this->selectAll($req, self::class);
    }
    public function insert($id, $groupe, $equipe): bool
    {
        return $this->prepare("insert into participation values(?,?,?)")->execute([$id, $groupe, $equipe]);
    }
    public function update($id,  $groupe, $equipe): bool
    {
        return   $this->prepare("update participation set idGroupe=?, idParticipant=? where idParticipation=? ")
            ->execute([$groupe, $equipe, $id]);
    }
}
