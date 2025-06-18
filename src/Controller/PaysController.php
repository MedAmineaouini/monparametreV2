<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pays')]
class PaysController extends AbstractController
{

    #[Route('/', name: 'app_pays_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        PaysRepository $paysRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des pays
        $pays = $paysRepository->findAll();
    
        // === Formulaire d'ajout ===
        $newPays = new Pays();
        $addForm = $this->createForm(PaysType::class, $newPays);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newPays);
            $entityManager->flush();
            $this->addFlash('success', 'Le pays a été ajouté avec succès.');
            return $this->redirectToRoute('app_pays_index');
        }
    
        // === Formulaire de modification ===
        $editId = $request->query->get('edit');
        $paysToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $paysToEdit = $paysRepository->find($editId);
    
            if ($paysToEdit) {
                $editForm = $this->createForm(PaysType::class, $paysToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Le pays a été modifié avec succès.');
                    return $this->redirectToRoute('app_pays_index');
                }
            }
        }
    
        return $this->render('pays/index.html.twig', [
            'pays' => $pays,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'paysToEdit' => $paysToEdit,
        ]);
    }

    #[Route('/new', name: 'app_pays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pay = new Pays();
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pay);
            $entityManager->flush();

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/new.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{IDPAYS}', name: 'app_pays_show', methods: ['GET'])]
    public function show(Pays $pay): Response
    {
        return $this->render('pays/show.html.twig', [
            'pay' => $pay,
        ]);
    }

    #[Route('/{IDPAYS}/edit', name: 'app_pays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pays $pay, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/edit.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{IDPAYS}', name: 'app_pays_delete', methods: ['POST'])]
    public function delete(Request $request, Pays $pay, EntityManagerInterface $entityManager): Response
    {
        if ($request->isXmlHttpRequest()) {
            try {
                $entityManager->remove($pay);
                $entityManager->flush();

                return $this->json([
                    'success' => true,
                    'message' => 'Pays supprimé avec succès.'
                ]);

            } catch (\Exception $e) {
                // Détection spécifique des erreurs de contrainte SQL Server
                if (str_contains($e->getMessage(), 'REFERENCE constraint')) {
                    preg_match('/table "([^"]+)"/', $e->getMessage(), $matches);
                    $table = $matches[1] ?? 'une table';

                    return $this->json([
                        'success' => false,
                        'message' => "Impossible de supprimer : ce pays est utilisé dans $table."
                    ], 400);
                }

                return $this->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
                ], 500);
            }
        }
    }
}
