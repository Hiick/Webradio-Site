<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Entity\MusicLibrary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

    /**
     * @Route("/profile/library")
     * @IsGranted("ROLE_USER")
     */
class MusicLibraryController extends BaseController {

   

    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        
        $this->em = $em;
    }

     /**
     * @Route("/", name="profile.library.index")
     */
    public function index(Request $request): Response {

        return $this->render('Users/MusicLibrary/base.html.twig');
    }

    /**
     * @Route("/new", name="profile.library.new", )
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
   {
        $music = new MusicLibrary();
        $user = $this->getUser();

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);
            $music->setName($params['filename']);

            //$this->em->persist($user);
            //$this->em->flush();
        }

        
        return $this->redirectToRoute('profile.library.index'); 
    }

    

}