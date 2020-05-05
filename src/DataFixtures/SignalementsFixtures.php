<?php

namespace App\DataFixtures;

use App\Entity\Signalements;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SignalementsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $signalementsJson = file_get_contents(dirname(__DIR__).'/monks/signalements.json');

        $data = json_decode($signalementsJson, true);
        //dump($data['signalements']);

        foreach($data['signalements'] as $result)
        {
            //dump($result["nom_chaine"]);
           
            $signalements = new Signalements();
            $signalements->setAvatar($result['avatar']);
            $signalements->setNomChaine($result['nom_chaine']);
            $signalements->setNombreSignal($result['nombre_signalement']);
            $signalements->setListSignal($result['list_signalement']);
            $signalements->setManagement($result['management']);
            
            $manager->persist($signalements);
        }
        $manager->flush();
    }
}
