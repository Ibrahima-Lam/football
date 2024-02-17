<?php

namespace App\Controllers\home;

use App\Modele\Matchs;
use src\App\App;
use src\factory\Matchs as FactoryMatchs;

class MatchController extends Controller
{
    const PHASE_GROUPE = "groupe";
    const PHASE_ELIM = "elimination";

    public function index(): void
    {
        $groupe = $_GET["groupe"] ?? null;
        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $this->render("match/liste", compact("groupes", "groupe"));
    }
    public function param(): void
    {
        $played = (int)($_GET["played"] ?? null);
        $phase = App::getGroupe()->getGroupe()->typePhase ?? self::PHASE_GROUPE;
        $matchs = $this->loadModel("matchs")->findAll();
        // $matchs = FactoryMatchs::filterByTypePhase($matchs, $phase);
        if ($played === 1) $matchs = FactoryMatchs::filterByGamePlayed($matchs);
        elseif ($played === -1) $matchs = FactoryMatchs::filterByGameNotPlayed($matchs);
        $this->render("match/param", compact("matchs"));
    }

    public function form($action = null): void
    {
        $edit = null;
        $match = new Matchs();
        if ($action == "edit") {
            $edit = 1;
            $mtch = $_GET["match"] ?? null;
            $match = $this->loadModel("matchs")->findOne($mtch);
        }

        $niveaux = $this->loadModel("matchs")->findAllNiveau();
        $equipes = $this->loadModel("participation")->findAllRegroupement();
        $groupes = $this->loadModel("groupe")->findAllGroupe();
        $this->render("match/matchform", compact("equipes", "groupes", "tours", "match", "edit"));
    }

    public function traitement($delete = null): void
    {
        if ($delete) {
            $mtch = $_GET["match"] ?? null;
            $res =  $this->loadModel("matchs")->delete($mtch);
            $this->res($res);
            return;
        }
        extract($_POST);
        $edit = $edit ?? null;
        if (!empty($edit)) {

            $res =  $this->loadModel("matchs")->update($id, $home, $away, $date, $heure, $stade, $groupe, $niveau);
            $this->res($res);
            return;
        }
        $id = null;
        $res =  $this->loadModel("matchs")->insert($id, $home, $away, $date, $heure, $stade, $groupe, $niveau);
        $this->res($res);
    }
    private function res($res): void
    {
        if ($res) {
            header('location:?p=match');
            exit();
        } else echo "echec";
    }


    public function score($action, $id = null): void
    {
        $result = [];
        $data = $_GET["data"] ?? "[]";
        $data = json_decode($data, true);
        extract($data ?? []);
        header('Content-Type:application/json');

        if ($action === "insert") {
            $res = $this->loadModel("score")->insert($idGame, $homeScore, $awayScore);
            if ($res) {
                $result = $this->loadModel("score")->findOne($idGame);
            }
        } elseif ($action === "update") {
            $res = $this->loadModel("score")->update($idGame, $homeScore, $awayScore);
            if ($res) {
                $result = $this->loadModel("score")->findOne($idGame);
            }
        } elseif ($action === "find") {
            $result = $this->loadModel("score")->findOne($id);
        } elseif ($action === "delete") {
            $result["res"] = $this->loadModel("score")->delete($id);
        }

        echo json_encode($result);
    }

    public function details(): void
    {
        $mtch = $_GET["match"] ?? null;
        $match = $this->loadModel("matchs")->findOne($mtch);
        $buts = $this->loadModel("but")->findAllGoalGame($mtch);
        $sanctions = $this->loadModel("sanction")->findAllByGame($mtch);
        if (!$match) $this->redirect('?p=match');


        $stats = [
            'Buts' => [
                'home' => $match->homeScore,
                'away' => $match->awayScore,
            ],
            'Cartons jaunes' => [
                'home' => sizeof(array_filter($sanctions, function ($elmt) use ($match) {
                    return $elmt->codeSanction == 'jaune' && ($elmt->idParticipant == $match->idHome);
                })),
                'away' => sizeof(array_filter($sanctions, function ($elmt) use ($match) {
                    return $elmt->codeSanction == 'jaune' && ($elmt->idParticipant == $match->idAway);
                })),
            ],
            'Cartons rouges' => [
                'home' => sizeof(array_filter($sanctions, function ($elmt) use ($match) {
                    return in_array($elmt->codeSanction, ['rouge', 'rougedirect', 'rougeetsanction']) && ($elmt->idParticipant == $match->idHome || $elmt->idParticipant == $match->idAway);
                })),
                'away' => sizeof(array_filter($sanctions, function ($elmt) use ($match) {
                    return in_array($elmt->codeSanction, ['rouge', 'rougedirect', 'rougeetsanction']) && ($elmt->idParticipant == $match->idHome || $elmt->idParticipant == $match->idAway);
                })),
            ],
        ];

        $this->render("match/details", compact("match", "buts", "sanctions", "stats"));
    }
}
