<?php

namespace src\factory;

use App\Modele\Matchs;

class Equipe
{
    public static function filterByTeam(array $tab, $team): array
    {
        return array_filter($tab, function ($element) use ($team): bool {
            return  $element->idParticipant == $team;
        });
    }
    public static function filterByMatch(array $tab, Matchs $game): array
    {
        return array_filter($tab, function ($element) use ($game): bool {
            return  $element->idParticipant == $game->idHome || $element->idParticipant == $game->idAway;
        });
    }
}
