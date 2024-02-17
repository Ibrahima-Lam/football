<?php

namespace src\factory;

use src\Service\TraitModel;

class But
{
    use TraitModel;
    public static function filterByTeam(array $goals, string $team): array
    {
        return array_filter($goals, function ($element) use ($team): bool {
            return $element->idTeam == $team;
        });
    }

    public static function form(): array
    {
        $team = $_GET["team"] ?? null;
        $mtch = $_GET["match"] ?? null;
        $jr = $_GET["joueur"] ?? null;
        $player = ($jr) ? self::loadModel("joueur")->findOne($jr) : null;
        if ($player) {
            $team = $player->idParticipant;
        }

        $equipes = self::loadModel("equipe")->findAll();
        if ($mtch) {
            $game =  self::loadModel("matchs")->findOne($mtch);
            $equipes = Equipe::filterByMatch($equipes, $game);
        }

        $matchs = self::loadModel("matchs")->findAll();
        $matchs = ($team) ? Matchs::filterByTeam($matchs, $team) : $matchs;
        $matchs = ($mtch) ? Matchs::filterByMatch($matchs, $mtch) : $matchs;

        $joueurs = self::loadModel("joueur")->findAll($team);
        $joueurs = ($mtch) ? Joueur::filterByAllTeam($joueurs, $equipes) : $joueurs;
        $joueurs = ($jr) ? Joueur::filterByPlayer($joueurs, $jr) : $joueurs;

        $marques = self::loadModel("but")->findAllMarque();
        return compact("joueurs", "equipes", "matchs", "marques");
    }
}
