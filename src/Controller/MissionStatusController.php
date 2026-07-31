<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\StatusMission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Invoice;
use App\Entity\InvoiceStatus;

class MissionStatusController extends AbstractController
{
    #[Route('/mission/{id}/complete', name: 'app_mission_complete', methods: ['POST'])]
    #[IsGranted('ROLE_FREELANCE')]
    public function complete(Mission $mission, Request $request, EntityManagerInterface $emi): Response
    {
        $isAccepted = false;
        foreach ($mission->getApplications() as $application) {
            if ($application->getUser() === $this->getUser()
                && $application->getStatusApplication()->getLabel() === 'acceptée') {
                $isAccepted = true;
            }
        }
        if (!$isAccepted || !$this->isCsrfTokenValid('complete' . $mission->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }
        $statusTerminee = $emi->getRepository(StatusMission::class)->findOneBy(['label' => 'terminée']);
        $mission->setStatusMission($statusTerminee);
        $emi->flush();

        return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
    }

    #[Route('/mission/{id}/invoice', name: 'app_mission_invoice', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function invoice(Mission $mission, Request $request, EntityManagerInterface $emi): Response
    {
        if ($mission->getUser() !== $this->getUser()
            || !$this->isCsrfTokenValid('invoice' . $mission->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }
        $statusFacturee = $emi->getRepository(StatusMission::class)->findOneBy(['label' => 'facturée']);
        $mission->setStatusMission($statusFacturee);

        $statusEnAttente = $emi->getRepository(InvoiceStatus::class)->findOneBy(['label' => 'en attente']);
        $invoice = new Invoice();
        $invoice->setMission($mission);
        $invoice->setInvoiceStatus($statusEnAttente);
        $invoice->setCreatedAt(new \DateTimeImmutable());

        $emi->persist($invoice);
        $emi->flush();

        return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
    }
}