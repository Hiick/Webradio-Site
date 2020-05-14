<?php 

namespace App\Controller\superAdmin;

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
 * @Route("/superadmin/users")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class UsersAdminController extends BaseController{

    private $repository;

    private $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="superadmin.users.index", methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $user = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 5);

        return $this->render('superadmin/user/index.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);

        /*return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);*/
    }

    /**
     * @Route("/new", name="superadmin.users.new", methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $content = $request->getContent();

        if(!empty($content)) {

            $params = json_decode($content, true);

            $user->setAvatar("<i class='fas fa-user-circle fa-2x text-dark-300'></i>");
            $user->setUsername($params['username']);
            $user->setEmail($params['email']);
            $user->setRole($params['role']);
            $user->setStatus("Active");
           
            $this->em->persist($user);
            $this->em->flush();

        }

        return $this->render('superadmin/user/new/new.html.twig');
    }

    

    /**
     * @Route("/{id}/edit", name="superadmin.users.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('superadmin.users.index');
        }

        return $this->render('superAdmin/user/edit/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="superadmin.user.bannir", methods={"GET","POST"})
     */
    public function bannir(Request $request, User $user): Response
    {   
        
         $user->getId();
         $user->setStatus("Banni");
         $this->em->persist($user);
         $this->em->flush();
        

        return $this->redirectToRoute('superadmin.users.index');
    }
    
    
    
    
    /**
     * @Route("/notifications", name="superadmin.notifications.index", methods={"GET"})
     */
    public function notification(): Response {

        return $this->render('superAdmin/notifications/base.html.twig');
    }

    

}