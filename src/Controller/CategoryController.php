<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController
{
    #[Route('/category/new', name: 'app_category_new', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $emi): Response
    {
        if (!$this->isCsrfTokenValid('new_category', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $category = new Category();
        $category->setLabel($request->request->get('label'));

        $emi->persist($category);
        $emi->flush();

        return $this->redirectToRoute('app_dashboard_admin');
    }

    #[Route('/category/{id}/delete', name: 'app_category_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Category $category, EntityManagerInterface $emi): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $emi->remove($category);
        $emi->flush();

        $redirect = $request->request->get('redirect', 'app_dashboard_admin');
        if (!in_array($redirect, ['app_dashboard_admin'], true)) {
            $redirect = 'app_dashboard_admin';
        }

        return $this->redirectToRoute($redirect);
    }
}
