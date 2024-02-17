<div class="content">
    <?php $title = "detail du match" ?>
    <?php

    use src\factory\But;
    use  src\Service\Generateur;

    $homeScorers = But::filterByTeam($buts, $match->idHome);
    $awayScorers = But::filterByTeam($buts, $match->idAway);

    ?>
    <?php if ($_admin) : ?>

        <div id='popover' class='popover' popover>
            <button class="btn flex" data-form="score">Editer le score</button>
            <?php if ($match->codePhase != 'grp') : ?>
                <button class="btn flex" data-form="tiraubut">Editer le Tir au but</button>
            <?php endif ?>
            <button class="btn flex" data-form="sanction">Ajouter une sanction</button>
            <button class="btn flex" data-form="but">Ajouter un but</button>
            <button class="btn flex" data-form="match">Editer le match</button>

        </div>
        <div class="flex-end" id="param"><button class="btn" popovertarget='popover'>...</button></div>
    <?php endif ?>


    <div class="flex">
        <input type="hidden" value="<?= $match->idGame ?>" id="game">
        <input type="hidden" value="<?= $match->nomGroupe ?>" id="groupe">
        <?php if ($match->dateGame) : ?>
            <h3 class="titre green"><?= Generateur::getDate($match->dateGame) ?></h3>
        <?php endif ?>
    </div>

    <div class="flex">
        <div class="game">
            <div class="game-row">
                <div class="game-left">
                    <h3 class="game-home"><?= $match->home ?></h3>
                    <div class="game-scorer">
                        <ul class="list">
                            <?php foreach ($homeScorers as $scorer) : ?>
                                <li>
                                    <?= $scorer->nomJoueur ?>
                                    <?= $scorer->minute ?>
                                    <?= $scorer->codeMarque === "penalty" ? "(P)" : ($scorer->codeMarque === "butcontre" ? "(OG)" : "") ?>

                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="game-middle">
                    <div class="game-score">
                        <?php if ($match->homeScorePenalty) : ?>
                            <span> (<?= $match->homeScorePenalty ?>) </span>
                        <?php endif ?>
                        <p>
                            <?php if ($match->homeScore !== null && $match->awayScore !== null) : ?>
                                <strong><?= $match->homeScore ?></strong>
                                <strong>-</strong>
                                <strong><?= $match->awayScore ?></strong>
                            <?php elseif ($match->heureGame) : ?>
                                <strong><?= $match->heureGame ?></strong>
                            <?php else : ?>
                                <strong>VS</strong>
                            <?php endif ?>
                        </p>
                        <?php if ($match->awayScorePenalty) : ?>
                            <span> (<?= $match->awayScorePenalty ?>) </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="game-right">
                    <h3 class="game-home"><?= $match->away ?></h3>
                    <div class="game-scorer">
                        <ul class="list">
                            <?php foreach ($awayScorers as $scorer) : ?>
                                <li>
                                    <?= $scorer->nomJoueur ?>
                                    <?= $scorer->minute ?>
                                    <?= $scorer->codeMarque === "penalty" ? "(P)" : ($scorer->codeMarque === "butcontre" ? "(OG)" : "") ?>

                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($match->homeScore !== null && $match->awayScore !== null) : ?>

        <h3 class="titre flex green">Le Statistique</h3>
        <div class="flex">
            <table class="table striped">
                <thead>
                    <tr>
                        <th><?= $match->home ?></th>
                        <th>vs</th>
                        <th><?= $match->away ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats ?? [] as $key => $stat) : ?>
                        <tr>
                            <td><?= $stat['home'] ?></td>
                            <td><?= $key ?></td>
                            <td><?= $stat['away'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
    <br>
    <br>
    <?php
    if (sizeof($sanctions) !== 0) :
    ?>
        <h3 class="titre flex green">Les Sanctions</h3>
        <div class="table-container">
            <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Joueur</th>
                        <th>Equipe</th>
                        <th>Sanction</th>
                        <th>Minute</th>
                        <?php if ($_admin) : ?>
                            <th>Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sanctions as $sanction) : ?>
                        <tr>
                            <td><?= $sanction->idSanctionner ?></td>
                            <td><a href="?p=joueur/details&joueur=<?= $sanction->idJoueur ?>" class="link"><?= $sanction->nomJoueur ?></a></td>
                            <td><a href="?p=equipe/details&equipe=<?= $sanction->idParticipant ?>" class="link"><?= $sanction->nomEquipe ?></a></td>
                            <td><?= $sanction->nomSanction ?></td>
                            <td><?= $sanction->minute ?></td>
                            <?php if ($_admin) : ?>
                                <td><button class="button sanction-action" data-id="<?= $sanction->idSanctionner ?>">...</button></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
    <?php
    if (sizeof($buts) !== 0) :
    ?>
        <h3 class="titre flex green">Les Buts</h3>
        <div class="table-container">
            <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Joueur</th>
                        <th>Equipe</th>
                        <th>But</th>
                        <th>Minute</th>
                        <?php if ($_admin) : ?>
                            <th>Actions</th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($buts as $but) : ?>
                        <tr>
                            <td><?= $but->idBut ?></td>
                            <td><a href="?p=joueur/details&joueur=<?= $but->idJoueur ?>" class="link"><?= $but->nomJoueur ?></a></td>
                            <td><a href="?p=equipe/details&equipe=<?= $but->idParticipant ?>" class="link"><?= $but->nomEquipe ?></a></td>
                            <td><?= $but->nomMarque ?></td>
                            <td><?= $but->minute ?></td>
                            <?php if ($_admin) : ?>
                                <td><button class="button but-action" data-id="<?= $but->idBut ?>">...</button></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>
<script type="module">
    import {
        DialogTag,
    } from "./js/src.js";
    import {
        scoreForm,
        tiraubutForm,
        butForm,
        sanctionForm,
        matchForm,
    }
    from "./js/form.js";


    const popover = document.getElementById('popover');
    const actions = popover?.querySelectorAll('button')
    const game = document.getElementById('game');
    const groupe = document.getElementById('groupe');
    actions?.forEach(element => {
        element.addEventListener('click', function(e) {
            handle(e.target.dataset.form)
        })
    });

    const sanctionAction = document.querySelectorAll('.sanction-action')
    sanctionAction.forEach(element => {
        element.addEventListener('click', function(e) {
            handle('sanction', {
                id: e.target.dataset.id,
            })
        })
    });
    const butAction = document.querySelectorAll('.but-action')
    butAction.forEach(element => {
        element.addEventListener('click', function(e) {
            handle('but', {
                id: e.target.dataset.id,
            })
        })
    });

    async function handle(table, data = {}) {

        let content = null
        let callback = null
        if (table == 'match')[content, callback] = await matchForm(groupe.value, game.value)
        if (table == 'score')[content, callback] = await scoreForm(game.value)
        if (table == 'tiraubut')[content, callback] = await tiraubutForm(game.value)
        if (table == 'sanction')[content, callback] = await sanctionForm({
            ...data,
            match: game.value
        })
        if (table == 'but')[content, callback] = await butForm({
            ...data,
            match: game.value
        })
        const dialog = new DialogTag(document.body, content, "Formulaire de " + (table == 'tiraubut' ? 'Tir au but' : table))
        dialog.show()
        const form = dialog.element.querySelector('#form')
        form?.addEventListener('submit', async function(e) {
            e.preventDefault()
            const result = await callback(e.target)
            let response = {}
            try {
                response = JSON.parse(result)
            } catch (error) {
                response = {
                    res: false
                }
                console.log(error);
            }
            if (response.res) {
                alert('saisie effectué avec succés!')
                dialog.close()
                window.location.reload()
            } else alert('echec de saisis')
        })
    }
</script>