<?php

namespace src\Auth;

use App\Modele\Competition;
use stdClass;

class GroupeAuth extends Authentification
{
    const KEY = "groupe";



    public function getGroupe(): ?stdClass
    {
        $groupe = $this->session->get(static::KEY);
        return $groupe ?? null;
    }

    public function changeGroupe(?string $id): ?stdClass
    {
        $modele = new \App\Modele\Groupe();
        $groupe = $modele->findOne($id);
        if ($groupe) {
            $this->session->set(static::KEY, $groupe);
            return $groupe;
        }
        return null;
    }
}
