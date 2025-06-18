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
    public function index(TypeAssurRepository $repo): Response
    {
        $typeAssurs = $repo->findAll();

        // Pour chaque type, on prépare un formulaire d'édition (vue)
        $formsEdit = [];
        foreach ($typeAssurs as $ta) {
            $formsEdit[$ta->getSeqtypeassur()] = $this->createForm(TypeAssurType::class, $ta, [
                'action' => $this->generateUrl('app_type_assur_edit', ['seqtypeassur' => $ta->getSeqtypeassur()]),
                'method' => 'POST',
            ])->createView();
        }

        // Formulaire d'ajout (nouveau)
        $formNew = $this->createForm(TypeAssurType::class, null, [
            'action' => $this->generateUrl('app_type_assur_new'),
            'method' => 'POST',
        ]);

        return $this->render('type_assur/index.html.twig', [
            'type_assurs' => $typeAssurs,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_type_assur_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $typeAssur = new TypeAssur();
        $form = $this->createForm(TypeAssurType::class, $typeAssur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($typeAssur);
            $em->flush();

            $this->addFlash('success', 'Type d\'assurance ajouté avec succès.');

            return $this->redirectToRoute('app_type_assur_index');
        }

        $this->addFlash('error', 'Erreur lors de l\'ajout du type d\'assurance.');
        return $this->redirectToRoute('app_type_assur_index');
    }

    #[Route('/{seqtypeassur}/edit', name: 'app_type_assur_edit', methods: ['POST'])]
    public function edit(Request $request, TypeAssur $typeAssur, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypeAssurType::class, $typeAssur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Type d\'assurance modifié avec succès.');

            return $this->redirectToRoute('app_type_assur_index');
        }

        $this->addFlash('error', 'Erreur lors de la modification du type d\'assurance.');
        return $this->redirectToRoute('app_type_assur_index');
    }

    #[Route('/{seqtypeassur}/delete', name: 'app_type_assur_delete', methods: ['POST'])]
    public function delete(Request $request, TypeAssur $typeAssur, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeAssur->getSeqtypeassur(), $request->request->get('_token'))) {
            $em->remove($typeAssur);
            $em->flush();
            $this->addFlash('success', 'Type d\'assurance supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('app_type_assur_index');
    }
}
