<?php

namespace src\Auth;

use stdClass;

class UserAuth extends Authentification
{
    const KEY = "user";

    public function getUser(): ?stdClass
    {
        $user = $this->session->get(static::KEY);
        return $user ?? null;
    }

    public function changeUser($name, $password): ?stdClass
    {
        $modele = new \App\Modele\User();
        $user = $modele->findByNameAndPassword($name, $password);
        if ($user) {
            $this->session->set(static::KEY, $user);
            return $user;
        }
        return null;
    }

    public function removeUser(): void
    {
        $this->session->delete(static::KEY);
    }
}
