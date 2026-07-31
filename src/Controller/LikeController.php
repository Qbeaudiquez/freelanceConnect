<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/link/new', name: 'app_link_new', methods: ['POST'])]
    #[IsGranted('ROLE_FREELANCE')]
    public function new(Request $request, EntityManagerInterface $emi): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $link = new Link();
        $link->setLabel($request->request->get('label'));
        $link->setUrl($request->request->get('url'));
        $link->setUser($user);

        $emi->persist($link);
        $emi->flush();

        return $this->redirectToRoute('app_dashboard_client');
    }
}
