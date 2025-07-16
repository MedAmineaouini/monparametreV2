<?php

namespace App\Controller;

use App\Entity\Affreteur;
use App\Form\AffreteurType;
use App\Repository\AffreteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affreteur')]
class AffreteurController extends AbstractController
{
    #[Route('/', name: 'app_affreteur_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        AffreteurRepository $affreteurRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $affreteurs = $affreteurRepository->findAll();

        // Formulaire d'ajout
        $newAffreteur = new Affreteur();
        $addForm = $this->createForm(AffreteurType::class, $newAffreteur);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newAffreteur);
            $entityManager->flush();

            $this->addFlash('success', 'Affréteur ajouté avec succès.');
            return $this->redirectToRoute('app_affreteur_index');
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $affreteurToEdit = null;
        $editForm = null;

        if ($editId) {
            $affreteurToEdit = $affreteurRepository->find($editId);
            if ($affreteurToEdit) {
                $editForm = $this->createForm(AffreteurType::class, $affreteurToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Affréteur modifié avec succès.');
                    return $this->redirectToRoute('app_affreteur_index');
                }
            }
        }

        return $this->render('affreteur/index.html.twig', [
            'affreteurs' => $affreteurs,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'affreteurToEdit' => $affreteurToEdit,
        ]);
    }

    #[Route('/new', name: 'app_affreteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $affreteur = new Affreteur();
        $form = $this->createForm(AffreteurType::class, $affreteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affreteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_affreteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affreteur/new.html.twig', [
            'affreteur' => $affreteur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqaffret}', name: 'app_affreteur_show', methods: ['GET'])]
    public function show(Affreteur $affreteur): Response
    {
        return $this->render('affreteur/show.html.twig', [
            'affreteur' => $affreteur,
        ]);
    }

    #[Route('/{seqaffret}/edit', name: 'app_affreteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affreteur $affreteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AffreteurType::class, $affreteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_affreteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affreteur/edit.html.twig', [
            'affreteur' => $affreteur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqaffret}', name: 'app_affreteur_delete', methods: ['POST'])]
    public function delete(Request $request, Affreteur $affreteur, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $affreteur->getSeqaffret(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_affreteur_index');
        }

        try {
            $em->remove($affreteur);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Affréteur supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_affreteur_index')
                ]);
            }

            $this->addFlash('success', 'L\'affréteur a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'affréteur.',
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

        return $this->redirectToRoute('app_affreteur_index');
    }
}
