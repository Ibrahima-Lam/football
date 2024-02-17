<?php

namespace App\Modele;

use stdClass;

class User extends Modele
{
    public $id;
    public $name;
    public $password;
    public $role;

    public function findOne($id): false|self
    {
        $req = "select * from user where id='$id'";
        return $this->selectOne($req, self::class);
    }
    public function findAll($id): false|array
    {
        $req = "select * from user ";
        return $this->selectAll($req, self::class);
    }
    public function findByNameAndPassword($name, $password): false|stdClass
    {
        $req = "select * from user where name='$name' and password='$password' ";
        return $this->selectOne($req, stdClass::class);
    }
}
