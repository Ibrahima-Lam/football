<?php

namespace App\Controllers\api;


class ParticipationController extends apiController
{
    public function __call($name, $args)
    {
        $participations = $this->loadModel("participation")->findAllRegroupementByName($name);
        $this->response($participations);
    }

    public function index(): void
    {

        $participations = $this->loadModel("participation")->findAllRegroupementByName();
        $this->response($participations);
    }
    public function groupe($name = null): void
    {

        $participations = $this->loadModel("participation")->findAllRegroupementByName($name);
        $this->response($participations);
    }
}
