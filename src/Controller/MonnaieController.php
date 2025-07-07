<?php

namespace App\Controller;

use App\Entity\Monnaie;
use App\Form\MonnaieType;
use App\Repository\MonnaieRepository;
use App\Repository\PaysRepository; // 🔄 ajouter le repository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/monnaie')]
class MonnaieController extends AbstractController
{
    #[Route('/', name: 'app_monnaie_index', methods: ['GET', 'POST'])]
    public function index(
        MonnaieRepository $monnaieRepository,
        Request $request,
        EntityManagerInterface $em,
        PaysRepository $paysRepository
    ): Response {
        $monnaies = $monnaieRepository->findAll();

        $editForm = null;
        $monnaieToEdit = null;

        $editId = $request->query->get('edit');

        // S'il y a un ID à éditer
        if ($editId) {
            $monnaieToEdit = $monnaieRepository->find($editId);

            if ($monnaieToEdit) {
                $editForm = $this->createForm(MonnaieType::class, $monnaieToEdit);
                $editForm->get('codepays')->setData(
                    $monnaieToEdit->getPays() ? $monnaieToEdit->getPays()->getCODEPAYS() : ''
                );

                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_monnaie_index');
                }
            }
        }

        // Création uniquement si on n'est PAS en mode édition
        $form = null;
        if (!$editId) {
            $monnaie = new Monnaie();
            $formObj = $this->createForm(MonnaieType::class, $monnaie);
            $formObj->handleRequest($request);

            if ($formObj->isSubmitted() && $formObj->isValid()) {
                $em->persist($monnaie);
                $em->flush();
                return $this->redirectToRoute('app_monnaie_index');
            }

            $form = $formObj->createView();
        }

        return $this->render('monnaie/index.html.twig', [
            'monnaies' => $monnaies,
            'form' => $form, // null si on est en mode édition
            'editForm' => $editForm ? $editForm->createView() : null,
            'monnaieToEdit' => $monnaieToEdit,
        ]);
    }

    #[Route('/{seqmonnaie}/edit', name: 'app_monnaie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Monnaie $monnaie, EntityManagerInterface $em, PaysRepository $paysRepository): Response
    {
        $form = $this->createForm(MonnaieType::class, $monnaie);

        // 🔄 pré-remplir "codepays"
        $form->get('codepays')->setData(
            $monnaie->getPays() ? $monnaie->getPays()->getCODEPAYS() : ''
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_monnaie_index');
        }

        return $this->renderForm('monnaie/edit.html.twig', [
            'monnaie' => $monnaie,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_monnaie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $monnaie = new Monnaie();
        $form = $this->createForm(MonnaieType::class, $monnaie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monnaie);
            $entityManager->flush();

            return $this->redirectToRoute('app_monnaie_index');
        }

        return $this->renderForm('monnaie/new.html.twig', [
            'monnaie' => $monnaie,
            'form' => $form,
        ]);
    }

    #[Route('/get-libpays', name: 'get_libpays_by_code', methods: ['GET'])]
public function getLibpaysByCode(Request $request, PaysRepository $paysRepository): Response
{
    $code = strtoupper($request->query->get('codepays'));

    $pays = $paysRepository->findOneBy(['CODEPAYS' => $code]);

    if (!$pays) {
        return $this->json(['success' => false, 'message' => 'Code pays invalide.'], 404);
    }

    return $this->json([
        'success' => true,
        'libpays' => $pays->getLIBPAYS()
    ]);
}


    #[Route('/{seqmonnaie}', name: 'app_monnaie_show', methods: ['GET'])]
    public function show(Monnaie $monnaie): Response
    {
        return $this->render('monnaie/show.html.twig', [
            'monnaie' => $monnaie,
        ]);
    }

    #[Route('/{seqmonnaie}', name: 'app_monnaie_delete', methods: ['POST'])]
    public function delete(Request $request, Monnaie $monnaie, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $monnaie->getSeqmonnaie(), $request->request->get('_token'))) {
            return $this->redirectToRoute('app_monnaie_index');
        }

        $entityManager->remove($monnaie);
        $entityManager->flush();

        return $this->redirectToRoute('app_monnaie_index');
    }
}
