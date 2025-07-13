<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Form\CommissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commission')]
class CommissionController extends AbstractController
{
    #[Route('/', name: 'app_commission_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commissions = $entityManager
            ->getRepository(Commission::class)
            ->findAll();

        return $this->render('commission/index.html.twig', [
            'commissions' => $commissions,
        ]);
    }

    #[Route('/new', name: 'app_commission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commission = new Commission();
        $form = $this->createForm(CommissionType::class, $commission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commission);
            $entityManager->flush();

            return $this->redirectToRoute('app_commission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commission/new.html.twig', [
            'commission' => $commission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commission_show', methods: ['GET'])]
    public function show(Commission $commission): Response
    {
        return $this->render('commission/show.html.twig', [
            'commission' => $commission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commission $commission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommissionType::class, $commission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commission/edit.html.twig', [
            'commission' => $commission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commission_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Commission $commission,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete' . $commission->getId(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            return $this->redirectToRoute('app_commission_index');
        }
    
        try {
            $entityManager->remove($commission);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Commission supprimée avec succès.',
                    'redirect' => $this->generateUrl('app_commission_index'),
                ]);
            }
    
            $this->addFlash('success', 'La commission a été supprimée avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de la commission.',
                'details' => $this->getParameter('kernel.debug') ? [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ] : null,
            ];
    
            if ($request->isXmlHttpRequest()) {
                return $this->json($errorData, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    
            $this->addFlash('error', $errorData['message']);
        }
    
        return $this->redirectToRoute('app_commission_index');
    }
    
}
