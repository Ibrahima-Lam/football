<?php

namespace src\Service;

class Classeur
{
    const KEYS = ["points", "diff", "conf", "bm", "be", "rang", "id"];


    private $data = [];
    private $teams = [];


    public function __construct(array $dt, $teams)
    {
        $data = array_filter($dt, function ($element): bool {
            return $element->homeScore !== null && $element->homeScore !== null;
        });
        $data = array_map(function ($element): mixed {
            return [
                "home" => [
                    "id" => $element->idHome,
                    "but" => $element->homeScore,
                    "nom" => $element->home,
                ],
                "away" => [
                    "id" => $element->idAway,
                    "but" => $element->awayScore,
                    "nom" => $element->away,
                ],
            ];
        }, $data);
        $this->data = $data;
        $this->teams = array_map(function ($element): array {

            return  [
                "id" => $element->idParticipant,
                "nom" => $element->nomEquipe,
                "rang" => $element->idParticipation,
            ];
        }, $teams);
    }

    public  function classer($cles = null, ?callable $callback = null): array
    {

        $keys = $cles ?? self::KEYS;
        $result = $this->getStats();
        usort($result, function ($a, $b) use ($keys, $callback): int {
            foreach ($keys as  $value) {
                if ($value === "conf") {
                    $conf = $this->confrontation($a, $b);
                    if ($conf === 0) continue;
                    else return $conf;
                }
                if ($value === "call") {
                    if (is_null($callback)) continue;
                    $teste = $callback($a, $b);
                    if ($teste === 0 && !is_null($teste)) continue;
                    else return $teste;
                }
                if ($a[$value] === $b[$value]) continue;
                if ($value === "id" || $value === "rang" || $value === "be") return ($a[$value] <=> $b[$value]);
                return - ($a[$value] <=> $b[$value]);
            }
            return -1;
        });

        $size = count($result);
        $final = array_map(function ($a, $b): array {
            $a["num"] = $b;
            return $a;
        }, $result, range(1, $size));
        return $final;
    }

    private function getStats(): array
    {
        $stats = [];
        $teams = $this->teams;
        foreach ($teams as  $team) {
            $id = $team["id"];
            $rang = $team["rang"];
            $tab = array_filter($this->data, function ($value) use ($id): bool {
                return $id == $value["home"]["id"] || $id == $value["away"]["id"];
            });
            $scores = $this->getScore($tab, $id);
            $result = $this->getTeamStats($scores);
            $result["id"] = $id;
            $result["rang"] = $rang;
            $element = array_merge($team, $result);
            $stats[] = $element;
        }

        return $stats;
    }

    private function getScore(array $tab, $id): array
    {
        $res = [];
        foreach ($tab as  $value) {
            $home = $value["home"];
            $away = $value["away"];
            if ($id == $home["id"]) {
                $nom = $home["nom"];
                $marque = $home["but"];
                $encaisse = $away["but"];
                $diff = $marque - $encaisse;
            } else {
                $nom = $away["nom"];
                $marque = $away["but"];
                $encaisse = $home["but"];
                $diff = $marque - $encaisse;
            }
            $res[] = [
                "bm" => $marque,
                "be" => $encaisse,
                "diff" => $diff,
                "points" => $diff > 0 ? 3 : ($diff < 0 ? 0 : 1),
                "matchs" => 1,
                "decision" => $diff > 0 ? "v" : ($diff < 0 ? "d"   : "n")
            ];
        }
        return $res;
    }

    private function getTeamStats(array $scores): array
    {
        $init = $this->getInit();

        return  array_reduce($scores, function ($a, $b): array {
            return [
                "points" => $a["points"] += $b["points"],
                "matchs" => $a["matchs"] += $b["matchs"],
                "diff" => $a["diff"] += $b["diff"],
                "bm" => $a["bm"] += $b["bm"],
                "be" => $a["be"] += $b["be"],
                "nv" => $a["nv"] += $b["decision"] === "v" ? 1 : 0,
                "nn" => $a["nn"] += $b["decision"] === "n" ? 1 : 0,
                "nd" => $a["nd"] += $b["decision"] === "d" ? 1 : 0,

            ];
        }, $init);
    }

    private function getInit(): array
    {
        return [
            "points" => 0,
            "matchs" => 0,
            "diff" => 0,
            "bm" => 0,
            "be" => 0,
            "nv" => 0,
            "nn" => 0,
            "nd" => 0,
        ];
    }

    private function confrontation($a, $b): int
    {
        foreach ($this->data as $value) {
            extract($value);
            if ($a["id"] === $home["id"] && $b["id"] === $away["id"]) {
                return -$home["but"] <=> $away["but"];
            } elseif ($b["id"] === $home["id"] && $a["id"] === $away["id"]) {
                return $home["but"] <=> $away["but"];
            }
        }
        return 0;
    }
}
