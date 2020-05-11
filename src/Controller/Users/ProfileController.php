<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Form\SettingProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * permet à l'utilisateur de voir son compte
     * @Route("/", name="profile.index", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response {

        $user = $this->getUser();
        
        return $this->render('Users/base.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/setting", name="profile.setting.index")
     * @IsGranted("ROLE_USER")
     */
    public function setting(Request $request): Response {
        $user = $this->getUser();

        $form = $this->createForm(SettingProfilType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(
                'success',
                "Votre compte à ete mis à jour!!!!"
            );
        }

        return $this->render('Users/Settings/base.html.twig', [
            'settingForm' => $form->createView()
        ]);
    }



   
}