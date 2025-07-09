<?php

namespace App\Controller;

use App\Entity\Porteur;
use App\Form\PorteurType;
use App\Repository\PorteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/porteur')]
class PorteurController extends AbstractController
{
    #[Route('/', name: 'app_porteur_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        PorteurRepository $porteurRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $porteur = new Porteur();
        $form = $this->createForm(PorteurType::class, $porteur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($porteur);
            $entityManager->flush();
    
            $this->addFlash('success', 'Le porteur a été ajouté avec succès.');
            return $this->redirectToRoute('app_porteur_index');
        }
    
        $porteurs = $porteurRepository->findAll();
    
        return $this->render('porteur/index.html.twig', [
            'porteurs' => $porteurs,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{seqPorteur}', name: 'app_porteur_show', methods: ['GET'])]
    public function show(Porteur $porteur): Response
    {
        return $this->render('porteur/show.html.twig', [
            'porteur' => $porteur,
        ]);
    }

    #[Route('/{seqPorteur}/edit', name: 'app_porteur_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Porteur $porteur,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(PorteurType::class, $porteur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Le porteur a été modifié avec succès.');
            
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['success' => true]);
            }
            
            return $this->redirectToRoute('app_porteur_index');
        }
    
        if ($request->isXmlHttpRequest()) {
            return $this->render('porteur/_edit_modal.html.twig', [
                'porteur' => $porteur,
                'form' => $form->createView(),
            ]);
        }
    
        return $this->render('porteur/edit.html.twig', [
            'porteur' => $porteur,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{seqPorteur}', name: 'app_porteur_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Porteur $porteur,
        EntityManagerInterface $entityManager
    ): Response {
        $token = $request->request->get('_token');
        $csrfId = 'delete' . $porteur->getSeqPorteur();
    
        if (!$this->isCsrfTokenValid($csrfId, $token)) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            $this->addFlash('error', 'Token CSRF invalide');
            return $this->redirectToRoute('app_porteur_index');
        }
    
        try {
            $entityManager->remove($porteur);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Le porteur a été supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_porteur_index')
                ]);
            }
    
            $this->addFlash('success', 'Le porteur a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du porteur.',
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
    
        return $this->redirectToRoute('app_porteur_index');
    }
    
}