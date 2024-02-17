<?php

namespace App\Modele;

use src\App\App;

class Equipe extends Modele
{

    public function findAll(): false|array
    {
        $code = App::getCompetition()->getCompetition()->codeEdition;
        $req = "select * from team where codeEdition='$code' ";
        return $this->selectAll($req, self::class);
    }
    public function findAllEquipe(): false|array
    {
        $req = "select * from equipe order by idEquipe desc ";
        return $this->selectAll($req, self::class);
    }
    public function findOne($id): false|self
    {
        $req = "select * from team where idParticipant='$id' ";
        return $this->selectOne($req, self::class);
    }
    public function findOneParticipant($id): false|self
    {
        $req = "select * from participant where idParticipant='$id' ";
        return $this->selectOne($req, self::class);
    }
    public function findOneEquipe($id): false|self
    {
        $req = "select * from equipe where idEquipe='$id' ";
        return $this->selectOne($req, self::class);
    }

    public function insert($id, $nom, $libelle, $localite): bool
    {
        return $this->prepare("insert into equipe values(?,?,?,?)")->execute([$id, $nom, $libelle, $localite]);
    }
    public function update($id, $nom, $libelle, $localite): bool
    {
        return   $this->prepare("update equipe set  nomEquipe=?,libelleEquipe=?,localiteEquipe=? where idEquipe=? ")
            ->execute([$nom, $libelle, $localite, $id]);
    }

    public function insertParticipant($id, $equipe, $edition): bool
    {
        return $this->prepare("insert into participant values(?,?,?)")->execute([$id, $equipe, $edition]);
    }
    public function updateParticipant($id, $equipe, $edition): bool
    {
        return   $this->prepare("update participant set  idEquipe=?,idEdition=? where idParticipant=? ")
            ->execute([$equipe, $edition, $id]);
    }
}
