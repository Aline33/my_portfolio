<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/skills')]
class SkillsController extends AbstractController
{
    #[Route('/', name: 'app_skills')]
    public function index(SkillsRepository $skillsRepository): Response
    {
        $skills = $skillsRepository->findAll();

        return $this->render('Skills/index.html.twig', [
            'skills' => $skills
        ]);
    }

    #[Route('/show/{id}', name: 'app_skills_show')]
    public function show(Skills $skill): Response
    {
        return $this->render('Skills/show.html.twig', [
            'skill' => $skill,
        ]);
    }

    #[Route('/new', name: 'app_skills_new')]
    public function new(SkillsRepository $skillsRepository, Request $request): Response
    {
        $skill = new Skills();

        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $skillsRepository->save($skill, true);

            return $this->redirectToRoute('app_admin');
        }
    return $this->render('Skills/new.html.twig', [
        'form' => $form,
    ]);
    }

    #[Route('/edit/{id}', name: 'app_skills_edit')]
    public function edit(Skills $skill, SkillsRepository $skillsRepository, Request $request): Response
    {
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $skillsRepository->save($skill, true);

            return $this->redirectToRoute('app_admin');
        }
    return $this->render('Skills/edit.html.twig', [
        'form' => $form,
        'skill' => $skill,
    ]);
    }

    #[Route('/{id}', name: 'app_skills_delete')]
    public function delete(Skills $skill, SkillsRepository $skillsRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->request->get('_token'))) {
            $skillsRepository->remove($skill, true);
        }

        return $this->redirectToRoute('app_admin');
    }

}