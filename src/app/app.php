<?php

namespace src\App;


use src\Auth\CompetitionAuth;
use src\Auth\GroupeAuth;
use src\Auth\UserAuth;

class App
{

    private static $competition;
    private static $groupe;
    private static $user;

    public static function getCompetition(): CompetitionAuth
    {
        if (self::$competition === null) {
            $competition = new CompetitionAuth();
        }
        return $competition;
    }
    public static function getUser(): UserAuth
    {
        if (self::$user === null) {
            $user = new userAuth();
        }
        return $user;
    }


    public static function getGroupe(): groupeAuth
    {
        if (self::$groupe === null) {
            $groupe = new groupeAuth();
        }
        return $groupe;
    }
}
