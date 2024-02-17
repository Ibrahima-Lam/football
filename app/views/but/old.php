<div class="content">

    <h2 class="titre">Les Buteurs</h2>
    <div class="table-container">
        <table class="table striped">
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Equipe</th>
                    <th>But Marqué</th>
                    <th>Nombre de but</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($buts  as $key => $but) : ?>
                    <tr>
                        <td>
                            <div class="player">
                                <div class="player-profil">
                                    <?= $key + 1 ?>
                                </div>
                                <div class="player-text">
                                    <div class="player-nom"><?= $but->nomJoueur ?></div>
                                    <div class="player-equipe"><?= $but->nomEquipe ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= $but->team ?>
                        </td>
                        <td>
                            <?= $but->nomMarque ?>
                        </td>
                        <td>
                            <?= $but->nombre ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php
        $total = array_reduce($buts, function ($a, $b): int {
            return $a + $b->nombre;
        }, 0);
        ?>
        <b> Total :<?= $total ?></b>
    </div>
    <a href="?p=joueur/form/but">Ajouter</a>
</div>