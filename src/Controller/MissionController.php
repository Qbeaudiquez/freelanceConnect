<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\MissionCategory;
use App\Entity\StatusMission;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use \Symfony\Component\Form\FormError;

class MissionController extends AbstractController
{
    #[Route('/mission/new', name: 'app_mission_new')]
    #[IsGranted('ROLE_CLIENT')]
    public function new(Request $request, EntityManagerInterface $emi): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        $statusEnAttente = $emi->getRepository(StatusMission::class)
            ->findOneBy(['label' => 'en attente de freelance']);
        $mission->setStatusMission($statusEnAttente);
        $mission->setAdvanceRate(0);
        $mission->setCreatedAt(new \DateTimeImmutable());
        $user = $this->getUser();
        $mission->setUser($user);

        if ($form->isSubmitted() && $mission->getBudget() < 0) {
            $form->get('budget')->addError(new FormError('Le budget doit être un nombre positif.'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->syncCategories($mission, $form->get('categories')->getData());

            $emi->persist($mission);
            $emi->flush();

            return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
        }

        return $this->render('mission/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/mission/{id}', name: 'app_mission_show')]
    public function show(Mission $mission): Response
    {
        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[Route('/mission/{id}/edit', name: 'app_mission_edit')]
    #[IsGranted('ROLE_CLIENT')]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $emi): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->get('categories')->setData($mission->getCategories()->toArray());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->syncCategories($mission, $form->get('categories')->getData());

            $emi->flush();

            return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
        }

        return $this->render('mission/edit.html.twig', [
            'form' => $form,
            'mission' => $mission,
        ]);
    }

    private function syncCategories(Mission $mission, iterable $selectedCategories): void
    {
        $selectedCategories = is_array($selectedCategories) ? $selectedCategories : iterator_to_array($selectedCategories);

        foreach ($mission->getMissionCategories()->toArray() as $missionCategory) {
            if (!in_array($missionCategory->getCategory(), $selectedCategories, true)) {
                $mission->removeMissionCategory($missionCategory);
            }
        }

        $existingCategories = $mission->getCategories();
        foreach ($selectedCategories as $category) {
            if (!$existingCategories->contains($category)) {
                $missionCategory = new MissionCategory();
                $missionCategory->setCategory($category);
                $mission->addMissionCategory($missionCategory);
            }
        }
    }

    #[Route('/mission/{id}/delete', name: 'app_mission_delete', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function delete(Request $request, Mission $mission, EntityManagerInterface $emi): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $mission->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $emi->remove($mission);
        $emi->flush();

        $redirect = $request->request->get('redirect', 'app_home');
        if (!in_array($redirect, ['app_dashboard_client', 'app_dashboard_admin'], true)) {
            $redirect = 'app_dashboard_client';
        }

        return $this->redirectToRoute($redirect);
    }

    #[Route('/missions', name: 'app_missions')]
    public function index(EntityManagerInterface $emi): Response
    {
        return $this->render('mission/index.html.twig', [
            'missions' => $emi->getRepository(Mission::class)->findOpenMissions(),
        ]);
    }
}
