<?php

namespace App\Controllers\home;

class CompetitionController extends Controller
{

    public function index(): void
    {

        $data = $this->loadModel("competition")->findAll();
        $editions = $this->loadModel("competition")->findEditionAll();
        $this->render("competition/liste", compact("data", "editions"));
    }
}
