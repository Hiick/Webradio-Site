<?php 
namespace App\Controller\superAdmin;

use App\Controller\BaseController;
use App\Form\SettingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *  @Route("/superadmin")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class SuperAdminDashController extends BaseController {

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        
        $this->em = $em;
    }


    /**
     * @Route("/", name="superadmin.index")
     */
    public function index() {
        
        $user = $this->getUser();

        return $this->render('superAdmin/base.html.twig', [
            'user' => $user,
        ]);
    }

    
    /**
     * @Route("/stats", name="superadmin.stats.show")
     */
    public function getStatistics() : Response {

        $statistique = file_get_contents(dirname(__DIR__). '/../monks/adminStatistics.json');
        $listStatistique = json_decode($statistique);

        return $this->responseApi([$listStatistique]);
    }


    /**
     * @Route("/superadmin-firebase")
     */
    
    public function configFirebase () {

        $apiKey = $_ENV['APIKEY'];
        $authDomain = $_ENV['AUTHDOMAIN'];
        $databaseURL = $_ENV['DATABASEURL'];
        $projectId = $_ENV['PROJECTID'];
        $storageBucket = $_ENV['STORAGEBUCKET'];

        return new JsonResponse([
            'apiKey' =>  $apiKey,
            'authDomain' => $authDomain,
            'databaseURL' =>  $databaseURL,
            'projectId' => $projectId,
            'storageBucket' => $storageBucket,
        ]);
            
    }

    /**
     * @Route("/setting/{id}", name="superadmin.setting.index")
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
           
        }

        return $this->render('superAdmin/settings/base.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/setting/password/{id}", name="superadmin.passwordChange")
     * 
     */
    public function passwordChange(Request $request): Response {
        $user = $this->getUser();

        if($request->isXmlHttpRequest()){

            $content = $request->getContent();

            $params = json_decode($content, true);
            $hash = $this->encoder->encodePassword($user, $params['password']);
            $user->setAvatar($hash);

            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('superAdmin/settings/base.html.twig', [
            'user' => $user,
        ]);
    }
}