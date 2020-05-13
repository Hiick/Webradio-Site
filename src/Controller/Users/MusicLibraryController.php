<?php

namespace App\Controller\Users;

use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/profile", name="profile.library.index")
     * @IsGranted("ROLE_USER")
     */
class MusicLibraryController extends BaseController {

     /**
     * @Route("/library", name="profile.library.index")
     */
    public function index(Request $request): Response {

        return $this->render('Users/MusicLibrary/base.html.twig');
    }

    /**
     * @Route("/new", name="profile.library.new")
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
   {
        $content = $request->getContent();

        if(!empty($content)) {

            $params = json_decode($content, true);

           

            
           
            //$this->em->persist($user);
            //$this->em->flush();

        }

        return $this->responseApi([
            "data" => json_decode($content, true)
        ], 200);
    }

}