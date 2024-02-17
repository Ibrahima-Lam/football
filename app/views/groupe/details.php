<div class="content">

    <div class="flex-between">
        <h2 id="title">Groupe <?= $groupe ?? 'A' ?></h2>
        <div class="flex-end">
            <select id="grps" class="field">
                <?php foreach ($groupes as $val) : ?>
                    <?php $selected = $val->nomGroupe == $groupe ? 'selected' : '' ?>
                    <option value="<?= $val->nomGroupe ?>" <?= $selected ?>><?= $val->codePhase == 'grp' ? $val->nomGroupe : ucfirst($val->nomPhase) ?></option>
                <?php endforeach ?>
            </select>

            <?php if ($_admin) : ?>
                <div class="popover" id="popover" popover>
                    <button class="btn flex" data-form="match">Ajouter un match</button>
                    <button class="btn flex" data-form="participation">Ajouter une participation</button>
                    <button class="btn flex" data-form="groupe">Editer le Groupe</button>
                </div>
                <button class="btn" popovertarget='popover'>...</button>
            <?php endif ?>
        </div>
    </div>
    <div id="grpcontent"></div>

</div>
<script type="module">
    import {
        Table
    } from "./js/module/tableEquipe.js";
    import {
        Table as statTable
    } from "./js/module/tableStat.js";
    import {
        Match
    } from "./js/module/matchComposant.js";
    import {
        loadGroupe,
        loadParticipation,
        loadStat,
        loadMatch,
    } from "./js/src.js";
    const grpcontent = document.getElementById('grpcontent');
    const grps = document.getElementById('grps');
    let Groupe = {}
    let groupes = []
    let participations = []
    let matchs = []
    let stats = {}



    window.addEventListener('load', async function(e) {
        groupes = await loadGroupe()
        participations = await loadParticipation()
        stats = await loadStat()
        matchs = await loadMatch()
        await charger()
    })

    function setTitle(value) {
        const title = document.getElementById('title');
        Groupe = groupes.filter(val => val.nomGroupe == value)[0]
        title.innerText = Groupe.codePhase == 'grp' ? `Groupe ${value}` : Groupe.nomPhase.toString().toUpperCase()

    }

    grps.addEventListener('change', function(e) {
        charger()
    })

    async function charger() {
        let filtre = grps.value
        setTitle(grps.value)
        grpcontent.innerHTML = ''
        let elements = groupes
        if (filtre) elements = elements.filter(val => val.nomGroupe == filtre)

        elements.forEach(element => {
            const div = document.createElement('div')
            div.classList.add('card')
            const titre = `<div class='flex'>  <h3 class='titre green'> Les Equipes  </h3>   </div>`
            const data = participations.filter(val => val.nomGroupe == element.nomGroupe)
            const content = titre + data.map(elmt => Table.tr(elmt)).join('')
            div.innerHTML = Table.tab(content)
            grpcontent.append(div)
            if (element.codePhase == 'grp') {
                const titre = `<div class='flex'>  <h3 class='titre green'>Le Classement</h3>  </div>`
                const div = document.createElement('div')
                div.classList.add('card')
                div.innerHTML = titre + statTable.tab(stats[element.nomGroupe])
                grpcontent.append(div)
            }
            const games = matchs.filter(val => val.nomGroupe == element.nomGroupe)
            const div2 = document.createElement('div')
            div2.classList.add('card')
            div2.innerHTML = `<div class='flex'> <h3 class='titre green'>Les Matchs</h3>   </div>`
            games.forEach(elmt => {

                div2.innerHTML += Match.date(elmt.dateGame)
                div2.innerHTML += Match.game(elmt)
            });
            grpcontent.append(div2)
            Match.handleClick()

        });
    }

    // -----------------------------------------Actions popover------------------------------------------------------


    import {
        DialogTag,
    } from "./js/src.js";
    import {
        participationForm,
        matchForm,
        groupeForm,
    }
    from "./js/form.js";
    const popover = document.getElementById('popover');
    const popoverElements = popover?.querySelectorAll('button')
    popoverElements?.forEach(element => {
        element.addEventListener('click', function(e) {
            handle(e.target.dataset.form)
        })
    });

    async function handle(table, data = {}) {

        let content = null
        let callback = null
        if (table == 'match')[content, callback] = await matchForm(Groupe.nomGroupe)
        if (table == 'participation')[content, callback] = await participationForm(null, Groupe.nomGroupe)
        if (table == 'groupe')[content, callback] = await groupeForm(Groupe.idGroupe)

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