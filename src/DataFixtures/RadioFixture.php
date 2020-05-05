<?php

namespace App\DataFixtures;

use App\Entity\Radio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RadioFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $radioJson = file_get_contents(dirname(__DIR__).'/monks/radios.json');

        $data = json_decode($radioJson, true);
        //dump($data['radios'][0]["id"]);

        foreach($data['radios'] as $result)
        {       
            $radio = new Radio();
            $radio->setAvatar($result['avatar']);
            $radio->setNameRadio($result['nom']);
            $radio->setUrlRadio($result['url']);

            $manager->persist($radio);
        }
        $manager->flush();
    }
}
