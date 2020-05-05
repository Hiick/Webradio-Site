<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicLibraryController extends BaseController {

     /**
     * @Route("/profile/library", name="profile.library.index")
     */
    public function index(): Response {
        return $this->render('Users/MusicLibrary/base.html.twig');
    }
}