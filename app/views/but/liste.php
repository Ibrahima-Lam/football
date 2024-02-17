<div class="content">
    <div class="flex-between">
        <h2 class="titre" id='title'>Les Buts</h2>
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
    <div class="flex-between">
        <h3 id="total"></h3>
        <div class="flex-end">
            cumulé <input type="radio" name="sanction" value="cumule" checked class="buttype">
            non cumulé<input type="radio" name="sanction" value="noncumule" class="buttype">
        </div>
    </div>
    <div class="card" id="teamcontent"></div>

</div>
<script type="module">
    import {
        loadBut,
    } from "./js/src.js";

    import {
        Table,
        TableNonCumule
    } from "./js/module/tableBut.js";

    const team = document.getElementById('team');
    const srch = document.getElementById('srch');
    const total = document.getElementById('total');
    const teamcontent = document.getElementById('teamcontent');

    let buts = []
    let butcumules = []

    window.addEventListener('load', async function(e) {
        buts = await loadBut(false)
        butcumules = await loadBut(true)
        charger()
    })
    team.addEventListener('change', function(e) {
        charger()
    })
    srch.addEventListener('input', function(e) {
        charger()
    })

    let buttype = 'cumule'
    const buttypes = document.querySelectorAll('.buttype')
    buttypes.forEach(element => {
        element.addEventListener('change', function(e) {
            buttype = e.target.value
            charger()
        })
    });

    function charger() {
        teamcontent.innerHTML = ''
        const filtre = team.value
        const search = srch.value
        let elements = buttype == 'cumule' ? butcumules : buts
        if (filtre) elements = elements.filter(val => val.idParticipant == filtre)
        if (search) elements = elements.filter(val => val.nomJoueur.toUpperCase().includes(search.toUpperCase()) || val.dateGame.toUpperCase().includes(search.toUpperCase()))
        teamcontent.innerHTML = buttype == 'noncumule' ? TableNonCumule.tbody(elements) : Table.tbody(elements)
        total.innerText = 'Total : ' + (buttype == 'cumule' ? elements.reduce((t, v) => t + v?.nombre, 0) : elements.length) + 'but(s)'
    }
</script>