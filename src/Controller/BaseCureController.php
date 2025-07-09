<?php

namespace App\Controller;

use App\Entity\BaseCure;
use App\Form\BaseCureType;
use App\Repository\BaseCureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/base_cure')]
class BaseCureController extends AbstractController
{
    #[Route('/', name: 'app_base_cure_index', methods: ['GET', 'POST'])]
    public function index(
        BaseCureRepository $baseCureRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $baseCures = $baseCureRepository->findAll();

        // Gestion de la modification
        $editId = $request->query->getInt('edit');
        $editForm = null;
        $baseCureToEdit = null;

        if ($editId > 0) {
            $baseCureToEdit = $baseCureRepository->find($editId);

            if ($baseCureToEdit) {
                $editForm = $this->createForm(BaseCureType::class, $baseCureToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_base_cure_index');
                }
            }
        }

        // Formulaire d'ajout
        $baseCure = new BaseCure();
        $form = $this->createForm(BaseCureType::class, $baseCure);

        if (!$editForm || !$editForm->isSubmitted()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($baseCure);
                $em->flush();
                return $this->redirectToRoute('app_base_cure_index');
            }
        }

        return $this->render('base_cure/index.html.twig', [
            'base_cures' => $baseCures,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'baseCureToEdit' => $baseCureToEdit,
        ]);
    }

    #[Route('/new', name: 'app_base_cure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $baseCure = new BaseCure();
        $form = $this->createForm(BaseCureType::class, $baseCure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($baseCure);
            $entityManager->flush();

            return $this->redirectToRoute('app_base_cure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base_cure/new.html.twig', [
            'base_cure' => $baseCure,
            'form'      => $form,
        ]);
    }

    #[Route('/{seqcure}', name: 'app_base_cure_show', methods: ['GET'])]
    public function show(BaseCure $baseCure): Response
    {
        return $this->render('base_cure/show.html.twig', [
            'base_cure' => $baseCure,
        ]);
    }

    #[Route('/{seqcure}/edit', name: 'app_base_cure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BaseCure $baseCure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BaseCureType::class, $baseCure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_base_cure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base_cure/edit.html.twig', [
            'base_cure' => $baseCure,
            'form'      => $form,
        ]);
    }

    #[Route('/{seqcure}', name: 'app_base_cure_delete', methods: ['POST'])]
    public function delete(Request $request, BaseCure $baseCure, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $baseCure->getSeqcure(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_base_cure_index');
        }

        try {
            $em->remove($baseCure);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Base Cure supprimée avec succès.',
                    'redirect' => $this->generateUrl('app_base_cure_index')
                ]);
            }

            $this->addFlash('success', 'La base cure a été supprimée avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de la base cure.',
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

        return $this->redirectToRoute('app_base_cure_index');
    }

    #[Route('/export/pdf', name: 'app_base_cure_export_pdf', methods: ['GET'])]
    public function exportPdf(BaseCureRepository $baseCureRepository): Response
    {
        $baseCures = $baseCureRepository->findAll();

        $html = $this->renderView('base_cure/export_pdf.html.twig', [
            'base_cures' => $baseCures,
            'title'      => 'Liste des bases de cures',
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="bases_cures.pdf"');

        return $response;
    }
}
