<?php

namespace App\Controller;

use App\Entity\Users;
use App\Security\UsersAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Unirest;


class RegisterController extends BaseController
{

    
     /**
     * @Route("/register", name="user.registration")
     */

    public function register(Request $request, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {

        if($request->isMethod('POST')){

            $content = $request->getContent();

            $params = json_decode($content, true);


            $email = $params['email'];
            $username = $params['username'];
            $password = $params['password'];

            $headers = array('Accept' => 'application/json');
            $query = array('email' => $email, 'username' => $username, 'password' => $password);
 
            $url = 'https://webradio-stream.herokuapp.com/auth/register';
            $body = Unirest\Request\Body::json($query);
 
            $response = Unirest\Request::post($url,$headers,$body);
 
            return new Response(json_encode($response));

            dd($response);

        }
      
            // do anything else you need here, like send an email

            /*return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'admin' // firewall name in security.yaml
            );*/
        

        return $this->render('register/modal.html.twig');
    }

    

         
}
