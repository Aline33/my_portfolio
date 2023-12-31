<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\PicturesRepository;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/projects')]
class ProjectsController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_projects_index', methods: ['GET'])]
    public function index(ProjectsRepository $projectsRepository): Response
    {
        return $this->render('projects/index.html.twig', [
            'projects' => $projectsRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_projects_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Projects();
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projects/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_projects_show', methods: ['GET'])]
    public function show(Projects $project, PicturesRepository $pictureRepository): Response
    {
        $mainPicture = $pictureRepository->findOneBy(['project' => $project, 'isMain' => true]);
        $pictures = $pictureRepository->findBy(['project' => $project, 'isMain' => false]);

        return $this->render('projects/show.html.twig', [
            'project' => $project,
            'mainPicture' => $mainPicture,
            'pictures' => $pictures,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_projects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projects $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_projects_delete', methods: ['POST'])]
    public function delete(Request $request, Projects $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
