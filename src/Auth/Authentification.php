<?php

namespace src\Auth;

use  src\Service\Session;

class Authentification
{
    protected ?Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }
}
