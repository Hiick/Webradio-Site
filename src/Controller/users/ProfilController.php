<?php

namespace App\Controller\users;

use App\Controller\BaseController;

use Symfony\Component\HttpFoundation\JsonResponse;

class ProfilController extends BaseController
{
    public function index()
    {
        $this->render("users/base.html.twig");
    }
}