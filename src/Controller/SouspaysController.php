<?php

namespace App\Controller;

use App\Entity\Souspays;
use App\Form\SouspaysType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/souspays')]
class SouspaysController extends AbstractController
{
    #[Route('/', name: 'app_souspays_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $souspays = $entityManager
            ->getRepository(Souspays::class)
            ->findAll();

        return $this->render('souspays/index.html.twig', [
            'souspays' => $souspays,
        ]);
    }

    #[Route('/new', name: 'app_souspays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $souspay = new Souspays();
        $form = $this->createForm(SouspaysType::class, $souspay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($souspay);
            $entityManager->flush();

            return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souspays/new.html.twig', [
            'souspay' => $souspay,
            'form' => $form,
        ]);
    }

    #[Route('/{seqsouspays}', name: 'app_souspays_show', methods: ['GET'])]
    public function show(Souspays $souspay): Response
    {
        return $this->render('souspays/show.html.twig', [
            'souspay' => $souspay,
        ]);
    }

    #[Route('/{seqsouspays}/edit', name: 'app_souspays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souspays $souspay, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SouspaysType::class, $souspay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souspays/edit.html.twig', [
            'souspay' => $souspay,
            'form' => $form,
        ]);
    }

    #[Route('/{seqsouspays}', name: 'app_souspays_delete', methods: ['POST'])]
    public function delete(Request $request, Souspays $souspay, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$souspay->getSeqsouspays(), $request->request->get('_token'))) {
            $entityManager->remove($souspay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_souspays_index', [], Response::HTTP_SEE_OTHER);
    }
}
