<div class="content">
    <?php
    $tm = null;
    if (sizeof($joueurs) == 1) {
        $joueurs = array_combine([0], $joueurs);
        $tm =  $joueurs[0]->idParticipant;
    }
    ?>
    <h2 class="titre">Formulaire des Buts</h2>
    <form action="?p=but/traitement" method="post" class="form">
        <div class="form-group">
            <div class="form-control">
                <label for="">Joueur :</label>
                <select name="joueur" id="">
                    <?php

                    use src\factory\Joueur;

                    foreach ($equipes as $equipe) : ?>
                        <?php
                        $players = Joueur::filterByTeam($joueurs, $equipe->idParticipant);
                        if (sizeof($players) === 0) continue;

                        ?>
                        <optgroup label='<?= $equipe->nomEquipe ?>'>
                            <?php foreach ($players as $player) : ?>
                                <option value="<?= $player->idJoueur  ?>"><?= $player->nomJoueur ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Match :</label>
                <select name="match" id="">
                    <?php foreach ($matchs as $match) : ?>
                        <option value="<?= $match->idGame ?>"><?= $match->home ?>/<?= $match->away ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Equipe :</label>
                <select name="equipe" id="">
                    <?php foreach ($equipes as $equipe) : ?>
                        <?php $check = $tm == $equipe->idParticipant ? "selected" : "" ?>

                        <option value="<?= $equipe->idParticipant ?>" <?= $check ?>><?= $equipe->nomEquipe ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">But Marqué :</label>
                <select name="marque" id="">
                    <?php foreach ($marques as $marque) : ?>
                        <option value="<?= $marque->codeMarque ?>"><?= $marque->nomMarque ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Minute :</label>
                <input type="number" name="minute" id="" placeholder="Entrer la Minute">
            </div>
            <div class="form-action">
                <button type="reset" class="btn btn-default" id="">Annuler</button>
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </div>
    </form>
</div>