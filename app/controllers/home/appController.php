<?php

namespace App\Controllers\home;


use src\App\App;

class AppController extends Controller
{

    public function index(): void
    {
        $comp = $_GET["competition"] ?? null;
        if ($comp) App::getCompetition()->changeCompetition($comp);
        $competition = App::getCompetition()->getCompetition();
        $this->render("home/accueil", compact("competition"));
    }
    public function login(): void
    {

        $this->render("home/login");
    }
    public function traitement()
    {

        extract($_POST);
        if (!isset($envoi)) return;
        $user =  App::getUser()->changeUser($nom, sha1($password));
        if ($user) $this->redirect('?p=groupe');
    }

    public function logout()
    {
        App::getUser()->removeUser();
        $this->render("home/login");
    }

    public function formulaire()
    {
        $form = <<<form
            <div class="flex">
            <form action="?p=app/traitement" method="post" class="form" id='form'>
                <h2 class="titre flex">Login</h2>
                <div class="form-control">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom">
                </div>
                <div class="form-control">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="form-control">
                    <button type="submit" name="envoi" class="btn btn-success">Envoyer</button>
                </div>
            </form>
        </div>
       form;
        $this->response($form);
    }
}
