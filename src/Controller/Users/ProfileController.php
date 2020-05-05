<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Entity\User;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends BaseController {

    private $repository;

    private $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/{username}", name="profile.index", methods={"GET","POST"})
     */
    public function index(Request $request, User $user): Response {

        $content = $request->getContent();

        if(!empty($content)) {

            $params = json_decode($content, true);
            $usernane = $params['usernane'];
            $user = $this->repository->findTheUser($usernane);
        }
        
         
        return $this->render('Users/base.html.twig', compact('user'));

    }



   
}