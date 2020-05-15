<?php
namespace App\Controller\admin;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Route("/admin/signal")
 * @IsGranted("ROLE_ADMIN")
 */
class SignalAController extends BaseController{

    private $repository;

    private $listSignalRepository;

    public function __construct(SignalementsRepository $repository, ListSignalsRepository $listSignalRepository)
    {
        $this->repository = $repository;
        $this->listSignalRepository = $listSignalRepository;
    }

    /**
     * @Route("/", name="admin.Signalements.index",  methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request) {
        
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $Signalements = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('admin/Signalements/base.html.twig', [
            'Signalements' => $Signalements,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="admin.Signalements.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param ListSignals $listSignals
     * @return Response
     */

    public function show(Signalements $Signals, string $slug, PaginatorInterface $paginator, Request $request)
    {
        if($Signals->getSlug() !== $slug) {
            return $this->redirectToRoute('admin.Signalements.show', [
                 'id' => $Signals->getId(),
                 'slug' => $Signals->getSlug()
 
             ], 301);
         }

         $OneSignal = $paginator->paginate($this->listSignalRepository->findListSignal(),
         $request->query->getInt('page', 1), 5);

         return $this->render("admin/Signalements/show.html.twig", [
            'OneSignals'     => $OneSignal,
        ]
        );

    }

    /**
     * @Route("/blankpage", name="admin.Signalements.blankpage", methods="GET")
     */
    public function blankPage(): Response {

        return $this->render('admin/Signalements/blankPage.html.twig');
    }

   /**
     * @Route("/signal/{id}", name="admin.bannir", methods={"GET"})
     */
    public function bannir(): Response
    {
        return $this->redirectToRoute('admin.Signalements.index');
    }
}