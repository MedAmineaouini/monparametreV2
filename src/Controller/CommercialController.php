<?php

namespace App\Controller;

use App\Entity\Commercial;
use App\Form\CommercialType;
use App\Repository\CommercialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commercial')]
class CommercialController extends AbstractController
{
    #[Route('/', name: 'app_commercial_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        CommercialRepository $commercialRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $commercial = new Commercial();
        $form = $this->createForm(CommercialType::class, $commercial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commercial);
            $entityManager->flush();

            $this->addFlash('success', 'Le commercial a été ajouté avec succès.');
            return $this->redirectToRoute('app_commercial_index');
        }

        $commercials = $commercialRepository->findAll();

        return $this->render('commercial/index.html.twig', [
            'commercials' => $commercials,
            'form' => $form->createView(),
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
    public function edit(
        Request $request,
        Commercial $commercial,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CommercialType::class, $commercial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le commercial a été modifié avec succès.');

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['success' => true]);
            }

            return $this->redirectToRoute('app_commercial_index');
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('commercial/_edit_modal.html.twig', [
                'commercial' => $commercial,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('commercial/edit.html.twig', [
            'commercial' => $commercial,
            'form' => $form->createView(),
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
