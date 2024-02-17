<div class="content">

    <input type="hidden" id="post" value='<?= $groupe ?? null ?>'>
    <div class="flex-between">
        <h2>Les Equipes</h2>
        <select id="grps" class="field">
            <option value="">Tous</option>
            <?php foreach ($groupes as $val) : ?>
                <?php $selected = $val->nomGroupe == $groupe ? 'selected' : '' ?>
                <option value="<?= $val->nomGroupe ?>" <?= $selected ?>><?= $val->codePhase == 'grp' ? $val->nomGroupe : ucfirst($val->nomPhase) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div id="grpcontent"></div>

</div>
<script type="module">
    import {
        Table
    } from "./js/module/tableEquipe.js";
    import {
        loadGroupe,
        loadParticipation
    } from "./js/src.js";

    import {
        DialogTag,
    } from "./js/src.js";
    import {
        equipeForm,
        participationForm
    } from "./js/form.js";
    const grpcontent = document.getElementById('grpcontent');

    const post = document.getElementById('post');
    const grps = document.getElementById('grps');
    let groupes = []
    let participations = []

    window.addEventListener('load', async function(e) {
        groupes = await loadGroupe()

        participations = await loadParticipation()
        await charger()
    })

    grps.addEventListener('change', function(e) {

        charger()
    })
    async function charger() {
        grpcontent.innerHTML = ''
        let elements = groupes
        let filtre = grps.value
        if (filtre) elements = elements.filter(val => val.nomGroupe == filtre)


        elements.forEach(element => {
            const div = document.createElement('div')
            const titre = `<h3 class="titre"><a class="link" href="?p=groupe/details&groupe=${element.nomGroupe}">Groupe ${element.nomGroupe}</a></h3>`
            const data = participations.filter(val => val.nomGroupe == element.nomGroupe)
            Table.setEditable(true)
            const content = titre + data.map(elmt => Table.tr(elmt)).join('')
            div.innerHTML = Table.tab(content)
            grpcontent.append(div)

        });
        if (!Table.editable) return
        const actions = document.querySelectorAll('.action-participation')
        actions.forEach(element => {
            element.addEventListener('click', function(e) {
                handle(e.target.dataset.form, {
                    id: e.target.dataset.id
                })
            })
        });
        const actions2 = document.querySelectorAll('.action-equipe')
        actions2.forEach(element => {
            element.addEventListener('click', function(e) {
                handle(e.target.dataset.form, {
                    id: e.target.dataset.equipe
                })
            })
        });
    }


    async function handle(table, data = {}) {
        const {
            id
        } = data
        let content = null
        let callback = null
        if (table == 'participation')[content, callback] = await participationForm(id)
        if (table == 'equipe')[content, callback] = await equipeForm(id)

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