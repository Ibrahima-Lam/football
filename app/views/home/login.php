<?php
$title = 'login'
?>
<div class="content">
    <div class="flex">
        <form action="?p=app/traitement" method="post" class="form">
            <h2 class="titre flex">Login</h2>
            <div class="form-control">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="Entrer le nom">
            </div>
            <div class="form-control">
                <label for="password">Mot de Pass</label>
                <input type="password" name="password" id="password" placeholder="Entrer le mot de pass">
            </div>
            <div class="form-control flex">
                <button type="submit" name="envoi" class="btn btn-primary">Connexion</button>
            </div>
        </form>
    </div>
</div>