<?php

namespace App\Controller;

use App\Entity\FraisModif;
use App\Form\FraisModifType;
use App\Repository\FraisModifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frais/modif')]
class FraisModifController extends AbstractController
{
    #[Route('/', name: 'app_frais_modif_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        FraisModifRepository $fraisModifRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $fraisModifs = $fraisModifRepository->findAll();

        // === Formulaire d'ajout ===
        $newFrais = new FraisModif();
        $addForm = $this->createForm(FraisModifType::class, $newFrais);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newFrais);
            $entityManager->flush();
            $this->addFlash('success', 'Frais modificateur ajouté avec succès.');
            return $this->redirectToRoute('app_frais_modif_index');
        }

        // === Formulaire d'édition si ?edit=id ===
        $editId = $request->query->get('edit');
        $fraisToEdit = null;
        $editForm = null;

        if ($editId) {
            $fraisToEdit = $fraisModifRepository->find($editId);

            if ($fraisToEdit) {
                $editForm = $this->createForm(FraisModifType::class, $fraisToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Frais modificateur modifié avec succès.');
                    return $this->redirectToRoute('app_frais_modif_index');
                }
            }
        }

        return $this->render('frais_modif/index.html.twig', [
            'frais_modifs' => $fraisModifs,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'fraisToEdit' => $fraisToEdit,
        ]);
    }

    #[Route('/{seqmodif}', name: 'app_frais_modif_show', methods: ['GET'])]
    public function show(FraisModif $fraisModif): Response
    {
        return $this->render('frais_modif/show.html.twig', [
            'frais_modif' => $fraisModif,
        ]);
    }

    #[Route('/{seqmodif}/edit', name: 'app_frais_modif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FraisModif $fraisModif, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FraisModifType::class, $fraisModif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Frais modificateur mis à jour.');
            return $this->redirectToRoute('app_frais_modif_index');
        }

        return $this->renderForm('frais_modif/edit.html.twig', [
            'frais_modif' => $fraisModif,
            'form' => $form,
        ]);
    }

    #[Route('/{seqmodif}', name: 'app_frais_modif_delete', methods: ['POST'])]
    public function delete(Request $request, FraisModif $fraisModif, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$fraisModif->getSeqmodif(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_frais_modif_index');
        }

        try {
            $entityManager->remove($fraisModif);
            $entityManager->flush();
            $this->addFlash('success', 'Frais modificateur supprimé.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la suppression.');
        }

        return $this->redirectToRoute('app_frais_modif_index');
    }
}
