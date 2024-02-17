<?php

namespace src\Auth;

use App\Modele\Competition;
use stdClass;

class CompetitionAuth extends Authentification
{
    const KEY = "competition";

    public function getCompetition(): ?stdClass
    {
        $competition = $this->session->get(static::KEY);
        return $competition ?? null;
    }

    public function changeCompetition(?string $id): ?stdClass
    {
        $modele = new \App\Modele\Competition();
        $competition = $modele->findEditionOne($id);
        if ($competition) {
            $this->session->set(static::KEY, $competition);
            return $competition;
        }
        return null;
    }
}
