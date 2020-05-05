<?php

namespace App\DataFixtures;

use App\Entity\Channels;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ChannelsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $channelsJson = file_get_contents(dirname(__DIR__).'/monks/channel-admin.json');

        $data = json_decode($channelsJson, true);
        //dump($data['channels']);

        foreach($data['channels'] as $result)
        {
            //dump($result["nom_chaine"]);
           
            $channels = new Channels();
            $channels->setAvatar($result['avatar']);
            $channels->setNomChaine($result['nom_chaine']);
            $channels->setProprietaire($result['proprietaire']);
            $channels->setStatus($result['status']);
            
            $manager->persist($channels);
        }
        $manager->flush();
    }
}
