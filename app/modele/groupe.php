<?php

namespace App\Modele;

use src\App\App;
use stdClass;

class Groupe extends Modele
{

    public function findOne($id): false|stdClass
    {
        return $this->selectOne("select * from groupe where idGroupe='$id'");
    }

    public function findAll(): false|array
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        return $this->selectAll("select * from groupe natural join phase where codeEdition='$competition' and codePhase='grp' order by nomGroupe asc", self::class);
    }
    public function findAllGroupe(): false|array
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from groupe natural join phase where codeEdition='$competition' order by nomGroupe asc";
        return $this->selectAll($req, self::class);
    }
    public function findOneGroupeByName($nom): false|self
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from groupe natural join phase where codeEdition='$competition' and nomGroupe='$nom' order by nomGroupe asc";
        return $this->selectOne($req, self::class);
    }
    public function findAllPhase(): false|array
    {
        $req = "select * from phase";
        return $this->selectAll($req, self::class);
    }

    public function findAllByPhase($code = null, $type = null): false|array
    {
        $competition = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from groupe natural join phase where codeEdition='$competition'";
        $req .= ($code) ? " and codePhase='$code'" : "";
        $req .= ($type) ? " and typePhase='$type'" : "";
        return $this->selectAll($req, self::class);
    }
    public function insert($id, $nom, $phase, $edition): bool
    {
        return $this->prepare("insert into groupe values(?,?,?,?)")->execute([$id, $nom, $phase, $edition]);
    }
    public function update($id, $nom, $phase, $edition): bool
    {
        return   $this->prepare("update groupe set  nomGroupe=?,codePhase=?,codeEdition=? where idGroupe=? ")
            ->execute([$nom, $phase, $edition, $id]);
    }
}
