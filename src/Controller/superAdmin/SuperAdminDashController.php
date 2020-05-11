<?php 
namespace App\Controller\superAdmin;

use App\Controller\BaseController;
use App\Form\SettingType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *  @Route("/superadmin")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class SuperAdminDashController extends BaseController{

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
     * @Route("/setting/{id}", name="superadmin.setting.index")
     */
    
    public function settings(Request $request): Response {
        $user = $this->getUser();

        $form = $this->createForm(SettingType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(
                'success',
                "Votre compte à ete mis à jour!!!!"
            );
        }

        return $this->render('superAdmin/settings/base.html.twig', [
            'user' => $user,
            'settingsForm' => $form->createView()
        ]);
    }
}