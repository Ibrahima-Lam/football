<div class="content">
    <h2 class="titre">Formulaire des Matchs</h2>
    <div class="table-container">
        <datalist id="tour">

            <?php foreach ($niveaux as $niveau) : ?>
                <option value="<?= $niveau->codeNiveau ?>"></option>

            <?php endforeach ?>
        </datalist>

        <?php if ($edit ?? null) : ?>

            <datalist id="tour">

                <?php foreach ($niveaux as $niveau) : ?>
                    <option value="<?= $niveau->codeNiveau ?>"></option>

                <?php endforeach ?>
            </datalist>

            <table class="table striped">

                <thead>
                    <tr>
                        <td>Groupe</td>
                        <th>Home</th>
                        <th>Away</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Stade</th>
                        <th>Tour</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $teams = array_filter($equipes, function ($team) use ($match): bool {
                        return $team->idGroupe === $match->idGroupe;
                    })
                    ?>
                    <tr>

                        <form action="?p=match/traitement" method="post">
                            <td><?= $match->nomGroupe ?>
                                <input type="hidden" name="edit" value='1'>
                                <input type="hidden" name="id" value="<?= $match->idGame ?>">
                                <input type="hidden" name="groupe" value="<?= $match->idGroupe ?>">

                            </td>
                            <td>
                                <select name="home" id="">
                                    <?php foreach ($teams as $team) : ?>
                                        <?php $selected = $team->idParticipant == $match->idHome ? "selected" : "" ?>
                                        <option value="<?= $team->idParticipant ?>" <?= $selected ?>><?= $team->nomEquipe ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                            <td>
                                <select name="away" id="">
                                    <?php foreach ($teams as $team) : ?>
                                        <?php $selected = $team->idParticipant == $match->idAway ? "selected" : "" ?>
                                        <option value="<?= $team->idParticipant ?>" <?= $selected ?>><?= $team->nomEquipe ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                            <td>
                                <input type="date" name="date" id="" value="<?= $match->dateGame ?>">
                            </td>
                            <td>
                                <input type="time" name="heure" value="<?= $match->heureGame ?? '16:00' ?>">
                            </td>
                            <td>
                                <input type="text" name="stade" id="" value="<?= $match->stadeGame ?? 'Stade' ?>">
                            </td>
                            <td>
                                <input type="text" list="tour" name="tour" id="" value="<?= $match->codeNiveau ?>">
                            </td>
                            <td>
                                <input type="submit" name="envoi" value="Envoyer">
                            </td>
                        </form>
                    </tr>

                </tbody>
            </table>
    </div>


<?php else : ?>

    <table class="table striped">

        <thead>
            <tr>
                <td>Groupe</td>
                <th>Home</th>
                <th>Away</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Stade</th>
                <th>Tour</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupes as $groupe) : ?>
                <?php
                $teams = array_filter($equipes, function ($team) use ($groupe): bool {
                    return $team->idGroupe === $groupe->idGroupe;
                })
                ?>
                <tr>

                    <form action="?p=match/traitement" method="post">
                        <td><?= $groupe->nomGroupe ?>
                            <input type="hidden" name="edit">
                            <input type="hidden" name="id">
                            <input type="hidden" name="groupe" value="<?= $groupe->idGroupe ?>">

                        </td>
                        <td>
                            <select name="home" id="">
                                <?php foreach ($teams as $team) : ?>
                                    <option value="<?= $team->idParticipant ?>"><?= $team->nomEquipe ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <select name="away" id="">
                                <?php foreach ($teams as $team) : ?>
                                    <option value="<?= $team->idParticipant ?>"><?= $team->nomEquipe ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <input type="date" name="date" id="">
                        </td>
                        <td>
                            <input type="time" name="heure" value="16:00">
                        </td>
                        <td>
                            <input type="text" value="Stade" name="stade" id="">
                        </td>
                        <td>
                            <input type="text" list="tour" name="tour" id="">
                        </td>
                        <td>
                            <input type="submit" name="envoi" value="Envoyer">
                        </td>
                    </form>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php endif ?>

</div>