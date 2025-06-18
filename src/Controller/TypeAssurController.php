<?php

namespace App\Controller;

use App\Entity\TypeAssur;
use App\Form\TypeAssurType;
use App\Repository\TypeAssurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeassur')]
class TypeAssurController extends AbstractController
{
    #[Route('/', name: 'app_type_assur_index', methods: ['GET'])]
    public function index(TypeAssurRepository $typeAssurRepository): Response
    {
        return $this->render('type_assur/index.html.twig', [
            'type_assurs' => $typeAssurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_assur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeAssur = new TypeAssur();
        $form = $this->createForm(TypeAssurType::class, $typeAssur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeAssur);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_assur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_assur/new.html.twig', [
            'type_assur' => $typeAssur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqtypeassur}', name: 'app_type_assur_show', methods: ['GET'])]
    public function show(TypeAssur $typeAssur): Response
    {
        return $this->render('type_assur/show.html.twig', [
            'type_assur' => $typeAssur,
        ]);
    }

    #[Route('/{seqtypeassur}/edit', name: 'app_type_assur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeAssur $typeAssur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeAssurType::class, $typeAssur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_assur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_assur/edit.html.twig', [
            'type_assur' => $typeAssur,
            'form' => $form,
        ]);
    }

    #[Route('/{seqtypeassur}', name: 'app_type_assur_delete', methods: ['POST'])]
    public function delete(Request $request, TypeAssur $typeAssur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeAssur->getSeqtypeassur(), $request->request->get('_token'))) {
            $entityManager->remove($typeAssur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_assur_index', [], Response::HTTP_SEE_OTHER);
    }
}
