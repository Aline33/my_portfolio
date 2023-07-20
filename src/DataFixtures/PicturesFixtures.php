<?php

namespace App\DataFixtures;

use App\Entity\Pictures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PicturesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $picture = new Pictures();
            $picture->setFile('https://placehold.co/800x500');
            $picture->setName('Projet ' . $i);
            $picture->setIsMain(true);
            $picture->setProject($this->getReference('project_' . $i));
            $manager->persist($picture);
            $rand = rand(0, 4);
            for($j = 0; $j < $rand; $j++) {
                $picture2 = new Pictures();
                $picture2->setProject($this->getReference('project_' . $j));
                $picture2->setName('image ' . $j . ' du projet ' . $i);
                $picture2->setFile('https://placehold.co/800x500');
                $manager->persist($picture2);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectsFixtures::class
        ];
    }
}
