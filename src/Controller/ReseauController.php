<?php

namespace App\Controller;

use App\Entity\Reseau;
use App\Form\ReseauType;
use App\Repository\ReseauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reseau')]
class ReseauController extends AbstractController
{
    #[Route('/', name: 'app_reseau_index', methods: ['GET'])]
    public function index(ReseauRepository $reseauRepository): Response
    {
        return $this->render('reseau/index.html.twig', [
            'reseaus' => $reseauRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reseau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reseau = new Reseau();
        $form = $this->createForm(ReseauType::class, $reseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reseau);
            $entityManager->flush();

            $this->addFlash('success', 'Réseau ajouté avec succès.');
            return $this->redirectToRoute('app_reseau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reseau/new.html.twig', [
            'reseau' => $reseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqreseau}', name: 'app_reseau_show', methods: ['GET'])]
    public function show(Reseau $reseau): Response
    {
        return $this->render('reseau/show.html.twig', [
            'reseau' => $reseau,
        ]);
    }

    #[Route('/{seqreseau}/edit', name: 'app_reseau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reseau $reseau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReseauType::class, $reseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Réseau modifié avec succès.');
            return $this->redirectToRoute('app_reseau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reseau/edit.html.twig', [
            'reseau' => $reseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqreseau}', name: 'app_reseau_delete', methods: ['POST'])]
    public function delete(Request $request, Reseau $reseau, EntityManagerInterface $entityManager): Response
    {
        // Vérification du token CSRF
        if (!$this->isCsrfTokenValid('delete'.$reseau->getSeqreseau(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_reseau_index');
        }

        try {
            // Tentative de suppression
            $entityManager->remove($reseau);
            $entityManager->flush();

            // Réponse pour les requêtes AJAX
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Réseau supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_reseau_index')
                ]);
            }

            // Réponse pour les requêtes normales
            $this->addFlash('success', 'Le réseau a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Construction du message d'erreur
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du réseau.',
                'details' => $this->getParameter('kernel.debug') ? [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ] : null,
            ];

            // Réponse d'erreur pour AJAX
            if ($request->isXmlHttpRequest()) {
                return $this->json($errorData, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Réponse d'erreur normale
            $this->addFlash('error', $errorData['message']);
        }

        return $this->redirectToRoute('app_reseau_index');
    }
}