<?php 
namespace App\Controller\admin;

use App\Controller\BaseController;
use App\Form\SettingProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


    /**
     * @Route("/admin")
     * @IsGranted("ROLE_ADMIN")
     */
class AdminDashController extends BaseController{

    private $repository;

    private $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="admin.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index() {
        
        $user = $this->getUser();

        return $this->render('admin/base.html.twig', [
            'user' => $user,
        ]);
    }

    
    /**
     * @Route("/stats", name="admin.stats.show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function getStatistics() : Response {

        $statistique = file_get_contents(dirname(__DIR__). '/../monks/adminStatistics.json');
        $listStatistique = json_decode($statistique);
        dump($listStatistique);
        return $this->responseApi([$listStatistique]);
    }

    /**
     * @Route("/setting/{id}", name="admin.setting.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function settings(Request $request): Response {
        $user = $this->getUser();

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);

            $user->setAvatar($params['downloadUrl']);
            $user->setUsername($params['username']);
            $user->setEmail($params['email']);

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(
                'success',
                "Votre compte à ete mis à jour!!!!"
            );
        }

        return $this->render('admin/settings/base.html.twig', [
            'user' => $user,
        ]);
    }
}