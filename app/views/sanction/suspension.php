<div class="content">
    <h2 class="titre">Les Sanctions</h2>
    <?php foreach ($equipes as $equipe) : ?>
        <?php
        $players = array_filter($sanctions, function ($element) use ($equipe): bool {
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
                        <th> Sanction</th>
                        <th>Nbr. Match</th>
                        <th> Motif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $joueur) : ?>
                        <?php $sanction = $joueur->codeSanction ?>
                        <?php $nbr = $joueur->nombreCarton ?>


                        <?php
                        $motif = $joueur->motif ?? null;
                        if (!$motif) {
                            if ($sanction == "rouge") $motif = "double cartons jaunes";
                            elseif ($sanction == "rougedirect") $motif = "Caton rouge direct";
                            elseif ($sanction == "rougeetsanction") $motif = "Carton rouge et sanction disciplinaire";
                            elseif ($sanction == "jaune" && $nbr >= 2) $motif = "Deux Cartons Jaunes";
                        }
                        $nombre = $joueur->nombreMatch ?? 0;
                        if (!$nombre) {
                            if ($sanction == "rouge") $nombre = 1;
                            elseif ($sanction == "rougedirect") $nombre = 1;
                            elseif ($sanction == "jaune" && $nbr >= 2) $nombre = 1;
                        }
                        ?>
                        <tr>
                            <td><?= $joueur->idJoueur ?></td>
                            <td><?= $joueur->nomJoueur ?></td>
                            <td><?= $joueur->nomEquipe ?></td>
                            <td>
                                <div class="flex">
                                    <?php for ($i = 1; $i <= $nbr; $i++) : ?>
                                        <?php if ($sanction === "jaune") : ?>

                                            <div class="carton-jaune"></div>

                                        <?php elseif ($sanction === "rouge") : ?>

                                            <div class="carton-rouge"></div>

                                        <?php elseif ($sanction === "rougedirect") : ?>
                                            <div class="flex">
                                                <div class="carton-rouge">!</div>
                                            </div>
                                        <?php elseif ($sanction === "rougeetsanction") : ?>

                                            <div class="carton-rouge"></div>
                                            <div>+</div>

                                        <?php elseif ($sanction === "sanction") : ?>
                                            <span> Sanction administrative</span>
                                        <?php endif ?>
                                    <?php endfor ?>
                                </div>
                            </td>
                            <td>
                                <?= $nombre ?? 0 ?>
                            </td>
                            <td><?= $motif ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endforeach ?>
</div>