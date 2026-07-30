<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Mission;
use App\Entity\StatusApplication;
use App\Entity\StatusMission;
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
    public function show(Application $application): Response
    {
        $isApplicant = $application->getUser() === $this->getUser();
        $isMissionOwner = $application->getMission()->getUser() === $this->getUser();

        if (!$isApplicant && !$isMissionOwner) {
            throw $this->createAccessDeniedException('Cette candidature ne vous concerne pas.');
        }

        return $this->render('application/show.html.twig', [
            'application' => $application,
            'mission' => $application->getMission(),
        ]);
    }

    #[Route('/profile/applications', name: 'app_application_index')]
    #[IsGranted('ROLE_FREELANCE')]
    public function list(EntityManagerInterface $emi): Response
    {
        $applications = $emi->getRepository(Application::class)->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('application/list.html.twig', [
            'applications' => $applications,
        ]);
    }

    #[Route('/mission/{id}/applications', name: 'app_mission_applications')]
    #[IsGranted('ROLE_CLIENT')]
    public function listByMission(Mission $mission, EntityManagerInterface $emi): Response
    {
        if ($mission->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Cette mission ne vous appartient pas.');
        }

        $applications = $emi->getRepository(Application::class)->findBy([
            'mission' => $mission,
        ]);

        return $this->render('application/by_mission.html.twig', [
            'mission' => $mission,
            'applications' => $applications,
        ]);
    }

    #[Route('/application/validate/{id}', name: 'app_application_validate')]
    #[IsGranted('ROLE_CLIENT')]
    public function validate(Application $application, EntityManagerInterface $emi): Response
    {
        if ($application->getMission()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Cette candidature ne vous appartient pas.');
        }

        $statusValideApplication = $emi->getRepository(StatusApplication::class)
            ->findOneBy(['label' => 'acceptée']);
        $application->setStatusApplication($statusValideApplication);

        $statusEnCoursMission = $emi->getRepository(StatusMission::class)
            ->findOneBy(['label' => 'en cours']);
        $application->getMission()->setStatusMission($statusEnCoursMission);

        $emi->flush();

        return $this->redirectToRoute('app_mission_applications', ['id' => $application->getMission()->getId()]);
    }

    #[Route('/application/reject/{id}', name: 'app_application_reject')]
    #[IsGranted('ROLE_CLIENT')]
    public function reject(Application $application, EntityManagerInterface $emi): Response
    {
        if ($application->getMission()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Cette candidature ne vous appartient pas.');
        }

        $statusRejeteApplication = $emi->getRepository(StatusApplication::class)
            ->findOneBy(['label' => 'rejetée']);
        $application->setStatusApplication($statusRejeteApplication);

        $emi->flush();

        return $this->redirectToRoute('app_mission_applications', ['id' => $application->getMission()->getId()]);
    }
}
