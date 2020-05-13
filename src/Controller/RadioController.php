<?php

namespace App\Controller;

use App\Entity\Radio;
use App\Repository\RadioRepository;
use App\Controller\BaseController;
use App\Entity\RadioSearch;
use App\Form\RadioSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 

/**
 * @Route("/profile")
 */
class RadioController extends BaseController
{
    private $repository;

    private $em;

    public function __construct(RadioRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/radio", name="radio.index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new RadioSearch();
        $form = $this->createForm(RadioSearchType::class, $search);
        $form->handleRequest($request);

        $radios = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);
        
        return $this->render('Users/Radios/base.html.twig', [
            'radios' => $radios,
            'radioform'  => $form->createView(),
        ]);
    }

}
