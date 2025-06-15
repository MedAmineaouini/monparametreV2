<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Repository\VilleRepository;

#[Route('/ville')]
class VilleController extends AbstractController
{
    #[Route('/', name: 'app_ville_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        VilleRepository $villeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des villes
        $villes = $villeRepository->findAll();
    
        // Formulaire d'ajout
        $newVille = new Ville();
        $addForm = $this->createForm(VilleType::class, $newVille);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newVille);
            $entityManager->flush();
            $this->addFlash('success', 'La ville a été ajoutée avec succès.');
            return $this->redirectToRoute('app_ville_index');
        }
    
        // Formulaire de modification
        $editId = $request->query->get('edit');
        $villeToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $villeToEdit = $villeRepository->find($editId);
            if ($villeToEdit) {
                $editForm = $this->createForm(VilleType::class, $villeToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'La ville a été modifiée avec succès.');
                    return $this->redirectToRoute('app_ville_index');
                }
            }
        }
    
        return $this->render('ville/index.html.twig', [
            'villes' => $villes,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'villeToEdit' => $villeToEdit,
        ]);
    }

    #[Route('/{seqville}', name: 'app_ville_delete', methods: ['POST'])]
    public function delete(Request $request, Ville $ville, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getSeqville(), $request->request->get('_token'))) {
            $entityManager->remove($ville);
            $entityManager->flush();
            $this->addFlash('success', 'La ville a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_ville_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/export/pdf', name: 'app_ville_export_pdf')]
    public function exportPdf(VilleRepository $villeRepository): Response
    {
        $villes = $villeRepository->findAll();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = $this->renderView('ville/pdf.html.twig', [
            'villes' => $villes,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_villes.pdf"',
            ]
        );
    }

    #[Route('/new', name: 'app_ville_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ville);
            $entityManager->flush();

            return $this->redirectToRoute('app_ville_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ville/new.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    #[Route('/{seqville}', name: 'app_ville_show', methods: ['GET'])]
    public function show(Ville $ville): Response
    {
        return $this->render('ville/show.html.twig', [
            'ville' => $ville,
        ]);
    }

    #[Route('/{seqville}/edit', name: 'app_ville_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ville $ville, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ville_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ville/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }


}
