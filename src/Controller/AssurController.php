<?php

namespace App\Controller;

use App\Entity\Assur;
use App\Form\AssurType;
use App\Repository\AssurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

#[Route('/assur')]
class AssurController extends AbstractController
{
    #[Route('/', name: 'app_assur_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $assurs = $entityManager
            ->getRepository(Assur::class)
            ->findAll();

        return $this->render('assur/index.html.twig', [
            'assurs' => $assurs,
        ]);
    }

    #[Route('/new', name: 'app_assur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assur = new Assur();
        $form = $this->createForm(AssurType::class, $assur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assur);
            $entityManager->flush();

            return $this->redirectToRoute('app_assur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assur/new.html.twig', [
            'assur' => $assur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqassur}', name: 'app_assur_show', methods: ['GET'])]
    public function show(Assur $assur): Response
    {
        return $this->render('assur/show.html.twig', [
            'assur' => $assur,
        ]);
    }

    #[Route('/{seqassur}/edit', name: 'app_assur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assur $assur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssurType::class, $assur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assur/edit.html.twig', [
            'assur' => $assur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqassur}', name: 'app_assur_delete', methods: ['POST'])]
    public function delete(Request $request, Assur $assur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assur->getSeqassur(), $request->request->get('_token'))) {
            $entityManager->remove($assur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/assur/export/pdf', name: 'app_assur_export_pdf')]
    public function exportPdf(AssurRepository $assurRepository): Response
    {
        // 1. Récupération des données
        $assurs = $assurRepository->findAll();

        // 2. Générer le HTML à partir d'un template
        $html = $this->renderView('assur/pdf.html.twig', [
            'assurs' => $assurs,
        ]);

        // 3. Configuration de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Télécharger le fichier PDF
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="assurances.pdf"',
            ]
        );
    }
}
