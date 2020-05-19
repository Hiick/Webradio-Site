<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
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
     * @Route("/setting", name="profile.setting.index")
     * @IsGranted("ROLE_USER")
     */
    public function setting(): Response {
        $user = $this->getUser();

        return $this->render('Users/Settings/base.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * @Route("/setting/{id}", name="profile.setting.edit")
     * 
     */
    public function settingEdit(User $user, Request $request): Response {

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);

            $user->setAvatar($params['downloadUrl']);
            $user->setUsername($params['username']);
            
            $this->em->persist($user);
            $this->em->flush();
        
        }
        

        
        return $this->redirectToRoute('profile.setting.index');
    }

    /**
     * @Route("/firebase", name="app.firebase")
     */
    
    public function configFirebase () {

        $apiKey = $_ENV['APIKEY'];
        $authDomain = $_ENV['AUTHDOMAIN'];
        $databaseURL = $_ENV['DATABASEURL'];
        $projectId = $_ENV['PROJECTID'];
        $storageBucket = $_ENV['STORAGEBUCKET'];

        return new JsonResponse([
            'apiKey' =>  $apiKey,
            'authDomain' => $authDomain,
            'databaseURL' =>  $databaseURL,
            'projectId' => $projectId,
            'storageBucket' => $storageBucket,
        ]);
            
    }

    /**
     * @Route("/setting/password/{id}", name="profile.passwordChange")
     * @IsGranted("ROLE_USER")
     */
    public function passwordChange(Request $request): Response {
        $user = $this->getUser();

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);
            $hash = $this->encoder->encodePassword($user, $params['password']);
            $user->setAvatar($hash);

            $this->em->persist($user);
            $this->em->flush();
        }

        
        return $this->redirectToRoute('profile.setting.index'); 
    }

    /**
     * @Route("/setting/channel/{id}", name="profile.channel.edit")
     * @IsGranted("ROLE_USER")
     */
    public function channelEdit(Request $request): Response {
        $user = $this->getUser();

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);

            $user->setAvatar($params['downloadUrl']);
            $user->setChannels($params['channels']);

            $this->em->persist($user);
            $this->em->flush();
        }

        
        return $this->redirectToRoute('profile.setting.index');
    }
   
}