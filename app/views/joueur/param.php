<div class="content">
    <h2 class="titre">
        Les Joueurs
    </h2>

    <?php foreach ($equipes as $equipe) : ?>
        <?php
        $players = array_filter($joueurs, function ($element) use ($equipe): bool {
            return $element->idParticipant == $equipe->idParticipant;
        });
        if (sizeof($players) === 0) continue;
        ?>
        <div class="table-container">
            <h3 class="titre"><?= $equipe->nomEquipe ?></h3>
            <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th> Equipe</th>
                        <?php if ($_admin ?? null) : ?>
                            <th>Action</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $joueur) : ?>
                        <tr>
                            <td><?= $joueur->idJoueur ?></td>
                            <td><?= $joueur->nomJoueur ?></td>
                            <td><?= $joueur->nomEquipe ?></td>
                            <?php if ($_admin ?? null) : ?>
                                <td>
                                    <div class="action">
                                        <div class="menu-container">
                                            <div class="dialog-body menu-item">
                                                <ul>
                                                    <li><a href="?p=but/form&joueur=<?= $joueur->idJoueur ?>">Ajouter un but</a></li>
                                                    <li><a href="?p=sanction/form&joueur=<?= $joueur->idJoueur ?>">Ajouter une sanction</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                        <button class="btn menu">...</button>
                                    </div>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endforeach ?>
</div>
<script>
    const actions = document.querySelectorAll('.action')
    actions.forEach(element => {
        const menu = element.querySelector(".menu")
        const listItem = element.querySelector(".menu-item")
        menu.addEventListener('click', function(e) {
            e.stopImmediatePropagation()
            actions.forEach(element => {
                element.querySelector(".menu-item").classList.remove("show")
            });
            listItem.classList.add("show")
        })

        document.addEventListener('click', function(e) {
            listItem.classList.remove("show")

        })
    });
</script>