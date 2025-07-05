<?php

namespace App\Controller;

use App\Entity\TypeOption;
use App\Form\TypeOptionType;
use App\Repository\TypeOptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/option')]
class TypeOptionController extends AbstractController
{
    #[Route('/', name: 'app_type_option_index', methods: ['GET', 'POST'])]
    public function index(TypeOptionRepository $typeOptionRepository, Request $request, EntityManagerInterface $em): Response
    {
        $typeOptions = $typeOptionRepository->findAll();

        // Gestion de la modification inline
        $editId = $request->query->get('edit');
        $editForm = null;
        $typeOptionToEdit = null;

        if ($editId) {
            $typeOptionToEdit = $typeOptionRepository->find($editId);

            if ($typeOptionToEdit) {
                $editForm = $this->createForm(TypeOptionType::class, $typeOptionToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_type_option_index');
                }
            }
        }

        // Formulaire d'ajout (uniquement si pas en mode édition)
        $typeOption = new TypeOption();
        $form = $this->createForm(TypeOptionType::class, $typeOption);

        if (!$editId) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($typeOption);
                $em->flush();
                return $this->redirectToRoute('app_type_option_index');
            }
        }

        return $this->render('type_option/index.html.twig', [
            'type_options' => $typeOptions,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'typeOptionToEdit' => $typeOptionToEdit,
        ]);
    }

    #[Route('/new', name: 'app_type_option_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeOption = new TypeOption();
        $form = $this->createForm(TypeOptionType::class, $typeOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeOption);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_option/new.html.twig', [
            'type_option' => $typeOption,
            'form' => $form,
        ]);
    }

    #[Route('/{seqTypeOption}', name: 'app_type_option_show', methods: ['GET'])]
    public function show(TypeOption $typeOption): Response
    {
        return $this->render('type_option/show.html.twig', [
            'type_option' => $typeOption,
        ]);
    }

    #[Route('/{seqTypeOption}/edit', name: 'app_type_option_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeOption $typeOption, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeOptionType::class, $typeOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_option/edit.html.twig', [
            'type_option' => $typeOption,
            'form' => $form,
        ]);
    }

    #[Route('/{seqTypeOption}', name: 'app_type_option_delete', methods: ['POST'])]
    public function delete(Request $request, TypeOption $typeOption, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $typeOption->getSeqTypeOption(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_type_option_index');
        }

        try {
            $entityManager->remove($typeOption);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type option supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_type_option_index')
                ]);
            }

            $this->addFlash('success', 'Le type option a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du type option.',
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

        return $this->redirectToRoute('app_type_option_index');
    }

    #[Route('/export/pdf', name: 'app_type_option_export_pdf', methods: ['GET'])]
    public function exportPdf(TypeOptionRepository $typeOptionRepository): Response
    {
        $typeOptions = $typeOptionRepository->findAll();

        $html = $this->renderView('type_option/export_pdf.html.twig', [
            'type_options' => $typeOptions,
            'title' => 'Liste des types d\'options'
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="types_options.pdf"');

        return $response;
    }
}
