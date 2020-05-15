<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegisterController extends BaseController
{

    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }
     /**
     * @Route("", name="user_registration")
     */

        public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {
        $content = $request->getContent();

        $user = new User();

        if(!empty($content)) {

            $params = json_decode($content, true);

            $user->setAvatar("https://firebasestorage.googleapis.com/v0/b/webradio-stream.appspot.com/o/User%2F70element-1.png?alt=media&token=fa8fa419-9e5f-4738-b2de-85536002a0d1");
            $user->setUsername($params['username']);
            $user->setEmail($params['email']);
            $user->setChannels($params['username']."Sound");
            $user->setRole("User");
            $hash = $this->encoder->encodePassword($user, $params['password']);
            $user->setPassword($hash);
            $user->setStatus("Active");
           

        }
        
        $this->em->persist($user);
        $this->em->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'admin' // firewall name in security.yaml
            );
        

        return $this->render('pages/home.html.twig');
    }

         
}
