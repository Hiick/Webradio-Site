<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Entity\MusicLibrary;
use App\Repository\MusicLibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function index(MusicLibraryRepository $musicLibraryRepository): Response {

        return $this->render('Users/MusicLibrary/base.html.twig', [
            'musiclists' => $musicLibraryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="profile.library.new", methods={"GET","POST"} )
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
            $user->addMusic($music);
                
            $this->em->persist($music);
            $this->em->flush();
        }

        
        return new JsonResponse([
            "Ok", 200
        ]);

    }

    /**
     * @Route("/delete/image/{id}", name="delete.music")
     */
    public function deleteMusic(MusicLibrary $music, Request $request) 
    {
        
        if($request->isXmlHttpRequest()){
            $content = $request->getContent();

            $params = json_decode($content, true);
            $music->getId();
            $nom = $music->getName();
            
            $this->em->remove($nom);
            $this->em->flush();
            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error' => 'nom supprime']);
    }

}