<?php

namespace App\Controller;

use App\Entity\Monnaie;
use App\Form\MonnaieType;
use App\Repository\MonnaieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/monnaie')]
class MonnaieController extends AbstractController
{
    #[Route('/', name: 'app_monnaie_index', methods: ['GET', 'POST'])]
    public function index(MonnaieRepository $monnaieRepository, Request $request, EntityManagerInterface $em): Response
    {
        $monnaies = $monnaieRepository->findAll();

        // Gestion de la modification inline (avant ajout)
        $editId = $request->query->get('edit');
        $editForm = null;
        $monnaieToEdit = null;

        if ($editId) {
            $monnaieToEdit = $monnaieRepository->find($editId);

            if ($monnaieToEdit) {
                $editForm = $this->createForm(MonnaieType::class, $monnaieToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_monnaie_index');
                }
            }
        }

        // Formulaire d'ajout (uniquement si pas en édition)
        $monnaie = new Monnaie();
        $form = $this->createForm(MonnaieType::class, $monnaie);

        if (!$editId) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($monnaie);
                $em->flush();
                return $this->redirectToRoute('app_monnaie_index');
            }
        }

        return $this->render('monnaie/index.html.twig', [
            'monnaies' => $monnaies,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'monnaieToEdit' => $monnaieToEdit,
        ]);
    }

    #[Route('/new', name: 'app_monnaie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $monnaie = new Monnaie();
        $form = $this->createForm(MonnaieType::class, $monnaie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monnaie);
            $entityManager->flush();

            return $this->redirectToRoute('app_monnaie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('monnaie/new.html.twig', [
            'monnaie' => $monnaie,
            'form' => $form,
        ]);
    }

    #[Route('/{seqmonnaie}', name: 'app_monnaie_show', methods: ['GET'])]
    public function show(Monnaie $monnaie): Response
    {
        return $this->render('monnaie/show.html.twig', [
            'monnaie' => $monnaie,
        ]);
    }

    #[Route('/{seqmonnaie}/edit', name: 'app_monnaie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Monnaie $monnaie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MonnaieType::class, $monnaie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monnaie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('monnaie/edit.html.twig', [
            'monnaie' => $monnaie,
            'form' => $form,
        ]);
    }

    #[Route('/{seqmonnaie}', name: 'app_monnaie_delete', methods: ['POST'])]
    public function delete(Request $request, Monnaie $monnaie, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $monnaie->getSeqmonnaie(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_monnaie_index');
        }

        try {
            $entityManager->remove($monnaie);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Monnaie supprimée avec succès.',
                    'redirect' => $this->generateUrl('app_monnaie_index')
                ]);
            }

            $this->addFlash('success', 'La monnaie a été supprimée avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de la monnaie.',
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

        return $this->redirectToRoute('app_monnaie_index');
    }
}
