<div class="content">
    <?php $day = null ?>
    <?php foreach ($games as $item) : ?>
        <?php if ($item["day"] != $day) : ?>
            <h3 class="titre">Journée <?= $item["day"] ?></h3>
            <?php $day = $item["day"] ?>
        <?php endif ?>
        <div class="match-row">
            <div class="match-body">
                <span><?= $item["home"] ?></span>
                <span class="vs">vs</span>
                <span> <?= $item["away"] ?></span>
            </div>
        </div>
    <?php endforeach ?>

</div>