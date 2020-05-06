<?php 
namespace App\Controller\admin;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashController extends BaseController{

    /**
     * @Route("/admin", name="admin.index")
     */
    public function index() {
        
        return $this->render('admin/base.html.twig');
    }

    
    /**
     * @Route("/admin/stats", name="admin.stats.show")
     */
    public function getStatistics() : Response {

        $statistique = file_get_contents(dirname(__DIR__). '/../monks/adminStatistics.json');
        $listStatistique = json_decode($statistique);
        dump($listStatistique);
        return $this->responseApi([$listStatistique]);
    }

    /**
     * @Route("/admin/setting", name="admin.setting.index", methods={"GET"})
     */
    public function settings(): Response {

        return $this->render('admin/settings/base.html.twig');
    }
}