<div class="content">
    <h2 class="titre flex">Les Paramettres des pages</h2>
    <div class="list">
        <ul>
            <li><a href="?p=match/param">Paramettre de match</a></li>
            <li><a href="?p=equipe/param">Paramettre de l'équipe</a></li>
            <li><a href="?p=joueur/param">Paramettre de joueur</a></li>
        </ul>

    </div>
    <h2 class="titre flex">Générateur</h2>
    <div class="list">
        <ul>
            <li><a href="?p=paramettre/generateur">Eventuels Matchs</a></li>
            <li><a href="?p=paramettre/teste">Teste</a></li>
        </ul>
    </div>
    <h2 class="titre flex">Ajout des éléments</h2>
    <div class="flex wrap">
        <button class="btn form-builder" data-table="competition">Compétition</button>
        <button class="btn form-builder" data-table="edition">Edition</button>
        <button class="btn form-builder" data-table="groupe">Groupe</button>
        <button class="btn form-builder" data-table="equipe">Equipe</button>
        <button class="btn form-builder" data-table="participant">Participant</button>
        <button class="btn form-builder" data-table="participation">Participation</button>
        <button class="btn form-builder" data-table="match">Match</button>
        <button class="btn form-builder" data-table="score">Score</button>
        <button class="btn form-builder" data-table="tiraubut">Tir au but</button>
        <button class="btn form-builder" data-table="joueur">Joueur</button>
        <button class="btn form-builder" data-table="sanction">Sanction</button>
        <button class="btn form-builder" data-table="but">But</button>

    </div>

</div>
<script type="module">
    import {
        DialogTag,
    } from "./js/src.js";
    import *
    as Forms
    from "./js/form.js";

    async function construct(e) {
        const table = e.target.dataset.table
        let content = ''
        let callback = null
        switch (table) {
            case 'competition':
                [content, callback] = await Forms.competitionForm()
                break;
            case 'edition':
                [content, callback] = await Forms.editionForm()
                break;
            case 'groupe':
                [content, callback] = await Forms.groupeForm()
                break;
            case 'equipe':
                [content, callback] = await Forms.equipeForm()
                break;
            case 'participant':
                [content, callback] = await Forms.participantForm()
                break;
            case 'participation':
                [content, callback] = await Forms.participationForm()
                break;
            case 'match':
                [content, callback] = await Forms.matchForm(prompt('Entrer le nom du groupe', 'A').toUpperCase())
                break;
            case 'score':
                [content, callback] = await Forms.scoreForm(prompt('Enter  id du match'))
                break;
            case 'tiraubut':
                [content, callback] = await Forms.tiraubutForm(prompt('Enter  id du match'))
                break;
            case 'joueur':
                [content, callback] = await Forms.joueurForm()
                break;
            case 'sanction':
                [content, callback] = await Forms.sanctionForm({})
                break;
            case 'but':
                [content, callback] = await Forms.butForm({})
                break;

            default:
                break;
        }

        const dialog = new DialogTag(document.body, content)
        dialog.show()
        const form = dialog.element.querySelector('#form')
        form?.addEventListener('submit', async function(e) {
            e.preventDefault()
            let result = null
            let response = {}
            result = await callback(e.target)
            try {
                response = JSON.parse(result)
            } catch (error) {
                response = {
                    res: false,
                    error: error
                }
            }
            if (response?.res ?? null) {
                alert("saisis avec succés!")
                dialog.close()
            } else alert('echec!')
            console.log(result);
            console.log(response);
        })
    }
    const builder = document.querySelectorAll('.form-builder')
    builder.forEach(element => {
        element.addEventListener('click', function(e) {
            construct(e)
        })
    });
</script>