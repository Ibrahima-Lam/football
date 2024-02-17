<div class="content">
    <?php
    $title = "Paramettre";

    ?>
    <?php foreach ($games as $key => $tab) : ?>
        <h3 class="titre">Groupe <?= $key ?></h3>
        <?php foreach ($tab as $item) : ?>
            <div class="match-row">
                <div class="match-body">
                    <span><?= $item["home"]->nomEquipe ?></span>
                    <span class="vs">vs</span>
                    <span> <?= $item["away"]->nomEquipe ?></span>
                </div>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>
</div>