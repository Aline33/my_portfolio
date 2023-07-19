<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hardSkills = ['Twig', 'HTML', 'CSS', 'Javascript', 'PHP', 'PHP/Symfony'];

        foreach ($hardSkills as $key => $hardSkill) {
            $skill = new Skills();
            $skill->setName($hardSkill);
            $this->addReference('skill_' . $key, $skill);

            $manager->persist($skill);
        }

        $manager->flush();
    }
}