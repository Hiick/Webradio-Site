<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 
use Symfony\Component\HttpFoundation\JsonResponse;


    /**
     * @Route("/")
     */
class HomeController extends BaseController {



    /**
     * @Route("/", name="home.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response 
    {
       /* $search = new RadioSearch();
        $form = $this->createForm(RadioSearchType::class, $search);
        $form->handleRequest($request);

        $radios = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);*/
        
        return $this->render('pages/home.html.twig');

    }

    /**
     * @Route("/firebase", name="home.firebase")
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

}