<div class="content">
    <?php
    $title = "Compétiotion";
    ?>
    <?php if ($data) : ?>
        <table class="table striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>NOM</th>
                    <th>Editions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php foreach ($data ?? [] as $item) : ?>
                <?php
                $tournois = array_filter($editions, function ($element) use ($item): bool {
                    return $item->codeCompetition == $element->codeCompetition;
                });
                usort($tournois, function ($a, $b): bool {
                    return $a->anneeEdition >= $b->anneeEdition ? -1 : 1;
                });
                ?>
                <tr>
                    <td><?= $item->codeCompetition ?></td>
                    <td><?= $item->nomCompetition ?></td>
                    <td><select name="" id="">
                            <?php foreach ($tournois as $val) : ?>
                                <option value="<?= $val->codeEdition ?>"><?= $val->anneeEdition ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td><a class="link" href="?competition=<?= $tournois[0]->codeEdition ?>">Aller à</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>

</div>