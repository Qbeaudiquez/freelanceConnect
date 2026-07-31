<?php

namespace App\Controller;

use App\Entity\Ban;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function dashboardAdmin(UserRepository $userRepository, MissionRepository $missionRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('dashboard/admin.html.twig', [
            'usersCount' => $userRepository->count([]),
            'clientsCount' => $userRepository->countByRole('ROLE_CLIENT'),
            'freelancesCount' => $userRepository->countByRole('ROLE_FREELANCE'),
            'missionsCount' => $missionRepository->count([]),
            'missionsPendingCount' => $missionRepository->countMissionsByLabel('en attente de freelance'),
            'missionsTerminatedCount' => $missionRepository->countMissionsByLabel('terminée'),
            'missions' => $missionRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/dashboard/admin/users', name: 'app_dashboard_admin_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboardAdminUsers(UserRepository $userRepository): Response
    {
        return $this->render('dashboard/admin_users.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/dashboard/admin/users/{id}/ban', name: 'app_dashboard_admin_user_ban', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function banUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('ban' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas vous bannir vous-même.');

            return $this->redirectToRoute('app_dashboard_admin_users');
        }

        $ban = new Ban();
        $ban->setEmail($user->getEmail());
        $ban->setIp('0.0.0.0');
        $ban->setBannedAt(new \DateTimeImmutable());

        $entityManager->persist($ban);
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur banni avec succès.');

        return $this->redirectToRoute('app_dashboard_admin_users');
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
    public function dashboardFreelance(LinkRepository $linkRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('dashboard/freelance.html.twig', [
            'applications' => $user->getApplications(),
            'links' => $linkRepository->findByUserId($user->getId()),
        ]);
    }
}
