<?php

namespace App\DataFixtures;

use App\Entity\ListSignals;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ListSignalsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $nomChaine = ["MikySound", "AlexSound", "JeanSound", "PapaSound", "EmeSound"];

        $listSignalsJson = file_get_contents(dirname(__DIR__).'/monks/listSignales.json');

        $data = json_decode($listSignalsJson, true); 

        foreach($nomChaine as $name) {
        
            $result =$data[$name];

            foreach($result as $nomChaine) {
            // dump(['id']);
                $listSignals = new ListSignals();
                $listSignals->setFluxAudio($nomChaine['fluxAudio']);
                $listSignals->setDateDebutStream($nomChaine['dateDebutStream']);
                $listSignals->setDateHeureSignalement($nomChaine['dateHeureSignalement']);
                $listSignals->setMotif($nomChaine['motif']);
                $manager->persist($listSignals);
            }
         }   
        $manager->flush();
    }
}
