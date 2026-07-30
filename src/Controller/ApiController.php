<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api/missions', name: 'api_missions', methods: ['GET'])]
    public function missions(MissionRepository $missionRepository): JsonResponse
    {
        $missions = $missionRepository->findOpenMissions();

        return $this->json($missions, 200, [], [
            'groups' => ['mission_read'],
        ]);
    }

    #[Route('/api/missions/recent', name: 'api_missions_recent', methods: ['GET'])]
    public function recentMissions(MissionRepository $missionRepository): JsonResponse
    {
        $missions = $missionRepository->findRecentMissions();

        return $this->json($missions, 200, [], [
            'groups' => ['mission_read'],
        ]);
    }
}