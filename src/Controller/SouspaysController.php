<?php

namespace App\Controller;

use App\Entity\Souspays;
use App\Entity\Ville;
use App\Form\SouspaysType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SouspaysRepository;

#[Route('/souspays')]
class SouspaysController extends AbstractController
{
    #[Route('/', name: 'app_souspays_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        SouspaysRepository $sousPaysRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des sous-pays
        $souspays = $sousPaysRepository->findAll();
    
        // === Formulaire d'ajout ===
        $newSousPays = new SousPays();
        $addForm = $this->createForm(SousPaysType::class, $newSousPays);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newSousPays);
            $entityManager->flush();
            $this->addFlash('success', 'Le sous-pays a été ajouté avec succès.');
            return $this->redirectToRoute('app_souspays_index');
        }
    
        // === Formulaire de modification ===
        $editId = $request->query->get('edit');
        $sousPaysToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $sousPaysToEdit = $sousPaysRepository->find($editId);
    
            if ($sousPaysToEdit) {
                $editForm = $this->createForm(SousPaysType::class, $sousPaysToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Le sous-pays a été modifié avec succès.');
                    return $this->redirectToRoute('app_souspays_index');
                }
            }
        }
    
        return $this->render('souspays/index.html.twig', [
            'souspays' => $souspays,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'sousPaysToEdit' => $sousPaysToEdit,
        ]);
    }


    #[Route('/new', name: 'app_souspays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $souspay = new Souspays();
        $form = $this->createForm(SouspaysType::class, $souspay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($souspay);
            $entityManager->flush();

            return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souspays/new.html.twig', [
            'souspay' => $souspay,
            'form' => $form,
        ]);
    }

    #[Route('/{seqsouspays}', name: 'app_souspays_show', methods: ['GET'])]
    public function show(Souspays $souspay): Response
    {
        return $this->render('souspays/show.html.twig', [
            'souspay' => $souspay,
        ]);
    }

    #[Route('/{seqsouspays}/edit', name: 'app_souspays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souspays $souspay, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SouspaysType::class, $souspay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souspays/edit.html.twig', [
            'souspay' => $souspay,
            'form' => $form,
        ]);
    }

    #[Route('/{seqsouspays}', name: 'app_souspays_delete', methods: ['POST'])]
    public function delete(Request $request, Souspays $souspay, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$souspay->getSeqsouspays(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide'
                ], Response::HTTP_BAD_REQUEST);
            }
            
            $this->addFlash('error', 'Token CSRF invalide');
            return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
        }
    
        try {
            // Vérification explicite des dépendances
            $dependencies = [
                'Villes' => $entityManager->getRepository(Ville::class)->count(['souspays' => $souspay]),
                // Ajoutez d'autres relations si nécessaire
            ];
    
            $usedIn = array_filter($dependencies, fn($count) => $count > 0);
            
            if (!empty($usedIn)) {
                $message = 'Ce sous-pays ne peut pas être supprimé car il est utilisé dans : ';
                $message .= implode(', ', array_keys($usedIn));
                
                throw new \Exception($message);
            }
    
            $entityManager->remove($souspay);
            $entityManager->flush();
            
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Le sous-pays a été supprimé avec succès'
                ]);
            }
            
            $this->addFlash('success', 'Le sous-pays a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => $e->getMessage(),
                'reference' => $souspay->getSeqsouspays(),
                'details' => []
            ];
    
            // Détails supplémentaires en mode développement
            if ($this->getParameter('kernel.environment') === 'dev') {
                $errorData['details'] = [
                    'exception' => get_class($e),
                    'constraint' => str_contains($e->getMessage(), 'foreign key constraint') ? 'FK_XXXX' : null,
                    'trace' => $e->getTraceAsString()
                ];
            }
    
            if ($request->isXmlHttpRequest()) {
                return $this->json($errorData, Response::HTTP_CONFLICT);
            }
            
            $this->addFlash('error', $errorData['message']);
        }
    
        return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
    }
}
