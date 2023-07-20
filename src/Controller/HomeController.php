<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ProjectsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $projectsRepository, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('my_portfolio@gmail.com')
                ->subject('Demande de contact sur votre site de ' . $contactFormData['email'])
                ->html($contactFormData['email'] . ' vous a envoyé le message suivant: ' . $contactFormData['message']);
            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'projects' => $projectsRepository->findBy([], ['id' => 'DESC']),
            'form' => $form
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('home/admin.html.twig');
    }
}
