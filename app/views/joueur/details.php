<div class="content">
    <?php if ($player) : ?>
        <input type="hidden" value="<?= $player->idJoueur ?>" id="joueur">
        <?php if ($_admin) : ?>
            <div class="popover" id="popover" popover>
                <button class="btn" data-form="but">Ajouter un but</button>
                <button class="btn" data-form="sanction">Ajouter une sanction</button>
                <button class="btn" data-form="joueur">Editer le joueur</button>

            </div>
            <div class="flex-end">
                <button class="button" popovertarget='popover'>...</button>
            </div>
        <?php endif ?>



        <h2 class="titre flex"><?= $player->nomJoueur ?></h2>
        <table class="table striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Equipe</th>
                    <th>Nombre de buts</th>
                    <th>Nombre de Sanctions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $player->idJoueur ?></td>
                    <td><a href="?p=equipe/details&equipe=<?= $player->idParticipant ?>" class="link"><?= $player->nomEquipe ?></a></td>
                    <td><?= (sizeof($buts)) ?></td>
                    <td><?= (sizeof($sanctions)) ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif ?>

    <?php if ($buts) : ?>
        <h3 class="titre flex green">Buts</h3>
        <h4 class=""><?= (sizeof($buts)) ?>buts marqué(s)</h4>
        <table class="table striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>But Marqué</th>
                    <th>T. But Marqué</th>
                    <th>Minute</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buts as $but) : ?>
                    <tr>
                        <td><?= $but->idBut ?></td>
                        <td><?= $but->nomMarque ?></td>
                        <td><?= $but->typeMarque ?></td>
                        <td><?= $but->minute ?></td>
                        <td><a class="link" href="?p=match/details&match=<?= $but->idGame ?>"><?= $but->dateGame ?></a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

    <?php if ($sanctions) : ?>
        <h3 class="titre flex green">Les Sanctions</h3>
        <table class="table striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sanction</th>
                    <th>Munite</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sanctions as $sanction) : ?>
                    <tr>
                        <td><?= $sanction->idJoueur ?></td>
                        <td><?= $sanction->nomSanction ?></td>
                        <td><?= $sanction->minute ?></td>
                        <td><a class="link" href="?p=match/details&match=<?= $sanction->idGame ?>"><?= $sanction->dateGame ?></a></td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
<script type="module">
    import {
        DialogTag,
    } from "./js/src.js";
    import {
        joueurForm,
        sanctionForm,
        butForm,
    } from "./js/form.js";

    const joueurInput = document.getElementById('joueur');
    const joueurId = joueurInput?.value


    const popover = document.getElementById('popover');
    const popoverActions = popover?.querySelectorAll('button')
    popoverActions.forEach(element => {
        element.addEventListener('click', function(e) {
            handle(e.target.dataset.form, )
        })
    });

    async function handle(table, data = {}) {

        let content = null
        let callback = null
        if (table == 'joueur')[content, callback] = await joueurForm(joueurId)
        if (table == 'sanction')[content, callback] = await sanctionForm({
            joueur: joueurId
        })
        if (table == 'but')[content, callback] = await butForm({
            joueur: joueurId
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
            } else alert('echec de saisis!')
        })
    }
</script>