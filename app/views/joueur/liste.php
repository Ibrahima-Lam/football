<div class="content">
    <div class="flex-between">
        <h2 class="titre" id='title'>Les joueurs</h2>
        <div>


            <input class="field" type="search" name="" id="srch" placeholder="Recherche...">

            <select class="field" name="" id="team">
                <option value="">Tous</option>
                <?php foreach ($equipes ?? [] as $val) : ?>
                    <?php $selected = $val->nomEquipe == ($equipe ?? null) ? 'selected' : '' ?>
                    <option value="<?= $val->idParticipant ?>" <?= $selected ?>><?= $val->nomEquipe  ?></option>

                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="card" id="teamcontent"></div>

</div>
<script type="module">
    import {
        loadJoueur,
    } from "./js/src.js";

    import {
        Table,

    } from "./js/module/tableJoueur.js";

    const team = document.getElementById('team');
    const srch = document.getElementById('srch');
    const teamcontent = document.getElementById('teamcontent');

    let joueurs = []


    window.addEventListener('load', async function(e) {
        joueurs = await loadJoueur()

        charger()
    })
    team.addEventListener('change', function(e) {
        charger()
    })
    srch.addEventListener('input', function(e) {
        charger()
    })


    function charger() {
        teamcontent.innerHTML = ''
        const filtre = team.value
        const search = srch.value
        let elements = joueurs
        if (filtre) elements = elements.filter(val => val.idParticipant == filtre)
        if (search) elements = elements.filter(val => val.nomJoueur.toUpperCase().includes(search.toUpperCase()))

        teamcontent.innerHTML = Table.tbody(elements)

    }
</script>