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

#[Route('/assur')]
class AssurController extends AbstractController
{
    #[Route('/', name: 'app_assur_index', methods: ['GET', 'POST'])]
    public function index(Request $request, AssurRepository $assurRepository, EntityManagerInterface $em): Response
    {
        $assurs = $assurRepository->findAll();

        $editId = $request->query->get('edit');
        $editForm = null;
        $assurToEdit = null;

        // Formulaire de modification (édition)
        if ($editId) {
            $assurToEdit = $assurRepository->find($editId);

            if ($assurToEdit) {
                $editForm = $this->createForm(AssurType::class, $assurToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_assur_index');
                }
            }
        }

        // Formulaire d’ajout (uniquement si on n’est pas en mode édition)
        $form = null;
        if (!$editId) {
            $assur = new Assur();
            $form = $this->createForm(AssurType::class, $assur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($assur);
                $em->flush();
                return $this->redirectToRoute('app_assur_index');
            }
        }

        return $this->render('assur/index.html.twig', [
            'assurs' => $assurs,
            'form' => $form ? $form->createView() : null,
            'editForm' => $editForm ? $editForm->createView() : null,
            'assurToEdit' => $assurToEdit,
        ]);
    }

    #[Route('/{seqassur}', name: 'app_assur_show', methods: ['GET'])]
    public function show(Assur $assur): Response
    {
        return $this->render('assur/show.html.twig', [
            'assur' => $assur,
        ]);
    }

    #[Route('/{seqassur}', name: 'app_assur_delete', methods: ['POST'])]
    public function delete(Request $request, Assur $assur, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $assur->getSeqassur(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_assur_index');
        }

        try {
            $em->remove($assur);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Assurance supprimée avec succès.',
                    'redirect' => $this->generateUrl('app_assur_index')
                ]);
            }

            $this->addFlash('success', 'L\'assurance a été supprimée avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'assurance.',
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

        return $this->redirectToRoute('app_assur_index');
    }

    #[Route('/export/pdf', name: 'app_assur_export_pdf', methods: ['GET'])]
    public function exportPdf(AssurRepository $assurRepository): Response
    {
        $assurs = $assurRepository->findAll();

        $html = $this->renderView('assur/export_pdf.html.twig', [
            'assurs' => $assurs,
            'title' => 'Liste des assurances'
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="assurances.pdf"',
        ]);
    }
}
