<?php 

namespace App\Controller\admin;

use App\Controller\BaseController;
use App\Entity\User;
use App\Entity\UserSearch;
use App\Form\UserSearchType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/users")
 * @IsGranted("ROLE_ADMIN")
 */
class UsersAController extends BaseController{

    private $repository;

    private $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="admin.users.index", methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $user = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('admin/user/index.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/new", name="admin.users.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
       $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('admin/user/new/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/{id}/edit", name="admin.users.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('admin/user/edit/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.user.delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.users.index');
    }
    
    

}