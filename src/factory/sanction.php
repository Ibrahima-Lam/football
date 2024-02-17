<?php

namespace src\factory;

use src\Service\TraitModel;

class Sanction
{

    use TraitModel;


    public static function filterAndMap(array $tab, array $matchs, array $avertis): array
    {
        $table = array_filter($tab, function ($element) use ($matchs, $avertis): bool {
            $games = Matchs::filterByTeam($matchs, $element->idParticipant);
            $after = Matchs::filterByGamePlayedAfter($games, $element->dateGame);
            if ($element->nombreCarton >= 2 && $element->nombreCarton % 2 === 0 && $element->typeSanction === "avertissement") {
                return self::filtreAvertis($avertis, $games, $element);
            }
            if (sizeof($after) === 0) return true;
            if (sizeof($after) >= (int) $element->nombreMatch && $element->typeSanction === "suspension") return false;
            return true;
        });
        return $table;
    }
    public static function filterSuspendus(array $tab): array
    {
        $table = array_filter($tab, function ($element): bool {
            return $element->nombreCarton === 2 || $element->typeSanction === "suspension";
        });
        return $table;
    }

    private static function filtreAvertis(array $avertis, array  $games, $element): bool
    {
        $sanctions = self::filtreByJoueur($avertis, $element->idJoueur);
        usort($sanctions, function ($a, $b): int {
            return  $a->dateGame < $b->dateGame ? -1 : 1;
        });
        $last = end($sanctions);
        $after = Matchs::filterByGamePlayedAfter($games, $last->dateGame);
        return sizeof($after) == 0;
    }

    private static function filtreByJoueur($santions, $joueur): array
    {
        return array_filter($santions, function ($element) use ($joueur): bool {
            return $element->idJoueur == $joueur;
        });
    }

    public static function form(): array
    {
        $team = $_GET["equipe"] ?? null;
        $mtch = $_GET["match"] ?? null;
        $jr = $_GET["joueur"] ?? null;
        $player = ($jr) ? self::loadModel("joueur")->findOne($jr) : null;
        if ($player) {
            $team = $player->idParticipant;
        }

        $matchs = self::loadModel("matchs")->findAll();
        $matchs = ($team) ? Matchs::filterByTeam($matchs, $team) : $matchs;
        $matchs = ($mtch) ? Matchs::filterByMatch($matchs, $mtch) : $matchs;

        $equipes = self::loadModel("equipe")->findAll($team);
        $equipes = ($team) ? Equipe::filterByTeam($equipes, $team) : $equipes;
        if ($mtch) {
            $game =  self::loadModel("matchs")->findOne($mtch);
            $equipes = Equipe::filterByMatch($equipes, $game);
        }

        $joueurs = self::loadModel("joueur")->findAll($team);
        $joueurs = ($mtch) ? Joueur::filterByAllTeam($joueurs, $equipes) : $joueurs;
        $joueurs = ($jr) ? Joueur::filterByPlayer($joueurs, $jr) : $joueurs;

        $sanctions = self::loadModel("sanction")->findAll();
        return compact("joueurs", "sanctions", "matchs", "equipes");
    }
}
