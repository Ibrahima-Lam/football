<div class="content">
    <?php
    $title = "Equipes";

    ?>
    <?php foreach ($groupes as $groupe) : ?>
        <?php
        $teams = array_filter($equipes, function ($team) use ($groupe): bool {
            return $team->idGroupe === $groupe->idGroupe;
        })
        ?>
        <h2 class="titre">Groupe <?= $groupe->nomGroupe ?></h2>
        <table class="table striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Groupe</th>
                    <?php if ($_admin ?? null) : ?>

                        <th>Action</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($teams as $equipe) : ?>
                    <tr>
                        <td><?= $equipe->idParticipant ?></td>
                        <td><?= $equipe->nomEquipe ?></td>
                        <td><?= $equipe->nomGroupe ?></td>
                        <?php if ($_admin ?? null) : ?>
                            <td class="action">
                                <div class="menu-container">
                                    <div class="dialog-body menu-item">
                                        <ul>
                                            <li><a href="?p=joueur/form&team=<?= $equipe->idParticipant ?>">Ajouter un Joueur</a></li>
                                            <li><a href="?p=but/form&team=<?= $equipe->idParticipant ?>">Ajouter un buteur</a></li>
                                            <li><a href="?p=sanction/form&team=<?= $equipe->idParticipant ?>">Ajouter une sanction</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <button class="btn menu">...</button>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
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