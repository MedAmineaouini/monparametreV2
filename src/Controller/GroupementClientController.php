<?php

namespace App\Controller;

use App\Entity\GroupementClient;
use App\Form\GroupementClientType;
use App\Repository\GroupementClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groupementclient')]
class GroupementClientController extends AbstractController
{
    #[Route('/', name: 'app_groupement_client_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        GroupementClientRepository $groupementClientRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $groupementClients = $groupementClientRepository->findAll();

        // Formulaire d'ajout
        $newGroupement = new GroupementClient();
        $addForm = $this->createForm(GroupementClientType::class, $newGroupement);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            try {
                $entityManager->persist($newGroupement);
                $entityManager->flush();

                $this->addFlash('success', json_encode([
                    'title' => 'Succès',
                    'message' => 'Groupement client ajouté avec succès.',
                    'type' => 'success'
                ]));
                return $this->redirectToRoute('app_groupement_client_index');

            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                $duplicateValue = $matches[1] ?? '';

                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => "Le groupement '{$duplicateValue}' existe déjà",
                    'type' => 'error'
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', json_encode([
                    'title' => 'Erreur',
                    'message' => 'Une erreur est survenue lors de l\'ajout du groupement',
                    'type' => 'error',
                    'debug' => $this->getParameter('kernel.debug') ? $e->getMessage() : null
                ]));
            }
        }

        // Formulaire d'édition si ?edit=id est présent
        $editId = $request->query->get('edit');
        $groupementToEdit = null;
        $editForm = null;

        if ($editId) {
            $groupementToEdit = $groupementClientRepository->find($editId);
            if ($groupementToEdit) {
                $editForm = $this->createForm(GroupementClientType::class, $groupementToEdit);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    try {
                        $entityManager->flush();

                        $this->addFlash('success', json_encode([
                            'title' => 'Succès',
                            'message' => 'Groupement client modifié avec succès.',
                            'type' => 'success'
                        ]));
                        return $this->redirectToRoute('app_groupement_client_index');

                    } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                        preg_match("/The duplicate key value is \((.*?)\)/", $e->getMessage(), $matches);
                        $duplicateValue = $matches[1] ?? '';

                        $this->addFlash('error', json_encode([
                            'title' => 'Erreur',
                            'message' => "Le groupement '{$duplicateValue}' existe déjà",
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

        return $this->render('groupement_client/index.html.twig', [
            'groupement_clients' => $groupementClients,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'groupementToEdit' => $groupementToEdit,
        ]);
    }

    #[Route('/new', name: 'app_groupement_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupementClient = new GroupementClient();
        $form = $this->createForm(GroupementClientType::class, $groupementClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($groupementClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_groupement_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupement_client/new.html.twig', [
            'groupement_client' => $groupementClient,
            'form' => $form,
        ]);
    }

    #[Route('/{seqgroupementclient}', name: 'app_groupement_client_show', methods: ['GET'])]
    public function show(GroupementClient $groupementClient): Response
    {
        return $this->render('groupement_client/show.html.twig', [
            'groupement_client' => $groupementClient,
        ]);
    }

    #[Route('/{seqgroupementclient}/edit', name: 'app_groupement_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GroupementClient $groupementClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupementClientType::class, $groupementClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_groupement_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupement_client/edit.html.twig', [
            'groupement_client' => $groupementClient,
            'form' => $form,
        ]);
    }

    #[Route('/{seqgroupementclient}', name: 'app_groupement_client_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        GroupementClient $groupementClient,
        EntityManagerInterface $entityManager
    ): Response {
        // Vérification du token CSRF
        if (!$this->isCsrfTokenValid('delete' . $groupementClient->getSeqgroupementclient(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_groupement_client_index');
        }

        try {
            // Suppression de l'entité
            $entityManager->remove($groupementClient);
            $entityManager->flush();

            // Réponse pour les requêtes AJAX
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Groupement client supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_groupement_client_index')
                ]);
            }

            // Réponse standard
            $this->addFlash('success', 'Groupement client supprimé avec succès.');
        } catch (\Exception $e) {
            // Gestion des erreurs
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du groupement client.',
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

        return $this->redirectToRoute('app_groupement_client_index');
    }

}
