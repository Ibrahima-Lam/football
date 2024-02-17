<div class="content">

    <a class="titre" href="?p=joueur/form">Joueur</a>
    <a class="titre" href="?p=joueur/form/sanction">Sanction</a>
    <a class="titre" href="?p=joueur/form/but">But</a>

    <?php
    $type = $type ?? null;
    ?>



    <h2 class="titre">Formulaire des joueurs</h2>
    <form class="form" action="?p=joueur/traitement" method="post">
        <div class="form-group">
            <div class="form-control">
                <label for="">Nom</label>
                <input type="text" name="nom" placeholder="Entrer le nom du joueur" autocapitalize="on">
            </div>
            <div class="form-control">
                <label for="">Equipe</label>
                <select name="equipe" id="">
                    <?php foreach ($equipes as $equipe) : ?>
                        <option value="<?= $equipe->idParticipant ?>"><?= $equipe->nomEquipe ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Localité</label>
                <input type="text" name="localite" placeholder="Entrer la localité ">
            </div>
            <div class="form-action">
                <button type="reset" class="btn btn-default" id="">Annuler</button>
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </div>
    </form>


</div>