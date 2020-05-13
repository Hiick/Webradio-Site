<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
   /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $usersJson = file_get_contents(dirname(__DIR__).'/monks/users-login.json');

        $data = json_decode($usersJson, true);
        //dump($data['radios'][0]["id"]);

        foreach($data['users'] as $result)
        {
            //dump($result["nom_chaine"]);
           
            $user = new User();
            $user->setAvatar($result['avatar']);
            $user->setEmail($result['email']);
            $user->setUsername($result['username']);
            $user->setChannels($result['nom_chaine']);
            $user->setRole($result['role']);
            $user->setStatus($result['status']);
            $hash = $this->encoder->encodePassword($user, $result['password']);
            $user->setPassword($hash);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
