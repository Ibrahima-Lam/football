<?php

namespace App\Modele;

class Score extends Modele
{

    public function findOne($id): false|self
    {
        return $this->selectOne("select * from score where idGame='$id'", self::class);
    }

    public function findOneTiraubut($id): false|self
    {
        return $this->selectOne("select * from tiraubut where idGame='$id'", self::class);
    }

    public function insert($id, $home, $away): bool
    {
        $req = "insert into score values(?,?,?)";
        return $this->prepare($req)->execute([$id, $home, $away]);
    }

    public function update($id, $home, $away): bool
    {
        $req = "update score set homeScore=?,awayScore=? where idGame=?";
        return $this->prepare($req)->execute([$home, $away, $id]);
    }
    public function insertTiraubut($id, $home, $away): bool
    {
        $req = "insert into tiraubut values(?,?,?)";
        return $this->prepare($req)->execute([$id, $home, $away]);
    }

    public function updateTiraubut($id, $home, $away): bool
    {
        $req = "update tiraubut set homeScorePenalty=?,awayScorePenalty=? where idGame=?";
        return $this->prepare($req)->execute([$home, $away, $id]);
    }
    public function delete($id): bool
    {
        $req = "delete from score where idGame='$id' ";
        return $this->exec($req);
    }
}
