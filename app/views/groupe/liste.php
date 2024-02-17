<div class="content">
    <?php
    $title = "Groupe";
    ?>
    <input type="hidden" id="edition" value="<?= $edition->codeEdition ?? null ?>">
    <?php if ($_admin) : ?>

        <div class="popover" id="popover" popover>
            <button class="btn flex" data-form="groupe">Ajouter un groupe</button>
            <button class="btn flex" data-form="edition">Editer l'édition</button>
        </div>
        <div class="flex-end"><button class="btn" popovertarget="popover">...</button></div>
    <?php endif ?>
    <?php if ($groupes) : ?>

        <div class="table-container">
            <table class="table striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Phase</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groupes as $groupe) : ?>
                        <tr class="groupe-element" data-nom="<?= $groupe->nomGroupe ?>">
                            <td><a class="link" href="?p=groupe/equipe&groupe=<?= $groupe->nomGroupe ?>"><?= $groupe->nomGroupe ?></a></td>
                            <td><?= $groupe->nomPhase ?></td>
                            <td><?= $groupe->typePhase ?></td>
                            <td><a class="link" href="?p=groupe/details&groupe=<?= $groupe->nomGroupe ?>"> Détails</a></td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>
        <h3 class="flex">Pas de Groupe</h3>
    <?php endif ?>
</div>
<script type="module">
    import {
        DialogTag,
    } from "./js/src.js";
    import {
        groupeForm,
        editionForm
    } from "./js/form.js";
    const edition = document.getElementById('edition');
    const popover = document.getElementById('popover');
    const popoverElement = popover?.querySelectorAll('button')
    popoverElement?.forEach(element => {
        element.addEventListener('click', function(e) {
            handle(this.dataset.form)
        })
    });



    async function handle(table, data = {}) {

        let content = null
        let callback = null
        if (table == 'edition')[content, callback] = await editionForm(edition.value)
        if (table == 'groupe')[content, callback] = await groupeForm()

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