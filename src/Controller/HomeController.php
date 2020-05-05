<?php

namespace App\Controller;

use App\Entity\RadioSearch;
use App\Form\RadioSearchType;
use App\Repository\RadioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 


class HomeController extends BaseController {

    private $repository;

    private $em;

    public function __construct(RadioRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="home.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response 
    {
        $search = new RadioSearch();
        $form = $this->createForm(RadioSearchType::class, $search);
        $form->handleRequest($request);

        $radios = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);
        
        return $this->render('pages/home.html.twig', [
            'radios' => $radios,
            'form'  => $form->createView(),
        ]);

    }

}