<?php 

namespace App\Controller\superAdmin;

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
 * @Route("/superadmin/channel")
 */
class ChannelAdminController extends BaseController{

    private $repository;

    private $em;

    public function __construct(ChannelsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="superadmin.channel.index",  methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request) {
        
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $channels = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('superAdmin/channel/base.html.twig', [
            'channels' => $channels,
            'form' => $form->createView(),
        ]);
    }

   
    /**
     * @Route("/{id}/edit", name="superadmin.channel.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Channels $channels): Response
    {
        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);

            $channels->setAvatar($params['downloadUrl']);
            $channels->setNomChaine($params['channels']);
            
            $this->em->persist($channels);
            $this->em->flush();

            return $this->redirectToRoute('superadmin.channel.index');
        }

        return $this->render('superAdmin/channel/editChannel/editChannel.html.twig', [
            'channel' => $channels,
        ]);
    }

        /**
     * @Route("/{id}", name="superadmin.channel.bannir", methods={"GET","POST"})
     */
    public function bannir(Channels $channels): Response
    {
            $channels->getId();
            $channels->setStatus("Banni");
            $this->em->persist($channels);
            $this->em->flush();

        return $this->redirectToRoute('superadmin.channel.index');
    }
}