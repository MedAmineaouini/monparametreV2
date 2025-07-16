<?php

namespace App\Controller;

use App\Entity\SuperReseau;
use App\Form\SuperReseauType;
use App\Repository\SuperReseauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/superreseau')]
class SuperReseauController extends AbstractController
{
    #[Route('/', name: 'app_super_reseau_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        SuperReseauRepository $superReseauRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $superReseaus = $superReseauRepository->findAll();

        // Formulaire d'ajout
        $newSuperReseau = new SuperReseau();
        $addForm = $this->createForm(SuperReseauType::class, $newSuperReseau);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            try {
                $entityManager->persist($newSuperReseau);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Super réseau ajouté avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_super_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le super réseau '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de l\'ajout du super réseau',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $superReseauToEdit = null;
        $editForm = null;

        if ($editId) {
            $superReseauToEdit = $superReseauRepository->find($editId);
            if ($superReseauToEdit) {
                $editForm = $this->createForm(SuperReseauType::class, $superReseauToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    try {
                        $entityManager->flush();

                        $this->addFlash('success', json_encode([
                            'title' => 'Succès',
                            'message' => 'Super réseau modifié avec succès.',
                            'type' => 'success'
                        ]));
                        return $this->redirectToRoute('app_super_reseau_index');

                    } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                        preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                        $duplicateValue = $matches[1] ?? '';

                        $this->addFlash('error', json_encode([
                            'title' => 'Erreur',
                            'message' => "Le super réseau '{$duplicateValue}' existe déjà",
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

        return $this->render('super_reseau/index.html.twig', [
            'super_reseaus' => $superReseaus,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'superReseauToEdit' => $superReseauToEdit,
        ]);
    }

    #[Route('/new', name: 'app_super_reseau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $superReseau = new SuperReseau();
        $form = $this->createForm(SuperReseauType::class, $superReseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($superReseau);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Super réseau créé avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_super_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le super réseau '{$duplicateValue}' existe déjà",
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

        return $this->render('super_reseau/new.html.twig', [
            'super_reseau' => $superReseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqsuperreseau}', name: 'app_super_reseau_show', methods: ['GET'])]
    public function show(SuperReseau $superReseau): Response
    {
        return $this->render('super_reseau/show.html.twig', [
            'super_reseau' => $superReseau,
        ]);
    }

    #[Route('/{seqsuperreseau}/edit', name: 'app_super_reseau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuperReseau $superReseau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SuperReseauType::class, $superReseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Super réseau mis à jour avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_super_reseau_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le super réseau '{$duplicateValue}' existe déjà",
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

        return $this->render('super_reseau/edit.html.twig', [
            'super_reseau' => $superReseau,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqsuperreseau}', name: 'app_super_reseau_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        SuperReseau $superReseau,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete'.$superReseau->getSeqsuperreseau(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_super_reseau_index');
        }

        try {
            $entityManager->remove($superReseau);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Super réseau supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_super_reseau_index')
                ]);
            }

            $this->addFlash('success', json_encode([
                'title' => 'Succès',
                'message' => 'Super réseau supprimé avec succès.',
                'type' => 'success'
            ]));
        } catch (\Exception $e) {
            $errorMessage = 'Une erreur est survenue lors de la suppression du super réseau.';

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

        return $this->redirectToRoute('app_super_reseau_index');
    }
}