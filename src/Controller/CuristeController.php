<?php

namespace App\Controller;

use App\Entity\Curiste;
use App\Form\CuristeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CuristeRepository;

#[Route('/curiste')]
class CuristeController extends AbstractController
{
    #[Route('/', name: 'app_curiste_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $curistes = $entityManager
            ->getRepository(Curiste::class)
            ->findAll();

        return $this->render('curiste/index.html.twig', [
            'curistes' => $curistes,
        ]);
    }

    #[Route('/new', name: 'app_curiste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CuristeRepository $curisteRepository): Response
    {
        $curiste = new Curiste();
        $form = $this->createForm(CuristeType::class, $curiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si le curiste existe déjà
            $existingCuriste = $curisteRepository->findOneBy(['codeCuriste' => $curiste->getCodeCuriste()]);

            if ($existingCuriste) {
                $this->addFlash('error', 'Un curiste avec ce code ('.$curiste->getCodeCuriste().') existe déjà.');
                return $this->redirectToRoute('app_curiste_new');
            }

            try {
                $entityManager->persist($curiste);
                $entityManager->flush();

                $this->addFlash('success', 'Curiste ajouté avec succès.');
                return $this->redirectToRoute('app_curiste_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'ajout du curiste: '.$e->getMessage());
            }
        }

        return $this->render('curiste/new.html.twig', [
            'curiste' => $curiste,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqCuriste}', name: 'app_curiste_show', methods: ['GET'])]
    public function show(Curiste $curiste): Response
    {
        return $this->render('curiste/show.html.twig', [
            'curiste' => $curiste,
        ]);
    }

    #[Route('/{seqCuriste}/edit', name: 'app_curiste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Curiste $curiste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CuristeType::class, $curiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Curiste modifié avec succès.');
            return $this->redirectToRoute('app_curiste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('curiste/edit.html.twig', [
            'curiste' => $curiste,
            'form' => $form,
        ]);
    }

    #[Route('/{seqCuriste}', name: 'app_curiste_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Curiste $curiste,
        EntityManagerInterface $entityManager
    ): Response {
        // Vérification du token CSRF
        if (!$this->isCsrfTokenValid('delete'.$curiste->getSeqCuriste(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_curiste_index');
        }

        try {
            // Tentative de suppression
            $entityManager->remove($curiste);
            $entityManager->flush();

            // Réponse pour les requêtes AJAX
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Curiste supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_curiste_index')
                ]);
            }

            // Réponse pour les requêtes normales
            $this->addFlash('success', 'Le curiste a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Construction du message d'erreur
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du curiste.',
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

        return $this->redirectToRoute('app_curiste_index');
    }
}
