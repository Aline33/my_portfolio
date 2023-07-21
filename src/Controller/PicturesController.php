<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Form\PicturesType;
use App\Repository\PicturesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pictures')]
class PicturesController extends AbstractController
{
    #[Route('/', name: 'app_pictures_index', methods: ['GET'])]
    public function index(PicturesRepository $picturesRepository): Response
    {
        return $this->render('pictures/index.html.twig', [
            'pictures' => $picturesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pictures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $picture = new Pictures();
        $form = $this->createForm(PicturesType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('app_pictures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pictures/new.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pictures_show', methods: ['GET'])]
    public function show(Pictures $picture): Response
    {
        return $this->render('pictures/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pictures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pictures $picture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PicturesType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pictures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pictures/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pictures_delete', methods: ['POST'])]
    public function delete(Request $request, Pictures $picture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pictures_index', [], Response::HTTP_SEE_OTHER);
    }
}
