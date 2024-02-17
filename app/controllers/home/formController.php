<?php

namespace App\Controllers\home;

use src\App\App;
use src\factory\But;
use src\factory\Equipe;
use src\factory\Sanction;

class FormController extends Controller
{
    public function __construct()
    {
        $user = App::getUser()->getUser()->id ?? null;
        $res = <<<Text
            <p class="titre">Vous etes pas connectés, veuillez vous connecter svp!</p>  
            <a href="?p=app/login" class="link mg flex">Se connecter</a>
         Text;
        if (!$user) $this->response($res);
    }

    private function options(array $tab, ?array $keys = null, $default = null): string
    {
        $tag = '';
        foreach ($tab as $key => $elmt) {
            $v =  ($elmt);
            $t =  ($elmt);
            $s = $default == $v ? 'selected' : '';
            $tag .= "<option value='$v' $s>$t</option>";
        }
        return $tag;
    }

    public function competition($id = null): void
    {

        $competition = $this->loadModel('competition')->findOne($id);
        $code = $competition->codeCompetition ?? null;
        $nom = $competition->nomCompetition ?? null;
        $localite = $competition->localiteCompetition ?? null;
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                        <div class="form-control">
                            <label for="code">Code de Compétition</label>
                            <input type="text" name="code" id="code" value="$code" placeholder="Entrer le code">
                        </div>
                        <div class="form-control">
                            <label for="nom">Nom de Compétition</label>
                            <input type="text" name="nom" id="nom" value="$nom" placeholder="Entrer le nom">
                        </div>
                        <div class="form-control">
                            <label for="localite">Localite de Compétition</label>
                            <input type="text" name="localite" id="localite" value="$localite" placeholder="Entrer la localité">
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }

    public function edition($id = null): void
    {
        $comp = $_GET["competition"] ?? App::getCompetition()->getCompetition()->codeCompetition ?? null;
        $edition = $this->loadModel('competition')->findEditionOne($id);
        $code = $edition->codeEdition ?? null;
        $nom = $edition->nomEdition ?? null;
        $annee = $edition->anneeEdition ?? null;
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="competition"  value="$comp" >
                        <div class="form-control">
                            <label for="code">Code d'édition</label>
                            <input type="text" name="code" id="code" value="$code" placeholder="Entrer le code">
                        </div>
                        <div class="form-control">
                            <label for="nom">Nom d'édition</label>
                            <input type="text" name="nom" id="nom" value="$nom" placeholder="Entrer le nom">
                        </div>
                        <div class="form-control">
                            <label for="annee">Annee d'édition</label>
                            <input type="text" name="annee" id="annee" value="$annee" placeholder="Entrer l'annee">
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function groupe($id = null): void
    {
        $edition = $_GET["edition"] ?? App::getCompetition()->getCompetition()->codeEdition ?? null;
        $groupe = $this->loadModel('groupe')->findOne($id);
        $phases = $this->loadModel('groupe')->findAllPhase();
        $nom = $groupe->nomGroupe ?? null;
        $phase = $groupe->codePhase ?? null;
        $nom_option = $this->options(range('A', 'Z'), [], $nom);
        $phase_option = implode('', array_map(function ($elmt) use ($phase) {
            $s = $elmt->codePhase == $phase ? 'selected' : '';
            return "<option value='{$elmt->codePhase}' $s>{$elmt->nomPhase}</option>";
        }, $phases));
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                      <input type="hidden" name="edition"  value="$edition" >
                        <div class="form-control">
                            <label for="nom">Nom du Groupe</label>
                            <select name='nom'>
                            $nom_option
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="pahse">Phase</label>
                             <select name='phase' id='phase'>
                            $phase_option
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function participant($id = null): void
    {
        $edition = $_GET["edition"] ?? App::getCompetition()->getCompetition()->codeEdition ?? null;
        $team = $this->loadModel('equipe')->findOneParticipant($id);
        $equipes = $this->loadModel('equipe')->findAllEquipe();
        $equipe = $team->idEquipe ?? null;
        $equipe_option = implode('', array_map(function ($elmt) use ($equipe) {
            $s = $elmt->idEquipe == $equipe ? 'selected' : '';
            return "<option value='{$elmt->idEquipe}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                      <input type="hidden" name="edition"  value="$edition" >
                        <div class="form-control">
                            <label for="equipe">Equipe</label>
                            <select name='equipe'>
                            $equipe_option
                            </select>
                        </div>
                       
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }

    public function participation($id = null): void
    {
        $grp = $_GET["groupe"] ?? null;
        $participation = $this->loadModel('participation')->findOneRegroupement($id);
        $groupes = $this->loadModel('groupe')->findAllGroupe();
        if ($grp) $groupes = array_filter($groupes, function ($elmt) use ($grp) {
            return $elmt->idGroupe == $grp || $elmt->nomGroupe == $grp;
        });
        $equipes = $this->loadModel('equipe')->findAll();
        $groupe = $participation->idGroupe ?? null;
        $equipe = $participation->idParticipant ?? null;

        $groupe_option = implode('', array_map(function ($elmt) use ($groupe) {
            $s = $elmt->idGroupe == $groupe ? 'selected' : '';
            return "<option value='{$elmt->idGroupe}' $s>{$elmt->nomGroupe}</option>";
        }, $groupes));
        $equipe_option = implode('', array_map(function ($elmt) use ($equipe) {
            $s = $elmt->idParticipant == $equipe ? 'selected' : '';
            return "<option value='{$elmt->idParticipant}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                        <div class="form-control">
                            <label for="groupe"> Groupe</label>
                            <select name='groupe'>
                            $groupe_option
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="annee">Equipe</label>
                             <select name='equipe'>
                            $equipe_option
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function match($groupe, $id = null)
    {

        $match = $this->loadModel('matchs')->findOne($id);
        $niveaux = $this->loadModel('matchs')->findAllNiveau();

        $idgrp = $this->loadModel('groupe')->findOneGroupeByName($groupe)->idGroupe ?? null;
        if (!$idgrp) return $this->response('pas de groupe');
        $groupe = $match->nomGroupe ?? $groupe;
        $equipes = $this->loadModel('participation')->findAllRegroupementByName($groupe);
        $home = $match->idHome ?? null;
        $away = $match->idAway ?? null;
        $date = $match->dateGame ?? null;
        $heure = $match->heureGame ?? '16:00';
        $stade = $match->stadeGame ?? 'Stade';
        $niveau = $match->codeNiveau ?? null;


        $home_option = implode('', array_map(function ($elmt) use ($home) {
            $s = $elmt->idParticipant == $home ? 'selected' : '';
            return "<option value='{$elmt->idParticipant}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));
        $away_option = implode('', array_map(function ($elmt) use ($away) {
            $s = $elmt->idParticipant == $away ? 'selected' : '';
            return "<option value='{$elmt->idParticipant}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));

        $niveau_option = implode('', array_map(function ($elmt) use ($niveau) {
            $s = $elmt->codeNiveau == $niveau ? 'selected' : '';
            return "<option value='{$elmt->codeNiveau}' $s>{$elmt->nomNiveau}</option>";
        }, $niveaux));

        $form = <<<form
                        <form id='form' action="#" method="post">
                            <div class='form-control'>
                            <label for="">Groupe $groupe</label> 
                                <input type="hidden" name="edit" value='$id'>
                                <input type="hidden" name="id" value="$id">
                                <input type="hidden" name="groupe" value="$idgrp">
                            </div>
                            <div class='form-control'>
                            <label for=""> Home</label>
                                <select name="home" id="">
                                  $home_option
                                </select>
                            </div>
                            <div class='form-control'>
                            <label for="">Away </label>
                                <select name="away" id="">
                                   $away_option
                                </select>
                            </div>
                            <div class='form-control'>
                            <label for="">Date </label>
                                <input type="date" name="date" id="" value="$date">
                            </div>
                            <div class='form-control'>
                            <label for="">Heure </label>
                                <input type="time" name="heure" value="$heure">
                            </div>
                            <div class='form-control'>
                            <label for="">Stade </label>
                                <input type="text" name="stade" id="" value="$stade">
                            </div>
                            <div class='form-control'>
                            <label for="niveau"> Niveau</label>
                                 <select name="niveau" id="niveau">
                                   $niveau_option
                                </select>
                            </div>
                            <div class='form-control'>
                            <label for=""> </label>
                                <button class='btn btn-success' type="submit" name="envoi">Envoyer</button>
                            </div>
                        </form>
                 

                </tbody>
            </table>
            form;
        $this->response($form);
    }
    public function score($id)
    {
        $match = $this->loadModel('matchs')->findOne($id);
        if (!$match) return $this->response('Match inconnu');
        $hs = $match->homeScore;
        $as = $match->awayScore;
        $home = $match->home;
        $away = $match->away;


        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                        <div class="form-control">
                            <label for="home">$home</label>
                            <input type="number" min='0' name="home" id="home" value="$hs" required>
                        </div>
                        <div class="form-control">
                            <label for="away">$away</label>
                            <input type="number" min='0' name="away" id="away" value="$as" required>
                        </div>
                       
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function tiraubut($id)
    {
        $match = $this->loadModel('matchs')->findOne($id);
        if (!$match) return $this->response('Match inconnu');
        $hs = $match->homeScorePenalty;
        $as = $match->awayScorePenalty;
        $home = $match->home;
        $away = $match->away;


        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                        <div class="form-control">
                            <label for="equipe">$home</label>
                            <input type="number" min='0' name="home" id="" value="$hs" required>
                        </div>
                        <div class="form-control">
                            <label for="equipe">$away</label>
                            <input type="number" min='0' name="away" id="" value="$as" required>
                        </div>
                       
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }

    public function equipe($id = null)
    {
        $equipe = $this->loadModel('equipe')->findOneEquipe($id);
        $nom = $equipe->nomEquipe ?? null;
        $libelle = $equipe->libelleEquipe ?? null;
        $localite = $equipe->localiteEquipe ?? null;
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                        <div class="form-control">
                            <label for="nom">Nom de l'équipe</label>
                            <input type="text" min='0' name="nom" id="nom" value="$nom" placeholder='Entrer le nom' required>
                        </div>
                        <div class="form-control">
                            <label for="libelle">Libellé de l'équipe</label>
                            <input type="text"  name="libelle" id="libelle" value="$libelle" placeholder='Entrer la libelle' required>
                        </div>
                         <div class="form-control">
                            <label for="localite">Localité de l'équipe</label>
                            <input type="text"  name="localite" id="localite" value="$localite" placeholder='Entrer la localité' required>
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function joueur($id = null)
    {
        $team = $_GET["equipe"] ?? null;
        $joueur = $this->loadModel('joueur')->findOne($id);
        $equipes = $this->loadModel('equipe')->findAll();
        if ($team) $equipes = Equipe::filterByTeam($equipes, $team);
        $nom = $joueur->nomJoueur ?? null;
        $localite = $joueur->localiteJoueur ?? null;
        $equipe = $joueur->idParticipant ?? null;
        $equipe_option = implode('', array_map(function ($elmt) use ($equipe) {
            $s = $elmt->idParticipant == $equipe ? 'selected' : '';
            return "<option value='{$elmt->idParticipant}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));
        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                        <div class="form-control">
                            <label for="nom">Nom de Joueur</label>
                            <input type="text"  name="nom" id="nom" value="$nom" placeholder='Entrer le nom' required>
                        </div>
                       <div class="form-control">
                            <label for="equipe">Equipe</label>
                             <select name='equipe'id="equipe">
                            $equipe_option
                            </select>
                        </div>
                         <div class="form-control">
                            <label for="localite">Localité de Joueur</label>
                            <input type="text"  name="localite" id="localite" value="$localite" placeholder='Entrer la localité' required>
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }

    public function sanction($id = null)
    {
        extract(Sanction::form());
        $groupes = $this->loadModel('groupe')->findAllGroupe();
        $sanctionner = $this->loadModel('sanction')->findOneSanctionner($id);
        $joueur = $sanctionner->idJoueur ?? null;
        $match = $sanctionner->idGame ?? null;
        $sanction = $sanctionner->codeSanction ?? null;
        $minute = $sanctionner->minute ?? null;
        $joueur_option = function ($joueurs) use ($joueur) {
            return implode('', array_map(function ($elmt) use ($joueur) {
                $s = $elmt->idJoueur == $joueur ? 'selected' : '';
                return "<option value='{$elmt->idJoueur}' $s>{$elmt->nomJoueur}</option>";
            }, $joueurs));
        };

        $joueur_optiongrp = implode('', array_map(function ($elmt) use ($joueurs, $joueur_option) {
            $players = array_filter($joueurs, function ($j) use ($elmt) {
                return $j->idParticipant == $elmt->idParticipant;
            });
            $options = $joueur_option($players);
            if (sizeof($players) == 0) return;
            return "<optgroup label='{$elmt->nomEquipe}' >$options</optgroup>";
        }, $equipes));

        $sanction_option = implode('', array_map(function ($elmt) use ($sanction) {
            $s = $elmt->codeSanction == $sanction ? 'selected' : '';
            return "<option value='{$elmt->codeSanction}' $s>{$elmt->nomSanction}</option>";
        }, $sanctions));


        $match_option = function ($matchs) use ($match) {
            return  implode('', array_map(function ($elmt) use ($match) {
                $s = $elmt->idGame == $match ? 'selected' : '';
                return "<option value='{$elmt->idGame}' $s>{$elmt->home}-{$elmt->away}/{$elmt->dateGame}</option>";
            }, $matchs));
        };
        $match_optiongrp = implode('', array_map(function ($elmt) use ($matchs, $match_option) {
            $games = array_filter($matchs, function ($g) use ($elmt) {
                return $g->idGroupe == $elmt->idGroupe;
            });
            if (sizeof($games) == 0) return;
            $options = $match_option($games);
            $label = $elmt->codePhase == 'grp' ? 'Groupe ' . $elmt->nomGroupe : $elmt->nomPhase;
            return "<optgroup label='{$label}' >$options</optgroup>";
        }, $groupes));


        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                       
                       <div class="form-control">
                            <label for="joueur">Joueur</label>
                             <select name='joueur' id='joueur'>
                            $joueur_optiongrp
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="match">match</label>
                            <select name='match' id='match'>
                            $match_optiongrp
                            </select>
                        </div>
                        <div class="form-control">
                             <label for="Sanction">sanction</label>
                              <select name='sanction' id='sanction'>
                             $sanction_option
                             </select>
                         </div>
                          <div class="form-control">
                            <label for="minute">Minute</label>
                            <input type="text"  name="minute" id="minute" value='$minute'>
                        </div>
                        
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
    public function but($id = null)
    {
        extract(But::form());

        $groupes = $this->loadModel('groupe')->findAllGroupe();
        $but = $this->loadModel('but')->findOne($id);
        $match = $but->idGame ?? null;
        $equipe = $but->numParticipant ?? null;
        $joueur = $but->idJoueur ?? null;
        $marque = $but->codeMarque ?? null;
        $minute = $but->minute ?? null;


        $joueur_option = function ($joueurs) use ($joueur) {
            return implode('', array_map(function ($elmt) use ($joueur) {
                $s = $elmt->idJoueur == $joueur ? 'selected' : '';
                return "<option value='{$elmt->idJoueur}' $s>{$elmt->nomJoueur}</option>";
            }, $joueurs));
        };

        $joueur_optiongrp = implode('', array_map(function ($elmt) use ($joueurs, $joueur_option) {
            $players = array_filter($joueurs, function ($j) use ($elmt) {
                return $j->idParticipant == $elmt->idParticipant;
            });
            if (sizeof($players) == 0) return '';
            $options = $joueur_option($players);
            return "<optgroup label='{$elmt->nomEquipe}' >$options</optgroup>";
        }, $equipes));

        $marque_option = implode('', array_map(function ($elmt) use ($marque) {
            $s = $elmt->codeMarque == $marque ? 'selected' : '';
            return "<option value='{$elmt->codeMarque}' $s>{$elmt->nomMarque}</option>";
        }, $marques));

        $equipe_option = implode('', array_map(function ($elmt) use ($equipe) {
            $s = $elmt->idParticipant == $equipe ? 'selected' : '';
            return "<option value='{$elmt->idParticipant}' $s>{$elmt->nomEquipe}</option>";
        }, $equipes));


        $match_option = function ($matchs) use ($match) {
            return  implode('', array_map(function ($elmt) use ($match) {
                $s = $elmt->idGame == $match ? 'selected' : '';
                return "<option value='{$elmt->idGame}' $s>{$elmt->home}-{$elmt->away}/{$elmt->dateGame}</option>";
            }, $matchs));
        };
        $match_optiongrp = implode('', array_map(function ($elmt) use ($matchs, $match_option) {
            $games = array_filter($matchs, function ($g) use ($elmt) {
                return $g->idGroupe == $elmt->idGroupe;
            });
            if (sizeof($games) == 0) return;
            $options = $match_option($games);
            $label = $elmt->codePhase == 'grp' ? 'Groupe ' . $elmt->nomGroupe : $elmt->nomPhase;
            return "<optgroup label='{$label}' >$options</optgroup>";
        }, $groupes));


        $form = <<<form
                    <form action="" id='form'>
                      <input type="hidden" name="edit"  value="$id" >
                      <input type="hidden" name="id"  value="$id" >
                       
                       <div class="form-control">
                            <label for="joueur">Joueur</label>
                             <select name='joueur' id='joueur'>
                            $joueur_optiongrp
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="equipe">Equipe</label>
                             <select name='equipe' id='equipe'>
                            $equipe_option
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="match">match</label>
                            <select name='match' id='match'>
                            $match_optiongrp
                            </select>
                        </div>
                        <div class="form-control">
                             <label for="marque">But</label>
                              <select name='marque' id='marque'>
                             $marque_option
                             </select>
                         </div>
                          <div class="form-control">
                            <label for="minute">Minute</label>
                            <input type="text"  name="minute" id="minute" value='$minute' >
                        </div>
                        
                        <div class="form-control">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                </form>
            form;
        $this->response($form);
    }
}
