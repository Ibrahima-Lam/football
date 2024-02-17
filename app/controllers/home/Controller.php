<?php

namespace App\Controllers\home;

use src\App\App;
use src\Service\TraitModel;

class Controller
{

    use TraitModel;
    public function render(string $file, $data = []): void
    {

        $_competitions = $this->loadModel("competition")->findLastEditionAll();
        $_comp = App::getCompetition()->getCompetition()->nomEdition ?? null;
        $code = App::getCompetition()->getCompetition()->codeCompetition;
        if (!$code) {
            $code = $_competitions[0]->codeEdition ?? null;
            if ($code)  $this->redirect("?competition=$code");
        }
        $_admin = App::getUser()->getUser()->id ?? null;
        extract($data);
        ob_start();
        require "../App/views/$file.php";
        $content = ob_get_clean();
        require_once "layout.php";
    }

    public function response(mixed $data): void
    {
        if (is_scalar($data)) echo $data;
        else echo json_encode($data, true);
        exit();
    }
    public function redirect($url): void
    {
        header('location:' . $url);
        exit();
    }
}
