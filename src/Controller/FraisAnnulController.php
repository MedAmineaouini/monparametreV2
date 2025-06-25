<?php

namespace App\Controller;

use App\Entity\FraisAnnul;
use App\Form\FraisAnnulType;
use App\Repository\FraisAnnulRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frais/annul')]
class FraisAnnulController extends AbstractController
{
    #[Route('/', name: 'app_frais_annul_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        FraisAnnulRepository $fraisAnnulRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $fraisAnnuls = $fraisAnnulRepository->findAll();

        // Formulaire d'ajout
        $newFraisAnnul = new FraisAnnul();
        $addForm = $this->createForm(FraisAnnulType::class, $newFraisAnnul);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newFraisAnnul);
            $entityManager->flush();

            $this->addFlash('success', 'Frais d\'annulation ajouté avec succès.');
            return $this->redirectToRoute('app_frais_annul_index');
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $fraisToEdit = null;
        $editForm = null;

        if ($editId) {
            $fraisToEdit = $fraisAnnulRepository->find($editId);
            if ($fraisToEdit) {
                $editForm = $this->createForm(FraisAnnulType::class, $fraisToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Frais d\'annulation modifié avec succès.');
                    return $this->redirectToRoute('app_frais_annul_index');
                }
            }
        }

        return $this->render('frais_annul/index.html.twig', [
            'frais_annuls' => $fraisAnnuls,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'fraisToEdit' => $fraisToEdit,
        ]);
    }

    #[Route('/{seqannul}', name: 'app_frais_annul_show', methods: ['GET'])]
    public function show(FraisAnnul $fraisAnnul): Response
    {
        return $this->render('frais_annul/show.html.twig', [
            'frais_annul' => $fraisAnnul,
        ]);
    }

    #[Route('/{seqannul}', name: 'app_frais_annul_delete', methods: ['POST'])]
    public function delete(Request $request, FraisAnnul $fraisAnnul, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$fraisAnnul->getSeqannul(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_frais_annul_index');
        }

        try {
            $entityManager->remove($fraisAnnul);
            $entityManager->flush();
            $this->addFlash('success', 'Frais d\'annulation supprimé.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la suppression.');
        }

        return $this->redirectToRoute('app_frais_annul_index');
    }
}
