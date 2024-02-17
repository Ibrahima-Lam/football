<div class="content">
    <?php
    $title = "statistiques";
    ?>
    <div class="flex-between">
        <h2 class="titre">Les statistiques</h2>
        <select class="field" name="" id="grps">
            <option value="">Tous</option>
            <?php foreach ($groupes as $value) : ?>
                <?php $selected = $groupe == $value->nomGroupe ? 'selected' : '' ?>
                <option value="<?= $value->nomGroupe ?>" <?= $selected ?>><?= $value->nomGroupe ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div id="statcontent"></div>
</div>
<script type="module">
    import {
        loadStat,
        loadGroupe
    } from "./js/src.js";
    import {
        Table
    } from "./js/module/tableStat.js";

    const grps = document.getElementById('grps');
    const statcontent = document.getElementById('statcontent');
    let groupes = []
    let stats = {}
    window.addEventListener('load', async function(e) {
        stats = await loadStat()
        groupes = await loadGroupe()
        charger()
    })

    grps.addEventListener('change', function(e) {
        charger()
    })

    function charger() {
        statcontent.innerHTML = ''
        const filtre = grps.value
        let elements = groupes
        if (!elements.length) return statcontent.innerHTML = '<p class="flex">Pas de données</p>'
        if (filtre) elements = elements.filter(val => val.nomGroupe == filtre)
        elements.forEach(element => {
            if (element.codePhase != 'grp') return
            const titre = `<h3 class="titre"><a class="link" href="?p=groupe/details&groupe=${element.nomGroupe}">Groupe ${element.nomGroupe}</a></h3>`
            const div = document.createElement('div')
            div.innerHTML = titre + Table.tab(stats[element.nomGroupe])
            statcontent.append(div)

        });
    }
</script>