<?php

namespace App\Controller;

use App\Entity\Prest;
use App\Form\PrestType;
use App\Repository\PrestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prest')]
class PrestControlleur extends AbstractController
{
    #[Route('/', name: 'app_prest_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        PrestRepository $prestRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $prests = $prestRepository->findAll();

        // === Formulaire d'ajout ===
        $newPrest = new Prest();
        $addForm = $this->createForm(PrestType::class, $newPrest);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newPrest);
            $entityManager->flush();
            $this->addFlash('success', 'La prestation a été ajoutée avec succès.');
            return $this->redirectToRoute('app_prest_index');
        }

        // === Formulaire de modification ===
        $editId = $request->query->get('edit');
        $prestToEdit = null;
        $editForm = null;

        if ($editId) {
            $prestToEdit = $prestRepository->find($editId);

            if ($prestToEdit) {
                $editForm = $this->createForm(PrestType::class, $prestToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'La prestation a été modifiée avec succès.');
                    return $this->redirectToRoute('app_prest_index');
                }
            }
        }

        return $this->render('prest/index.html.twig', [
            'prests' => $prests,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'prestToEdit' => $prestToEdit,
        ]);
    }

    #[Route('/{SEQPREST}', name: 'app_prest_show', methods: ['GET'])]
    public function show(Prest $prest): Response
    {
        return $this->render('prest/show.html.twig', [
            'prest' => $prest,
        ]);
    }

    #[Route('/{SEQPREST}/delete', name: 'app_prest_delete', methods: ['POST'])]
    public function delete(Request $request, Prest $prest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prest->getSEQPREST(), $request->request->get('_token'))) {
            $entityManager->remove($prest);
            $entityManager->flush();
            $this->addFlash('success', 'La prestation a été supprimée.');
        }

        return $this->redirectToRoute('app_prest_index', [], Response::HTTP_SEE_OTHER);
    }
}
