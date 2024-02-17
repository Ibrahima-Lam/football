<?php

namespace App\Modele;

use stdClass;

class Competition extends Modele
{

    public function findAll(): false|array
    {
        return $this->selectAll("select * from competition", self::class);
    }
    public function findEditionAll(): false|array
    {
        return $this->selectAll("select * from tournoi", self::class);
    }

    public function findLastEditionAll(): false|array
    {
        return $this->selectAll("select * from tournoi group by codeCompetition order by anneeEdition desc ", self::class);
    }
    public function findOne($code): false|stdClass
    {
        return $this->selectOne("select * from competition where codeCompetition='$code'");
    }

    public function findEditionOne($code): false|stdClass
    {
        return $this->selectOne("select * from tournoi where codeEdition='$code'");
    }
    public function insert($code, $nom, $localite): bool
    {
        return $this->prepare("insert into competition values(?,?,?)")->execute([$code, $nom, $localite]);
    }
    public function update($code, $nom, $localite): bool
    {
        return   $this->prepare("update competition set nomCompetition=:nom , localiteCompetition=:localite where codeCompetition=:code ")
            ->execute([":nom" => $nom, ":localite" => $localite, ":code" => $code]);
    }
    public function insertEdition($code, $annee, $nom, $competition): bool
    {
        return $this->prepare("insert into edition values(?,?,?,?)")->execute([$code, $annee, $nom, $competition]);
    }
    public function updateEdition($code, $annee, $nom,  $competition): bool
    {
        return   $this->prepare("update edition set  anneeEdition=?,nomEdition=?,codeCompetition=? where codeEdition=? ")
            ->execute([$annee, $nom, $competition, $code]);
    }
}
