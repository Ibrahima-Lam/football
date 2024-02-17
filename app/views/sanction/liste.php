<div class="content">
    <div class="flex-between">
        <h2 class="titre" id='title'>Les Sanctions</h2>
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
    <div class="flex-end">
        cumulé <input type="radio" name="sanction" value="cumule" class="sanctiontype">
        non cumulé<input type="radio" name="sanction" value="noncumule" checked class="sanctiontype">
        Avertis.<input type="radio" name="sanction" value="avertissement" class="sanctiontype">
        Susp.<input type="radio" name="sanction" value="suspension" class="sanctiontype">
    </div>
    <div class="card" id="teamcontent"></div>

</div>
<script type="module">
    import {
        loadSanction,
        loadAdvencedSanction,
    } from "./js/src.js";

    import {
        Table,
        TableSusp
    } from "./js/module/tableSanction.js";

    const team = document.getElementById('team');
    const srch = document.getElementById('srch');

    const teamcontent = document.getElementById('teamcontent');
    let sanctions = []
    let sanctionnes = []
    let suspendus = []
    let avertis = []

    window.addEventListener('load', async function(e) {
        sanctions = await loadSanction(false)
        sanctionnes = await loadSanction(true)
        suspendus = await loadAdvencedSanction(true)
        avertis = await loadAdvencedSanction(false)
        charger()
    })
    team.addEventListener('change', function(e) {
        charger()
    })
    srch.addEventListener('input', function(e) {
        charger()
    })

    let sanctiontype = 'noncumule'
    const sanctiontypes = document.querySelectorAll('.sanctiontype')
    sanctiontypes.forEach(element => {
        element.addEventListener('change', function(e) {
            sanctiontype = e.target.value
            charger()
        })
    });

    function charger() {
        teamcontent.innerHTML = ''
        const filtre = team.value
        const search = srch.value
        let elements = sanctiontype == 'cumule' ? sanctionnes :
            (sanctiontype == 'avertissement' ? avertis :
                (sanctiontype == 'suspension' ? suspendus : sanctions))
        if (filtre) elements = elements.filter(val => val.idParticipant == filtre)
        if (search) elements = elements.filter(val => val.nomJoueur.toUpperCase().includes(search.toUpperCase()) || val.dateGame.toUpperCase().includes(search.toUpperCase()))
        teamcontent.innerHTML = sanctiontype == 'cumule' || sanctiontype == 'suspension' ? TableSusp.tbody(elements) : Table.tbody(elements)
    }
</script>