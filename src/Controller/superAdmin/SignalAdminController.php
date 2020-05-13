<?php
namespace App\Controller\superAdmin;

use App\Controller\BaseController;
use App\Entity\ListSignals;
use App\Entity\Signalements;
use App\Entity\UserSearch;
use App\Form\UserSearchType;
use App\Repository\ListSignalsRepository;
use App\Repository\SignalementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/superadmin/signal")
 */
class SignalAdminController extends BaseController{

    private $repository;

    private $listSignalRepository;

    public function __construct(SignalementsRepository $repository, ListSignalsRepository $listSignalRepository)
    {
        $this->repository = $repository;
        $this->listSignalRepository = $listSignalRepository;
    }

    /**
     * @Route("/", name="superadmin.Signalements.index",  methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request) {
        
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $Signalements = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('superadmin/Signalements/base.html.twig', [
            'Signalements' => $Signalements,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="superadmin.Signalements.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param ListSignals $listSignals
     * @return Response
     */

    public function show(Signalements $Signals, string $slug, PaginatorInterface $paginator, Request $request)
    {
        if($Signals->getSlug() !== $slug) {
            return $this->redirectToRoute('superadmin.Signalements.show', [
                 'id' => $Signals->getId(),
                 'slug' => $Signals->getSlug()
 
             ], 301);
         }

         $OneSignal = $paginator->paginate($this->listSignalRepository->findListSignal(),
         $request->query->getInt('page', 1), 5);

         return $this->render("superadmin/Signalements/show.html.twig", [
            'OneSignals'     => $OneSignal,
        ]
        );

    }

    /**
     * @Route("/blankpage", name="superadmin.Signalements.blankpage", methods="GET")
     */
    public function blankPage(): Response {

        return $this->render('superadmin/Signalements/blankPage.html.twig');
    }

    

    /**
     * @Route("/signal/{id}", name="superadmin.bannir.delete", methods={"DELETE"})
     */
    public function bannir(Request $request,  Signalements $signal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($signal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('superadmin.Signalements.index');
    }
}