<?php

namespace src\factory;

class Matchs
{
    public static function filterByTeam(array $tab, $team): array
    {
        return  array_filter($tab, function ($element) use ($team): bool {
            return  $element->idHome == $team || $element->idAway == $team;
        });
    }
    public static function filterByMatch(array $tab, $match): array
    {
        return  array_filter($tab, function ($element) use ($match): bool {
            return  $element->idGame == $match;
        });
    }

    public static function filterByGamePlayedAfter(array $tab, $date): array
    {
        return  array_filter($tab, function ($element) use ($date): bool {
            return  $element->homeScore !== null && $element->awayScore !== null && $element->dateGame > $date;
        });
    }

    public static function filterByGamePlayed(array $tab): array
    {
        return  array_filter($tab, function ($element): bool {
            return  $element->homeScore !== null && $element->awayScore !== null;
        });
    }
    public static function filterByGameNotPlayed(array $tab): array
    {
        return  array_filter($tab, function ($element): bool {
            return  !($element->homeScore !== null && $element->awayScore !== null);
        });
    }
    public static function filterByPhase(array $tab, $phase): array
    {
        return  array_filter($tab, function ($element) use ($phase): bool {
            return  $element->codePhase === $phase;
        });
    }
    public static function filterByTypePhase(array $tab, $phase): array
    {
        return  array_filter($tab, function ($element) use ($phase): bool {
            return  $element->typePhase === $phase;
        });
    }
}
