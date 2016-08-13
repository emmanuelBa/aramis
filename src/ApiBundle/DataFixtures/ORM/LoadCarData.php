<?php

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ApiBundle\Entity\Car;
use ApiBundle\Entity\Option;
use ApiBundle\Entity\Equipment;

class LoadCarData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $option1 = new Option();
        $option1->setName('Spoiler');
        $option2 = new Option();
        $option2->setName('GPS');
        
        $equipment1 = new Equipment();
        $equipment1->setName('DSG');
        $equipment2 = new Equipment();
        $equipment2->setName('Xenon');
        
        $car = new Car();
        $car->setMaker('Seat');
        $car->setModel('Ibiza');
        $car->setPrice(20000);
        $car->addOption($option1);
        $car->addOption($option2);
        $car->addEquipment($equipment1);
        $car->addEquipment($equipment2);
        
        $manager->persist($car);
        $manager->flush();
        
        $option3 = new Option();
        $option3->setName('R-LINK');
        $option4 = new Option();
        $option4->setName('GPS');
        
        $equipment3 = new Equipment();
        $equipment3->setName('ABS');
        $equipment4 = new Equipment();
        $equipment4->setName('Climatisation');
        
        $car2 = new Car();
        $car2->setMaker('Renault');
        $car2->setModel('Clio');
        $car2->setPrice(12000);
        $car2->addOption($option3);
        $car2->addOption($option4);
        $car2->addEquipment($equipment3);
        $car2->addEquipment($equipment4);
        
        $manager->persist($car2);
        $manager->flush();
        
    }
}