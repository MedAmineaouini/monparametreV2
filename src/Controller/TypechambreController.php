<?php

namespace App\Controller;

use App\Entity\Typechambre;
use App\Form\TypechambreType;
use App\Repository\TypechambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typechambre')]
class TypechambreController extends AbstractController
{
    #[Route('/', name: 'app_typechambre_index', methods: ['GET', 'POST'])]
    public function index(TypechambreRepository $typechambreRepository, Request $request, EntityManagerInterface $em): Response
    {
        $typechambres = $typechambreRepository->findAll();

        // Gestion de la modification
        $editId = $request->query->get('edit');
        $editForm = null;
        $typechambreToEdit = null;

        if ($editId) {
            $typechambreToEdit = $typechambreRepository->find($editId);

            if ($typechambreToEdit) {
                $editForm = $this->createForm(TypechambreType::class, $typechambreToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_typechambre_index');
                }
            }
        }

        // Formulaire d'ajout
        $typechambre = new Typechambre();
        $form = $this->createForm(TypechambreType::class, $typechambre);

        if (!$editId) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($typechambre);
                $em->flush();
                return $this->redirectToRoute('app_typechambre_index');
            }
        }

        return $this->render('typechambre/index.html.twig', [
            'typechambres' => $typechambres,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'typechambreToEdit' => $typechambreToEdit,
        ]);
    }

    #[Route('/new', name: 'app_typechambre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typechambre = new Typechambre();
        $form = $this->createForm(TypechambreType::class, $typechambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typechambre);
            $entityManager->flush();

            return $this->redirectToRoute('app_typechambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typechambre/new.html.twig', [
            'typechambre' => $typechambre,
            'form' => $form,
        ]);
    }

    #[Route('/{seqtypechambre}', name: 'app_typechambre_show', methods: ['GET'])]
    public function show(Typechambre $typechambre): Response
    {
        return $this->render('typechambre/show.html.twig', [
            'typechambre' => $typechambre,
        ]);
    }

    #[Route('/{seqtypechambre}/edit', name: 'app_typechambre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typechambre $typechambre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypechambreType::class, $typechambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_typechambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typechambre/edit.html.twig', [
            'typechambre' => $typechambre,
            'form' => $form,
        ]);
    }

    #[Route('/{seqtypechambre}', name: 'app_typechambre_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Typechambre $typechambre,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete' . $typechambre->getSeqtypechambre(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_typechambre_index');
        }

        try {
            $entityManager->remove($typechambre);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type de chambre supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_typechambre_index')
                ]);
            }

            $this->addFlash('success', 'Le type de chambre a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de chambre.',
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

        return $this->redirectToRoute('app_typechambre_index');
    }

    #[Route('/export/pdf', name: 'app_typechambre_export_pdf', methods: ['GET'])]
    public function exportPdf(TypechambreRepository $typechambreRepository): Response
    {
        $typechambres = $typechambreRepository->findAll();

        $html = $this->renderView('typechambre/export_pdf.html.twig', [
            'typechambres' => $typechambres,
            'title' => 'Liste des types de chambre'
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="types_chambre.pdf"');

        return $response;
    }
}