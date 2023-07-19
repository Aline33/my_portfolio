<?php

namespace App\DataFixtures;

use App\Entity\Projects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $myProjects = [
            ['name' => 'Body & Soul', 'description' => 'Site vitrine de salle de sport.', 'color' => '#FFD4DAFF', 'skills' => [1, 2]],
            ['name' => 'Céoukonva ?', 'description' => 'Hackathon organisé par la Wild Code School sur le thème des vacances. Application humouristique pour aider les "beauf" à choisir leur destination de vacances.', 'color' => '#FFEDBFFF', 'skills' => [0, 1, 2, 3, 4]],
            ['name' => 'Circuit', 'description' => 'Blog sur les nouvelles technologies permettant a l\'administrateur de poster des nouveaux articles.', 'color' => '#E3CAC8FF', 'skills' => [0, 1, 2, 3, 4]],
            ['name' => 'Estimmaüs', 'description' => 'Projet gagnant du hackathon organisé par la Wild Code School en partenariat avec Emmaüs Connect. Application qui permet d\'estimer le prix d\'un smartphone.', 'color' => '#EDDAFFFF', 'skills' => [0, 1, 2, 3, 5]],
            ['name' => 'Job IT Better', 'description' => 'Application qui met en relation des personnes en recherchent d\'un emploi et des entreprises qui recrutent en partenariat avec Externatic.', 'color' => '#B8F5CDFF', 'skills' => [0, 1, 2, 3, 5]],
            ];

        foreach ($myProjects as $key => $myProject) {
            $project = new Projects();
            $project->setName($myProject['name']);
            $project->setDescription($myProject['description']);
            $project->setColor($myProject['color']);
            foreach ($myProject['skills'] as $skill) {
                $project->addSkill($this->getReference('skill_' . $skill));
            }
            $this->addReference('project_' . $key, $project);
            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SkillsFixtures::class
        ];
    }
}