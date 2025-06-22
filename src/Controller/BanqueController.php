<?php

namespace App\Controller;

use App\Entity\Banque;
use App\Form\BanqueType;
use App\Repository\BanqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/banque')]
class BanqueController extends AbstractController
{
    #[Route('/', name: 'app_banque_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        BanqueRepository $banqueRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des banques
        $banques = $banqueRepository->findAll();
    
        // Formulaire d'ajout
        $newBanque = new Banque();
        $addForm = $this->createForm(BanqueType::class, $newBanque);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newBanque);
            $entityManager->flush();
            $this->addFlash('success', 'La banque a été ajoutée avec succès.');
            return $this->redirectToRoute('app_banque_index');
        }
    
        // Formulaire de modification
        $editId = $request->query->get('edit');
        $banqueToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $banqueToEdit = $banqueRepository->find($editId);
    
            if ($banqueToEdit) {
                $editForm = $this->createForm(BanqueType::class, $banqueToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'La banque a été modifiée avec succès.');
                    return $this->redirectToRoute('app_banque_index');
                }
            }
        }
    
        return $this->render('banque/index.html.twig', [
            'banques' => $banques,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'banqueToEdit' => $banqueToEdit,
        ]);
    }

    #[Route('/{SEQBANQUE}', name: 'app_banque_show', methods: ['GET'])]
    public function show(Banque $banque): Response
    {
        return $this->render('banque/show.html.twig', [
            'banque' => $banque,
        ]);
    }

    #[Route('/{SEQBANQUE}', name: 'app_banque_delete', methods: ['POST'])]
    public function delete(Request $request, Banque $banque, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$banque->getSEQBANQUE(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide'
                ], Response::HTTP_BAD_REQUEST);
            }
            
            $this->addFlash('error', 'Token CSRF invalide');
            return $this->redirectToRoute('app_banque_index');
        }
    
        try {
            // Vérification des dépendances avant suppression
            $dependencies = [
                // Ajoutez ici d'autres relations si nécessaire
                // Exemple: 'ComptesBancaires' => count($banque->getComptesBancaires())
            ];
    
            $usedIn = array_filter($dependencies, fn($count) => $count > 0);
            
            if (!empty($usedIn)) {
                $message = 'Impossible de supprimer cette banque car elle est utilisée dans : ';
                $message .= implode(', ', array_keys($usedIn));
                
                throw new \Exception($message);
            }
    
            $entityManager->remove($banque);
            $entityManager->flush();
            
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'La banque a été supprimée avec succès',
                    'redirect' => $this->generateUrl('app_banque_index')
                ]);
            }
            
            $this->addFlash('success', 'La banque a été supprimée avec succès.');
        } catch (\Exception $e) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Échec de la suppression : ' . $e->getMessage(),
                    'reference' => 'BANQUE-'.$banque->getSEQBANQUE(),
                    'relations' => $usedIn ?? []
                ], Response::HTTP_CONFLICT);
            }
            
            $this->addFlash('error', 'Échec de la suppression : ' . $e->getMessage());
        }
    
        return $this->redirectToRoute('app_banque_index');
    }
}