<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_dashboard_admin');
        }

        if ($this->isGranted('ROLE_CLIENT')) {
            return $this->redirectToRoute('app_dashboard_client');
        }

        return $this->redirectToRoute('app_dashboard_freelance');
    }

    #[Route('/dashboard/admin', name: 'app_dashboard_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboardAdmin(UserRepository $userRepository, MissionRepository $missionRepository): Response
    {
        return $this->render('dashboard/admin.html.twig', [
            'usersCount' => $userRepository->count([]),
            'missionsCount' => $missionRepository->count([]),
        ]);
    }

    #[Route('/dashboard/client', name: 'app_dashboard_client')]
    #[IsGranted('ROLE_CLIENT')]
    public function dashboardClient(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('dashboard/client.html.twig', [
            'missions' => $user->getMissions(),
        ]);
    }

    #[Route('/dashboard/freelance', name: 'app_dashboard_freelance')]
    #[IsGranted('ROLE_FREELANCE')]
    public function dashboardFreelance(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('dashboard/freelance.html.twig', [
            'applications' => $user->getApplications(),
        ]);
    }
}
