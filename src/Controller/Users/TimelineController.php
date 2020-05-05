<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TimelineController extends BaseController {

    /**
     * @Route("/profile/timeline", name="profile.timeline.index")
     */
    public function index (): Response {

        return $this->render('Users/Timeline/base.html.twig');
    }
}