<div class="content">
    <?php
    $title =  ($equipe->nomEquipe ?? null)
    ?>
    <?php if ($_admin) : ?>
        <div class="popover" id="popover" popover>
            <button class="btn" data-form="but">Ajouter un but</button>
            <button class="btn" data-form="sanction">Ajouter une sanction</button>
            <button class="btn" data-form="joueur">Ajouter un joueur</button>
            <button class="btn" data-form="participation">Editer la participation</button>
            <button class="btn" data-form="equipe">Editer l'équipe</button>
        </div>
        <div class="flex-end">
            <button class="button" popovertarget='popover'>...</button>
        </div>
    <?php endif ?>
    <div class="flex-between">
        <h2 class="titre" id="title">Une Equipe</h2>
        <div>
            <button class="btn  btn-nav" data-nav="match">Matchs</button>
            <button class="btn btn-nav" data-nav="joueur">Joueurs</button>
            <button class="btn btn-nav" data-nav="sanction">Sanctions</button>
            <button class="btn btn-nav" data-nav="but">Buts</button>
            <select name="" id="team" class="field">
                <?php foreach ($equipes as $val) : ?>
                    <?php $selected = $val->idParticipant == $equipe ? 'selected' : '' ?>
                    <option value="<?= $val->idParticipant ?>" <?= $selected ?>><?= $val->nomEquipe ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div id="equipecontent"></div>

</div>
<script type="module">
    import {
        loadEquipe,
        loadMatch,
        loadJoueur,
        loadSanction,
        loadBut,

    } from "./js/src.js";
    import {
        Table
    } from "./js/module/tableJoueur.js";
    import {
        Table as Sanction
    } from "./js/module/tableSanction.js";
    import {
        Table as But
    } from "./js/module/tableBut.js";
    import {
        Match
    } from "./js/module/matchComposant.js";

    import {
        DialogTag,
    } from "./js/src.js";
    import {
        equipeForm,
        joueurForm,
        sanctionForm,
        butForm,
        participationForm
    } from "./js/form.js";

    const equipecontent = document.getElementById('equipecontent');
    const team = document.getElementById('team');
    const title = document.getElementById('title');
    let equipes = {}
    let Equipe = null
    let matchs = []
    let joueurs = []
    let sanctions = []
    let buteurs = []

    window.addEventListener('load', async function(e) {
        equipes = await loadEquipe()
        matchs = await loadMatch()
        joueurs = await loadJoueur()
        sanctions = await loadSanction(false)
        buteurs = await loadBut()
        charger()
    })

    team.addEventListener('input', function(e) {
        charger()
    })

    let callback = sessionStorage.getItem('equipe-details') ?? 'match'
    const navs = document.querySelectorAll('.btn-nav')
    navs.forEach(element => {
        element.addEventListener('click', function(e) {
            callback = this.dataset.nav
            sessionStorage.setItem('equipe-details', this.dataset.nav)
            this.classList.add('btn-primary')
            charger()
        })
    });




    function charger() {
        const filtre = team.value
        Equipe = equipes.filter(val => val.idParticipant == filtre)[0]
        title.innerText = Equipe?.nomEquipe
        document.title = Equipe?.nomEquipe


        navs.forEach(elmt => elmt.classList.remove('btn-primary'))
        navs.forEach(elmt => {
            if (elmt.dataset.nav == callback) elmt.classList.add('btn-primary')
        })
        switch (callback) {
            case 'match':
                matchcons()
                break;
            case 'joueur':
                joueurcons()
                break;
            case 'sanction':
                sanctioncons()
                break;
            case 'but':
                butcons()
                break;

            default:
                matchcons()
                break;
        }
    }

    function joueurcons() {
        equipecontent.innerHTML = ''
        const filtre = team.value
        let elememts = joueurs.filter(val => val.idParticipant == filtre)
        equipecontent.innerHTML = Table.tbody(elememts)
    }

    function sanctioncons() {
        equipecontent.innerHTML = ''
        const filtre = team.value
        let elememts = sanctions.filter(val => val.idParticipant == filtre)
        equipecontent.innerHTML = Sanction.tbody(elememts)
    }

    function butcons() {
        equipecontent.innerHTML = ''
        const filtre = team.value
        let elememts = buteurs.filter(val => val.idTeam == filtre)
        equipecontent.innerHTML = But.tbody(elememts)
    }

    function matchcons() {
        equipecontent.innerHTML = ''
        const filtre = team.value
        let elememts = matchs.filter(val => val.idHome == filtre || val.idAway == filtre)
        let level = null
        elememts.forEach(elmt => {
            if (level != elmt.codePhase) {
                equipecontent.innerHTML += `<div class='flex'> <h3 class="green">${elmt.nomPhase}</h3> </div>`
                level = elmt.codePhase
            }
            equipecontent.innerHTML += Match.game(elmt)

        })
        Match.handleClick()

    }
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
        if (table == 'participation')[content, callback] = await participationForm(Equipe.idParticipation)
        if (table == 'equipe')[content, callback] = await equipeForm(Equipe.idEquipe)
        if (table == 'joueur')[content, callback] = await joueurForm(null, Equipe.idParticipant)
        if (table == 'sanction')[content, callback] = await sanctionForm({
            equipe: Equipe.idParticipant
        })
        if (table == 'but')[content, callback] = await butForm({
            equipe: Equipe.idParticipant
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