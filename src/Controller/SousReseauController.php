<?php

namespace App\Controller;

use App\Entity\SousReseau;
use App\Form\SousReseau1Type;
use App\Repository\SousReseauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sousreseau')]
class SousReseauController extends AbstractController
{
    #[Route('/', name: 'app_sous_reseau_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        SousReseauRepository $sousReseauRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $sousReseaus = $sousReseauRepository->findAll();

        // Formulaire d'ajout
        $newSousReseau = new SousReseau();
        $addForm = $this->createForm(SousReseau1Type::class, $newSousReseau);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            try {
                $entityManager->persist($newSousReseau);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Sous-réseau ajouté avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_sous_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le sous-réseau '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de l\'ajout du sous-réseau',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $sousReseauToEdit = null;
        $editForm = null;

        if ($editId) {
            $sousReseauToEdit = $sousReseauRepository->find($editId);
            if ($sousReseauToEdit) {
                $editForm = $this->createForm(SousReseau1Type::class, $sousReseauToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    try {
                        $entityManager->flush();

                        $this->addFlash('success', json_encode([
                            'title' => 'Succès',
                            'message' => 'Sous-réseau modifié avec succès.',
                            'type' => 'success'
                        ]));
                        return $this->redirectToRoute('app_sous_reseau_index');

                    } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                        preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                        $duplicateValue = $matches[1] ?? '';

                        $this->addFlash('error', json_encode([
                            'title' => 'Erreur',
                            'message' => "Le sous-réseau '{$duplicateValue}' existe déjà",
                            'type' => 'error'
                        ]));
                    } catch (\Exception $e) {
                        $this->addFlash('error', json_encode([
                            'title' => 'Erreur',
                            'message' => 'Une erreur est survenue lors de la modification',
                            'type' => 'error',
                            'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                        ]));
                    }
                }
            }
        }

        return $this->render('sous_reseau/index.html.twig', [
            'sous_reseaus' => $sousReseaus,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'sousReseauToEdit' => $sousReseauToEdit,
        ]);
    }

    #[Route('/new', name: 'app_sous_reseau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sousReseau = new SousReseau();
        $form = $this->createForm(SousReseau1Type::class, $sousReseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($sousReseau);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Sous-réseau créé avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_sous_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le sous-réseau '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de la création',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        return $this->render('sous_reseau/new.html.twig', [
            'sous_reseau' => $sousReseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqsousreseau}', name: 'app_sous_reseau_show', methods: ['GET'])]
    public function show(SousReseau $sousReseau): Response
    {
        return $this->render('sous_reseau/show.html.twig', [
            'sous_reseau' => $sousReseau,
        ]);
    }

    #[Route('/{seqsousreseau}/edit', name: 'app_sous_reseau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SousReseau $sousReseau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SousReseau1Type::class, $sousReseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Sous-réseau mis à jour avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_sous_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le sous-réseau '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de la mise à jour',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        return $this->render('sous_reseau/edit.html.twig', [
            'sous_reseau' => $sousReseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqsousreseau}', name: 'app_sous_reseau_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        SousReseau $sousReseau,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete'.$sousReseau->getSeqsousreseau(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_sous_reseau_index');
        }

        try {
            $entityManager->remove($sousReseau);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Sous-réseau supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_sous_reseau_index')
                ]);
            }

            $this->addFlash('success', json_encode([
                'title' => 'Succès',
                'message' => 'Sous-réseau supprimé avec succès.',
                'type' => 'success'
            ]));
        } catch (\Exception $e) {
            $errorMessage = 'Une erreur est survenue lors de la suppression du sous-réseau.';

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $this->addFlash('error', json_encode([
                'title' => 'Erreur',
                'message' => $errorMessage,
                'type' => 'error',
                'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
            ]));
        }

        return $this->redirectToRoute('app_sous_reseau_index');
    }
}