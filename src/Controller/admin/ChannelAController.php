<?php 

namespace App\Controller\admin;

use App\Controller\BaseController;
use App\Entity\Channels;
use App\Entity\UserSearch;
use App\Form\ChannelsType;
use App\Form\UserSearchType;
use App\Repository\ChannelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/channel")
 */
class ChannelAController extends BaseController{

    private $repository;

    private $em;

    public function __construct(ChannelsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.channel.index",  methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request) {
        
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $channels = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('admin/channel/base.html.twig', [
            'channels' => $channels,
            'form' => $form->createView(),
        ]);
    }

   
    /**
     * @Route("/{id}/edit", name="admin.channel.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Channels $channels): Response
    {
        $form = $this->createForm(ChannelsType::class, $channels);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.channel.index');
        }

        return $this->render('admin/channel/editChannel/editChannel.html.twig', [
            'channel' => $channels,
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/{id}", name="admin.channel.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Channels $channels): Response
    {
        if ($this->isCsrfTokenValid('delete'.$channels->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($channels);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.channel.index');
    }
}