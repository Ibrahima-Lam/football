<div class="content">
    <?php

    use  src\Service\Generateur;

    $title = "Match";

    ?>


    <div id="match-container">
        <?php
        $date = null;
        $niveau = null
        ?>

        <?php foreach ($matchs as $match) : ?>
            <?php if ($niveau !== $match->nomNiveau) : ?>
                <h2 class="titre"><?= $match->nomNiveau ?></h2>
                <?php $niveau = $match->nomNiveau ?>
            <?php endif ?>
            <?php if ($match->dateGame !== $date && !empty($match->dateGame)) : ?>
                <div class="match-date">
                    <div class="mtch">
                        <span class="day"><?= Generateur::getDate($match->dateGame)  ?></span>
                    </div>
                </div>
                <?php $date = $match->dateGame ?>
            <?php endif ?>
            <div class="match-row">

                <div class="match-body element" data-id="<?= $match->idGame ?>" data-homescore="<?= $match->homeScore ?>" data-awayscore="<?= $match->awayScore ?>">
                    <div class="match-left">

                    </div>
                    <div class="match-middle ">
                        <span class="home"><?= $match->home ?></span>
                        <?php if ($match->homeScore !== null && $match->awayScore !== null) : ?>
                            <span class="vs"><?= $match->homeScore, "-", $match->awayScore ?></span>
                        <?php elseif ($match->heureGame !== null) : ?>
                            <span class="vs"><?= $match->heureGame ?></span>
                        <?php else : ?>
                            <span class="vs">vs</span>
                        <?php endif ?>

                        <span class="away"><?= $match->away ?></span>
                    </div>
                    <div class="match-right">
                        <?php if ($_admin ?? null) : ?>
                            <div class="actions">
                                <div class="menu-container">
                                    <div class="dialog-body menu-item">
                                        <ul>
                                            <li><button class="config btn">Score</button></li>
                                            <li><a href="?p=match/details&match=<?= $match->idGame ?>">Détail</a></li>
                                            <li><a href="?p=but/form&match=<?= $match->idGame ?>">Ajouter un buteur</a></li>
                                            <li><a href="?p=sanction/form&match=<?= $match->idGame ?>">Ajouter une sanction</a></li>
                                            <li><a href="?p=match/form/edit&match=<?= $match->idGame ?>">Editer</a></li>
                                            <li><a class="delete" href="?p=match/traitement/delete&match=<?= $match->idGame ?>">Supprimer</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <button class="btn menu">...</button>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

        <?php endforeach ?>
    </div>
    <div class="titre">
        <a class="link" href="?p=match">Tout</a>
        <a class="link" href="?p=match&played=1">Joués</a>
        <a class="link" href="?p=match&played=-1"> Non Joués</a>
    </div>
    <a class="link" href="?p=match/form">Ajouter un Match</a>



    </body>
    <script type="module">
        import {
            getData
        } from "./js/src.js";
        let data = []

        function getResult(res) {
            data = res
        }

        const matchs = document.querySelectorAll('.element')
        matchs.forEach(elmnt => {
            const vs = elmnt.querySelector(".vs")
            const id = elmnt.dataset.id
            const hs = elmnt.dataset.homescore
            const as = elmnt.dataset.awayscore
            const element = elmnt.querySelector(".config")
            const del = elmnt.querySelector(".delete")
            element.addEventListener('click', async function(e) {
                e.stopImmediatePropagation()
                setHidden()
                let edit = false
                if (hs && as) {
                    if (!confirm("voulez modifier le score ?")) {
                        if (confirm("voulez vous le supprimer ?")) {
                            await getData(`?p=match/score/delete/${id}`, getResult)
                            if (data.res ?? null) {
                                vs.innerText = "vs"
                                this.dataset.homescore = null
                                this.dataset.awayscore = null


                            }

                        }
                        return
                    }
                    edit = true
                }
                if (!confirm("voulez vous continuer")) return
                const homeScore = prompt("Entrer les but de l'quipe à gauche", 0)
                const awayScore = prompt("Entrer les but de l'quipe à droite", 0)
                const value = {
                    idGame: id,
                    homeScore: homeScore,
                    awayScore: awayScore
                }

                const dt = JSON.stringify(value)
                if (edit) await getData(`?p=match/score/update&data=${dt}`, getResult)
                else await getData(`?p=match/score/insert&data=${dt}`, getResult)

                if (!(data.idGame ?? null)) return
                const score = `${data.homeScore}-${data.awayScore}`
                vs.innerText = score
                this.dataset.homescore = data.homeScore
                this.dataset.awayscore = data.awayScore

            })

            del.addEventListener('click', function(e) {
                e.preventDefault()
                if (confirm("voulez supprimer le Match")) {
                    window.location.assign(`?p=match/traitement/delete&match=${id}`)
                }
            })
        });

        const actions = document.querySelectorAll('.actions')
        actions.forEach(element => {
            const menu = element.querySelector(".menu")
            const listItem = element.querySelector(".menu-item")
            menu.addEventListener('click', function(e) {
                e.stopImmediatePropagation()
                setHidden()
                listItem.classList.add("show")
            })

            document.addEventListener('click', function(e) {
                listItem.classList.remove("show")

            })
        });

        function setHidden() {
            actions.forEach(element => {
                element.querySelector(".menu-item").classList.remove("show")
            });
        }
    </script>
</div>