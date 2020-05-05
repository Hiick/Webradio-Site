<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SettingsController extends BaseController {

    /**
     * @Route("/profile/setting/{id}", name="profile.setting.index")
     */
    public function index(User $user): Response {

        return $this->render('Users/Settings/base.html.twig', [
            'user' => $user
        ]);
    }


}