<div class="content">

    <h2 class="titre">Formulaire des sanctions</h2>
    <form action="?p=sanction/traitement" method="post" class="form">
        <input type="hidden" name="edit" value="<?= $edit ?? null ?>">
        <input type="hidden" name="id" value="<?= $sanction->idSanctionner ?? null ?>">
        <div class="form-group">
            <div class="form-control">
                <label for="">Joueur :</label>
                <select name="joueur" id="">
                    <?php

                    use src\factory\Joueur;

                    foreach ($equipes as $equipe) : ?>
                        <?php
                        $players = Joueur::filterByTeam($joueurs, $equipe->idParticipant);
                        ?>
                        <optgroup label='<?= $equipe->nomEquipe ?>'>
                            <?php foreach ($players as $player) : ?>
                                <?php
                                $attr = $sanction->idJoueur ?? null;
                                $checked = $player->idJoueur == $attr ? "selected" : "";
                                ?>

                                <option value="<?= $player->idJoueur ?>" <?= $checked ?>><?= $player->nomJoueur ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Match :</label>
                <select name="match" id="">
                    <?php foreach ($matchs as $match) : ?>
                        <?php
                        $attr = $sanction->idGame ?? null;
                        $checked = $match->idGame == $attr ? "selected" : "";
                        ?>
                        <option value="<?= $match->idGame ?>" <?= $checked ?>><?= $match->home ?>/<?= $match->away ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Sanction :</label>
                <select name="sanction" id="">
                    <?php foreach ($sanctions as $sct) : ?>
                        <?php
                        $attr = $sanction->codeSanction ?? null;
                        $checked = $sct->codeSanction == $attr ? "selected" : "";
                        ?>
                        <option value="<?= $sct->codeSanction ?>" <?= $checked ?>><?= $sct->nomSanction ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Minute :</label>
                <input type="number" name="minute" id="" placeholder="Entrer la Minute" value="<?= $sanction->minute ?? null ?>">
            </div>
            <div class="form-action">
                <button type="reset" class="btn btn-default" id="">Annuler</button>
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </div>
    </form>
</div>