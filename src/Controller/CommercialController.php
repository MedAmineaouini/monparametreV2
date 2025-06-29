<?php

namespace App\Controller;

use App\Entity\Commercial;
use App\Form\CommercialType;
use App\Repository\CommercialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commercial')]
class CommercialController extends AbstractController
{
    #[Route('/', name: 'app_commercial_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        CommercialRepository $commercialRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des commerciaux
        $commercials = $commercialRepository->findAll();
    
        // === Formulaire d'ajout ===
        $newCommercial = new Commercial();
        $addForm = $this->createForm(CommercialType::class, $newCommercial);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newCommercial);
            $entityManager->flush();
            $this->addFlash('success', 'Le commercial a été ajouté avec succès.');
            return $this->redirectToRoute('app_commercial_index');
        }
    
        // === Formulaire de modification ===
        $editId = $request->query->get('edit');
        $commercialToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $commercialToEdit = $commercialRepository->find($editId);
    
            if ($commercialToEdit) {
                $editForm = $this->createForm(CommercialType::class, $commercialToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Le commercial a été modifié avec succès.');
                    return $this->redirectToRoute('app_commercial_index');
                }
            }
        }
    
        return $this->render('commercial/index.html.twig', [
            'commercials' => $commercials,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'commercialToEdit' => $commercialToEdit,
        ]);
    }
    
    
    #[Route('/edit/{id}', name: 'app_commercial_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $id,
        Request $request,
        CommercialRepository $commercialRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $commercial = $commercialRepository->find($id);
    
        if (!$commercial) {
            throw $this->createNotFoundException('Commercial introuvable');
        }
    
        $form = $this->createForm(CommercialType::class, $commercial);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Le commercial a été modifié avec succès.');
            return $this->redirectToRoute('app_commercial_index');
        }
    
        return $this->render('commercial/edit.html.twig', [
            'editForm' => $form->createView(),
            'commercial' => $commercial
        ]);
    }
    

    #[Route('/{seqCommercial}', name: 'app_commercial_show', methods: ['GET'])]
    public function show(Commercial $commercial): Response
    {
        return $this->render('commercial/show.html.twig', [
            'commercial' => $commercial,
        ]);
    }


    #[Route('/{seqCommercial}', name: 'app_commercial_delete', methods: ['POST'])]
    public function delete(Request $request, Commercial $commercial, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $commercial->getSeqCommercial(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_commercial_index');
        }
    
        try {
            $entityManager->remove($commercial);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Commercial supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_commercial_index')
                ]);
            }
    
            $this->addFlash('success', 'Le commercial a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du commercial.',
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
    
        return $this->redirectToRoute('app_commercial_index');
    }
    
}
