<?php

namespace App\Controller;

use App\Entity\TypeClt;
use App\Form\TypeCltType;
use App\Repository\TypeCltRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeclt')]
class TypeCltController extends AbstractController
{
    #[Route('/', name: 'app_type_clt_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        TypeCltRepository $typeCltRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $typeClts = $typeCltRepository->findAll();

        // Formulaire d'ajout
        $newTypeClt = new TypeClt();
        $addForm = $this->createForm(TypeCltType::class, $newTypeClt);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            try {
                $entityManager->persist($newTypeClt);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Type client ajouté avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_type_clt_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le type client '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de l\'ajout du type client',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $typeCltToEdit = null;
        $editForm = null;

        if ($editId) {
            $typeCltToEdit = $typeCltRepository->find($editId);
            if ($typeCltToEdit) {
                $editForm = $this->createForm(TypeCltType::class, $typeCltToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    try {
                        $entityManager->flush();

                        $this->addFlash('success', json_encode([
                            'title' => 'Succès',
                            'message' => 'Type client modifié avec succès.',
                            'type' => 'success'
                        ]));
                        return $this->redirectToRoute('app_type_clt_index');

                    } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                        preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                        $duplicateValue = $matches[1] ?? '';

                        $this->addFlash('error', json_encode([
                            'title' => 'Erreur',
                            'message' => "Le type client '{$duplicateValue}' existe déjà",
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

        return $this->render('type_clt/index.html.twig', [
            'type_clts' => $typeClts,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'typeCltToEdit' => $typeCltToEdit,
        ]);
    }

    #[Route('/new', name: 'app_type_clt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeClt = new TypeClt();
        $form = $this->createForm(TypeCltType::class, $typeClt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($typeClt);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Type client créé avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_type_clt_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le type client '{$duplicateValue}' existe déjà",
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

        return $this->render('type_clt/new.html.twig', [
            'type_clt' => $typeClt,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqtypeclt}', name: 'app_type_clt_show', methods: ['GET'])]
    public function show(TypeClt $typeClt): Response
    {
        return $this->render('type_clt/show.html.twig', [
            'type_clt' => $typeClt,
        ]);
    }

    #[Route('/{seqtypeclt}/edit', name: 'app_type_clt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeClt $typeClt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeCltType::class, $typeClt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Type client mis à jour avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_type_clt_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le type client '{$duplicateValue}' existe déjà",
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

        return $this->render('type_clt/edit.html.twig', [
            'type_clt' => $typeClt,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{seqtypeclt}', name: 'app_type_clt_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        TypeClt $typeClt,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete'.$typeClt->getSeqtypeclt(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_type_clt_index');
        }

        try {
            $entityManager->remove($typeClt);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type client supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_type_clt_index')
                ]);
            }

            $this->addFlash('success', json_encode([
                'title' => 'Succès',
                'message' => 'Type client supprimé avec succès.',
                'type' => 'success'
            ]));
        } catch (\Exception $e) {
            $errorMessage = 'Une erreur est survenue lors de la suppression du type client.';

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

        return $this->redirectToRoute('app_type_clt_index');
    }
}