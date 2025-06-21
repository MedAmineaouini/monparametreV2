<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{

        #[Route('/', name: 'app_utilisateur_index', methods: ['GET', 'POST'])]
        public function index(
            Request $request,
            UtilisateurRepository $utilisateurRepository,
            EntityManagerInterface $entityManager,
            UserPasswordHasherInterface $passwordHasher
        ): Response {
            $utilisateurs = $utilisateurRepository->findAll();
    
            // === Formulaire d'ajout ===
            $newUtilisateur = new Utilisateur();
            $addForm = $this->createForm(UtilisateurType::class, $newUtilisateur);
            $addForm->handleRequest($request);
    
            if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
                if ($newUtilisateur->getMDP()) {
                    $hashed = $passwordHasher->hashPassword($newUtilisateur, $newUtilisateur->getMDP());
                    $newUtilisateur->setMDP($hashed);
                }
    
                if ($newUtilisateur->getWEBMDP()) {
                    $hashedWeb = $passwordHasher->hashPassword($newUtilisateur, $newUtilisateur->getWEBMDP());
                    $newUtilisateur->setWEBMDP($hashedWeb);
                }
    
                $entityManager->persist($newUtilisateur);
                $entityManager->flush();
    
                $this->addFlash('success', 'Utilisateur ajouté avec succès.');
                return $this->redirectToRoute('app_utilisateur_index');
            }
    
            // === Formulaire de modification ===
            $editId = $request->query->get('edit');
            $utilisateurToEdit = null;
            $editForm = null;
    
            if ($editId) {
                $utilisateurToEdit = $utilisateurRepository->find($editId);
    
                if ($utilisateurToEdit) {
                    $ancienMDP = $utilisateurToEdit->getMDP();
                    $ancienWEBMDP = $utilisateurToEdit->getWEBMDP();
    
                    $editForm = $this->createForm(UtilisateurType::class, $utilisateurToEdit);
                    $editForm->handleRequest($request);
    
                    if ($editForm->isSubmitted() && $editForm->isValid()) {
                        if ($utilisateurToEdit->getMDP()) {
                            $hashed = $passwordHasher->hashPassword($utilisateurToEdit, $utilisateurToEdit->getMDP());
                            $utilisateurToEdit->setMDP($hashed);
                        } else {
                            $utilisateurToEdit->setMDP($ancienMDP);
                        }
    
                        if ($utilisateurToEdit->getWEBMDP()) {
                            $hashedWeb = $passwordHasher->hashPassword($utilisateurToEdit, $utilisateurToEdit->getWEBMDP());
                            $utilisateurToEdit->setWEBMDP($hashedWeb);
                        } else {
                            $utilisateurToEdit->setWEBMDP($ancienWEBMDP);
                        }
    
                        $entityManager->flush();
                        $this->addFlash('success', 'Utilisateur modifié avec succès.');
                        return $this->redirectToRoute('app_utilisateur_index');
                    }
                }
            }
    
            return $this->render('utilisateur/index.html.twig', [
                'utilisateurs' => $utilisateurs,
                'addForm' => $addForm->createView(),
                'editForm' => $editForm ? $editForm->createView() : null,
                'utilisateurToEdit' => $utilisateurToEdit,
            ]);
        }
    

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($utilisateur->getMDP()) {
                $hashed = $passwordHasher->hashPassword($utilisateur, $utilisateur->getMDP());
                $utilisateur->setMDP($hashed);
            }

            if ($utilisateur->getWEBMDP()) {
                $hashedWeb = $passwordHasher->hashPassword($utilisateur, $utilisateur->getWEBMDP());
                $utilisateur->setWEBMDP($hashedWeb);
            }

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index');
        }

        return $this->renderForm('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }


    #[Route('/{SEQUTIL}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{SEQUTIL}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $ancienMDP = $utilisateur->getMDP();
        $ancienWEBMDP = $utilisateur->getWEBMDP();

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($utilisateur->getMDP()) {
                $hashed = $passwordHasher->hashPassword($utilisateur, $utilisateur->getMDP());
                $utilisateur->setMDP($hashed);
            } else {
                $utilisateur->setMDP($ancienMDP); // garde l'ancien si vide
            }

            if ($utilisateur->getWEBMDP()) {
                $hashedWeb = $passwordHasher->hashPassword($utilisateur, $utilisateur->getWEBMDP());
                $utilisateur->setWEBMDP($hashedWeb);
            } else {
                $utilisateur->setWEBMDP($ancienWEBMDP); // garde l'ancien si vide
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index');
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }



    #[Route('/{SEQUTIL}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getSEQUTIL(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($utilisateur);
                $entityManager->flush();
                
                return $this->json([
                    'success' => true,
                    'message' => 'L\'utilisateur a été supprimé avec succès'
                ]);
                
            } catch (\Exception $e) {
                return $this->json([
                    'success' => false,
                    'message' => 'Échec de la suppression : ' . $e->getMessage(),
                    'reference' => $utilisateur->getSEQUTIL()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        return $this->json([
            'success' => false,
            'message' => 'Token CSRF invalide'
        ], Response::HTTP_BAD_REQUEST);
    }
}
