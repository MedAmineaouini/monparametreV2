<?php

namespace App\Controller;

use App\Entity\Commercial;
use App\Form\CommercialType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commercial')]
class CommercialController extends AbstractController
{
    #[Route('/', name: 'app_commercial_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commercials = $entityManager
            ->getRepository(Commercial::class)
            ->findAll();

        return $this->render('commercial/index.html.twig', [
            'commercials' => $commercials,
        ]);
    }

    #[Route('/new', name: 'app_commercial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commercial = new Commercial();
        $form = $this->createForm(CommercialType::class, $commercial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commercial);
            $entityManager->flush();

            return $this->redirectToRoute('app_commercial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commercial/new.html.twig', [
            'commercial' => $commercial,
            'form' => $form,
        ]);
    }

    #[Route('/{seqCommercial}', name: 'app_commercial_show', methods: ['GET'])]
    public function show(Commercial $commercial): Response
    {
        return $this->render('commercial/show.html.twig', [
            'commercial' => $commercial,
        ]);
    }

    #[Route('/{seqCommercial}/edit', name: 'app_commercial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commercial $commercial, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommercialType::class, $commercial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commercial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commercial/edit.html.twig', [
            'commercial' => $commercial,
            'form' => $form,
        ]);
    }

    #[Route('/{seqCommercial}', name: 'app_commercial_delete', methods: ['POST'])]
    public function delete(Request $request, Commercial $commercial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commercial->getSeqCommercial(), $request->request->get('_token'))) {
            $entityManager->remove($commercial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commercial_index', [], Response::HTTP_SEE_OTHER);
    }
}
