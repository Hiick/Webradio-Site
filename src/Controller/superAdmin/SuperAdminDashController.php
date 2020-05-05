<?php 
namespace App\Controller\superAdmin;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuperAdminDashController extends BaseController{

    /**
     * @Route("/superadmin", name="superadmin.index")
     */
    public function index() {
        
        return $this->render('superAdmin/base.html.twig');
    }

    
    /**
     * @Route("/superadmin/stats", name="superadmin.stats.show")
     */
    public function getStatistics() : Response {

        $statistique = file_get_contents(dirname(__DIR__). '/../monks/adminStatistics.json');
        $listStatistique = json_decode($statistique);
        dump($listStatistique);
        return $this->responseApi([$listStatistique]);
    }

    /**
     * @Route("/superadmin/setting", name="superadmin.setting.index", methods={"GET"})
     */
    public function settings(): Response {

        return $this->render('superAdmin/settings/base.html.twig');
    }
}