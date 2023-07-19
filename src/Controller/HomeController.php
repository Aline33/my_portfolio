<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $projectsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'projects' => $projectsRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
