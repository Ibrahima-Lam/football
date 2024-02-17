<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Dialadé-Foot" ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>

</head>

<body>
    <div class="nav-bar">
        <div class="nav-col">
            <div class="row1">
                <h2>Dialadé-Foot</h2>
                <div>
                    <?php if (!($_admin ?? false)) : ?>
                        <a href="?p=app/login" class='link'> Se Connecter </a>
                    <?php else : ?>
                        <a href="?p=app/logout" class='link'> Se Deconnecter </a>
                    <?php endif ?>
                </div>
                <div><select name="" id="compchanger">
                        <?php foreach ($_competitions ?? [] as $item) : ?>
                            <?php $selected = $item->nomEdition == $_comp ? 'selected' : '' ?>
                            <option value="<?= $item->codeEdition ?>" <?= $selected ?>><?= $item->nomCompetition ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="row2">
                <ul>
                    <li><a href="?">Accueil</a></li>
                    <li><a href="?p=competition">Compétition</a></li>
                    <li><a href="?p=groupe">Groupe</a></li>
                    <li><a href="?p=equipe">Equipe</a></li>
                    <li><a href="?p=match">Match</a></li>
                    <li><a href="?p=Stat">Stat</a></li>
                    <li><a href="?p=joueur">Joueur</a></li>
                    <li><a href="?p=sanction">Sanction</a></li>
                    <li><a href="?p=but">But</a></li>
                    <li><a href="?p=paramettre">Paramettre</a></li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        const compchanger = document.getElementById('compchanger');
        if (window.location.href.toString().includes('details')) compchanger.disabled = true
        compchanger.addEventListener('change', async function(e) {

            await fetch(`?competition=${e.target.value}`)
            window.location.reload()
        })
    </script>
    <div class="container">
        <?php if ($_comp ?? null) : ?>
            <div class="heading">
                <div class="heading-left">
                    <img src="image/photo.jpg">
                </div>
                <div class="heading-text">
                    <h1><?= $_comp ?? null ?></h1>
                </div>
                <div class="heading-left">
                    <img src="image/photo.jpg">
                </div>
            </div>
        <?php endif ?>
        <?= $content ?? null ?>

    </div>

</body>

</html>