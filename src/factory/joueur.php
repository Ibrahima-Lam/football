<?php

namespace src\factory;

use App\Modele\Matchs;

class Joueur
{
    public static function filterByTeam(array $tab, $team): array
    {
        return array_filter($tab, function ($element) use ($team): bool {
            return  $element->idParticipant == $team;
        });
    }
    public static function filterByPlayer(array $tab, $joueur): array
    {
        return array_filter($tab, function ($element) use ($joueur): bool {
            return  $element->idJoueur == $joueur;
        });
    }

    public static function filterByAllTeam(array $tab, array $teams): array
    {
        $equipes = [];
        foreach ($teams as  $value) {
            $equipes[] = $value->idParticipant;
        }
        return array_filter($tab, function ($element) use ($equipes): bool {
            return  in_array($element->idParticipant, $equipes);
        });
    }
}
