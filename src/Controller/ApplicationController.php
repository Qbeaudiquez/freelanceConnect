<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Mission;
use App\Entity\StatusApplication;
use App\Entity\User;
use App\Form\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ApplicationController extends AbstractController
{
    #[Route('/mission/{id}/apply', name: 'app_application_new')]
    #[IsGranted('ROLE_FREELANCE')]
    public function new(Request $request, Mission $mission, EntityManagerInterface $emi): Response
    {
        $existingApplication = $emi->getRepository(Application::class)->findOneBy([
            'mission' => $mission,
            'user' => $this->getUser(),
        ]);

        if ($existingApplication) {
            $this->addFlash('error', 'Vous avez déjà postulé à cette mission.');
            return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
        }

        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        $user = $this->getUser();
        $application->setUser($user);
        $application->setMission($mission);
        $application->setCreatedAt(new \DateTimeImmutable());
        $statusEnAttente = $emi->getRepository(StatusApplication::class)
            ->findOneBy(['label' => 'en attente']);
        $application->setStatusApplication($statusEnAttente);

        if ($form->isSubmitted() && $form->isValid()) {
            $emi->persist($application);
            $emi->flush();

            return $this->redirectToRoute('app_application_show', ['id' => $application->getId()]);
        }

        return $this->render('application/new.html.twig', [
            'form' => $form,
            'mission' => $mission,
        ]);
    }

    #[Route('/application/{id}', name: 'app_application_show')]
    #[IsGranted('ROLE_FREELANCE')]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
            'mission' => $application->getMission(),
        ]);
    }
}
