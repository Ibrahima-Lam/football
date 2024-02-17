<?php

namespace src\Service;

class Generateur
{
    public static $data = [];
    public static function getMatches($tab = []): array
    {

        if (sizeof($tab) === 3) {
            return [
                ["home" => $tab[0], "away" => $tab[1]],
                ["home" => $tab[2], "away" => $tab[0]],
                ["home" => $tab[1], "away" => $tab[2]]
            ];
        }
        if (sizeof($tab) === 4) {
            return [
                ["home" => $tab[0], "away" => $tab[1]],
                ["home" => $tab[2], "away" => $tab[3]],
                ["home" => $tab[0], "away" => $tab[2]],
                ["home" => $tab[1], "away" => $tab[3]],
                ["home" => $tab[3], "away" => $tab[0]],
                ["home" => $tab[1], "away" => $tab[2]]
            ];
        }
        if (sizeof($tab) === 5) {
            return [
                ["home" => $tab[0], "away" => $tab[1]],
                ["home" => $tab[2], "away" => $tab[3]],
                ["home" => $tab[4], "away" => $tab[0]],
                ["home" => $tab[2], "away" => $tab[1]],
                ["home" => $tab[3], "away" => $tab[4]],
                ["home" => $tab[0], "away" => $tab[2]],
                ["home" => $tab[1], "away" => $tab[3]],
                ["home" => $tab[4], "away" => $tab[2]],
                ["home" => $tab[0], "away" => $tab[3]],
                ["home" => $tab[1], "away" => $tab[4]]
            ];
        }
        return [];
    }
    public static function getDate(?string $date)
    {
        if (!$date) return "";
        $semaine = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

        list($a, $m, $j) = explode("-", $date);
        $time = mktime(0, 0, 0, (int) $m, (int)$j, (int)$a);
        $date = getdate($time)["wday"];
        return "{$semaine[$date]}, le $j-$m-$a";
    }
    public static function getGames(): array
    {
        $gamesTab = [];
        $tab1 = ["Marseille", "Roma", "Barça", "Real", "Villareal", "Seville", "City", "Paris"];
        $tab2 = ["Lyon", "Tech", "Liverpool", "Porto", "Inter", "Arsenal", "United", "Tottenham"];
        // $tab2 = array_reverse($tab2);
        $max = sizeof($tab1) + sizeof($tab2) - 1;
        foreach ($tab1 as $key => $value) {
            $gamesTab[] = [
                "home" => $value,
                "away" => $tab2[$key],
                "day" => 1
            ];
        }

        for ($i = 2; $i <= $max; $i++) {
            $ref = array_shift($tab1);
            $first = array_shift($tab1);
            $last = array_pop($tab2);
            array_unshift($tab1, $ref);
            $tab1[] = $last;
            array_unshift($tab2, $first);
            foreach ($tab1 as $key => $value) {
                $gamesTab[] = [
                    "home" => $value,
                    "away" => $tab2[$key],
                    "day" => $i
                ];
            }
        }

        $gamesTab = array_map(function ($elmt): array {
            if (empty(self::$data)) {
                self::$data[] = $elmt;
                return $elmt;
            }
            $home = array_filter(self::$data, function ($item) use ($elmt): bool {
                return $item["day"] == ($elmt["day"] - 1) && ($item["home"] == $elmt["home"]);
            }) ?? [];
            $home = !empty($home) ? array_values($home)[0] : null;

            $aways = array_filter(self::$data, function ($item) use ($elmt): bool {
                return ($item["day"] == ($elmt["day"] - 1) || $item["day"] == ($elmt["day"] - 2)) && ($item["away"] == $elmt["away"]);
            }) ?? [];

            if ($home || sizeof($aways) >= 2) {
                $h = $elmt["home"];
                $elmt["home"] = $elmt["away"];
                $elmt["away"] = $h;
            }
            self::$data[] = $elmt;
            return $elmt;
        }, $gamesTab);

        return $gamesTab;
    }
}
