<div class="content">
    <div class="flex-between">
        <h2 class="titre" id='title'>Les Matchs</h2>
        <div>
            <input class="field" type="search" name="" id="srch" placeholder="Recherche...">

            <select class="field" name="" id="grps">
                <option value="">Tous</option>
                <?php foreach ($groupes as $val) : ?>
                    <?php $selected = $val->nomGroupe == $groupe ? 'selected' : '' ?>
                    <option value="<?= $val->nomGroupe ?>" <?= $selected ?>><?= $val->codePhase == 'grp' ? $val->nomGroupe : ucfirst($val->nomPhase) ?></option>

                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="flex-end">
        Tous <input type="radio" name="match" class="matchtype default" checked value="0">
        Joués <input type="radio" name="match" class="matchtype" value="1">
        Non Joués <input type="radio" name="match" class="matchtype" value="-1">
    </div>
    <div class="card" id="matchcontent"></div>

</div>
<script type="module">
    import {
        loadMatch
    } from "./js/src.js";

    import {
        Match
    } from "./js/module/matchComposant.js";

    const grps = document.getElementById('grps');
    const srch = document.getElementById('srch');
    const matchcontent = document.getElementById('matchcontent');
    let matchs = []
    let matchtype = 0

    window.addEventListener('load', async function(e) {
        matchs = await loadMatch()
        charger()
    })
    grps.addEventListener('change', function(e) {
        trigger()
        charger()

    })
    srch.addEventListener('input', function(e) {
        trigger()
        charger()
    })

    function trigger() {
        const element = document.querySelector('.default')
        element.checked = true
        matchtype = 0
    }

    const matchtypes = document.querySelectorAll('.matchtype')
    matchtypes.forEach(element => {
        element.addEventListener('change', function(e) {
            matchtype = e.target.value
            charger()
        })
    });

    function charger() {
        matchcontent.innerHTML = ''

        const filtre = grps.value
        const search = srch.value

        let elements = matchs
        if (!elements.length) return matchcontent.innerHTML = '<p class="flex">Pas de Matchs</p>'
        if (filtre) elements = elements.filter(val => val.nomGroupe == filtre)
        if (matchtype == 1 || matchtype == -1) elements = matchtype == 1 ? elements.filter(val => val.homeScore !== null && val.awayScore !== null) : elements.filter(val => val.homeScore == null || val.awayScore == null)
        if (search) elements = elements.filter(val => val.home.toUpperCase().includes(search.toUpperCase()) || val.away.toUpperCase().includes(search.toUpperCase()))

        let level = null
        elements.forEach(elmt => {
            if (level != elmt.codePhase) {
                matchcontent.innerHTML += `<div class='flex'> <h3 class="green">${elmt.nomPhase}</h3> </div>`
                level = elmt.codePhase
            }
            matchcontent.innerHTML += Match.game(elmt)

        })
        Match.handleClick()
    }
</script>