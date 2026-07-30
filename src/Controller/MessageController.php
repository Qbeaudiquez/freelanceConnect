<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{
    #[Route('/mission/{id}/messages', name: 'app_message_index')]
    public function index(Mission $mission, Request $request, MessageRepository $messageRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $isOwner = ($mission->getUser() === $user);

        $isAcceptedFreelance = false;
        foreach ($mission->getApplications() as $application) {
            if ($application->getUser() === $user
                && $application->getStatusApplication()->getLabel() === 'acceptée') {
                $isAcceptedFreelance = true;
            }
        }

        if (!$isOwner && !$isAcceptedFreelance) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette messagerie.');
        }

        if ($request->isMethod('POST')) {
            $content = $request->request->get('content');
            $token = $request->request->get('_token');

            if ($content && $this->isCsrfTokenValid('send_message', $token)) {
                $message = new Message();
                $message->setContent($content);
                $message->setSentAt(new \DateTimeImmutable());
                $message->setSender($this->getUser());
                $message->setMission($mission);

                $em->persist($message);
                $em->flush();

                return $this->redirectToRoute('app_message_index', ['id' => $mission->getId()]);
            }
        }

        $messages = $messageRepository->findByMission($mission);

        return $this->render('message/index.html.twig', [
            'mission' => $mission,
            'messages' => $messages,
        ]);
    }
}