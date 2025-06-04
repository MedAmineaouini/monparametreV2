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
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
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
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
