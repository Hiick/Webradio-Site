<?php

namespace App\Controller;

use App\Entity\Radio;
use App\Form\RadioType;
use App\Repository\RadioRepository;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 

/**
 * @Route("/radio")
 */
class RadioController extends BaseController
{
    /**
     * @Route("/", name="radio.index", methods={"GET"})
     */
    public function index(RadioRepository $radioRepository): Response
    {
        return $this->render('radio/index.html.twig', [
            'radios' => $radioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="radio.show", methods={"GET"})
     */
    public function show(Radio $radio): Response
    {
        return $this->render('radio/show.html.twig', [
            'radio' => $radio,
        ]);
    }
}
