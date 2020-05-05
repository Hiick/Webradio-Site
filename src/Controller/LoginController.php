<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends BaseController {

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, User $user) {

        $content = $request->getContent();

        if(!empty($content)) {

            $params = json_decode($content, true);
            $email = $params['email'];
            $password = $params['password'];
            $user = $this->repository->findUserByMail($email, $password);
             $admin = "ADMIN";
             $superadmin = "SUPERADMIN";
             $user = "USER";
            if($user->getRoles() === $superadmin){

                return $this->redirectToRoute('superadmin.index');
            }
            elseif($user->getRoles() === $admin) {
                return $this->redirectToRoute('admin.index');
            }
            else {
                return $this->redirectToRoute('profil.index', ['username'=> $user->getUsername()]);
            }
            
        }
        

        
    }

}