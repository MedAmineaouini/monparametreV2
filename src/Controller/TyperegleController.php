<?php

namespace App\Controller;

use App\Entity\Typeregle;
use App\Form\TyperegleType;
use App\Repository\TyperegleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeregle')]
class TyperegleController extends AbstractController
{
    #[Route('/', name: 'app_typeregle_index', methods: ['GET', 'POST'])]
    public function index(TyperegleRepository $typeregleRepository, Request $request, EntityManagerInterface $em): Response
    {
        $typeregles = $typeregleRepository->findAll();

        // Gestion de la modification (doit être avant l'ajout)
        $editId = $request->query->get('edit');
        $editForm = null;
        $typeregleToEdit = null;

        if ($editId) {
            $typeregleToEdit = $typeregleRepository->find($editId);

            if ($typeregleToEdit) {
                $editForm = $this->createForm(TyperegleType::class, $typeregleToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_typeregle_index');
                }
            }
        }

        // Formulaire d'ajout (uniquement si pas en mode édition)
        $typeregle = new Typeregle();
        $form = $this->createForm(TyperegleType::class, $typeregle);

        // Ne traite le formulaire d'ajout que si on n'est pas en mode édition
        if (!$editId) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($typeregle);
                $em->flush();
                return $this->redirectToRoute('app_typeregle_index');
            }
        }

        return $this->render('typeregle/index.html.twig', [
            'typeregles' => $typeregles,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'typeregleToEdit' => $typeregleToEdit,
        ]);
    }

    #[Route('/new', name: 'app_typeregle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeregle = new Typeregle();
        $form = $this->createForm(TyperegleType::class, $typeregle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeregle);
            $entityManager->flush();

            return $this->redirectToRoute('app_typeregle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typeregle/new.html.twig', [
            'typeregle' => $typeregle,
            'form' => $form,
        ]);

    }

    #[Route('/{seqtyperegle}', name: 'app_typeregle_show', methods: ['GET'])]
    public function show(Typeregle $typeregle): Response
    {
        return $this->render('typeregle/show.html.twig', [
            'typeregle' => $typeregle,
        ]);
    }

    #[Route('/{seqtyperegle}/edit', name: 'app_typeregle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typeregle $typeregle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TyperegleType::class, $typeregle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_typeregle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typeregle/edit.html.twig', [
            'typeregle' => $typeregle,
            'form' => $form,
        ]);
    }

    #[Route('/{seqtyperegle}', name: 'app_typeregle_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Typeregle $typeregle,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete' . $typeregle->getSeqtyperegle(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_typeregle_index');
        }

        try {
            $entityManager->remove($typeregle);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type de règle supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_typeregle_index')
                ]);
            }

            $this->addFlash('success', 'Le type de règle a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de règle.',
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

        return $this->redirectToRoute('app_typeregle_index');
    }
    #[Route('/export/pdf', name: 'app_typeregle_export_pdf', methods: ['GET'])]
    public function exportPdf(TyperegleRepository $typeregleRepository): Response
    {
        $typeregles = $typeregleRepository->findAll();

        $html = $this->renderView('typeregle/export_pdf.html.twig', [
            'typeregles' => $typeregles,
            'title' => 'Liste des types de règlements'
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="types_reglements.pdf"');

        return $response;
    }

}
