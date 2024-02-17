<div class="content">
    <?php
    $title = 'Liste des equipes'
    ?>
    <div class="flex-between">
        <h2 class="titre">Les Equipes</h2>
        <input class="field" type="search" name="" id="srch" placeholder="Recherche...">
    </div>
    <div id="equipecontent"></div>

</div>
<script type="module">
    import {
        loadEquipe
    } from "./js/src.js";
    import {
        Table
    } from "./js/module/tableTeam.js";
    const equipecontent = document.getElementById('equipecontent');
    const srch = document.getElementById('srch');
    let equipes = []

    window.addEventListener('load', async function(e) {
        equipes = await loadEquipe()
        charger()
    })

    srch.addEventListener('input', function(e) {
        charger()
    })

    function charger() {
        equipecontent.innerHTML = ''
        const filtre = srch.value
        let elements = equipes
        if (filtre) elements = elements.filter(val => val.nomEquipe.toUpperCase().includes(filtre.toUpperCase()))
        equipecontent.innerHTML = Table.tbody(elements)

    }
</script>