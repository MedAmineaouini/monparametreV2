<?php

namespace App\Controller;

use App\Entity\Typeprod;
use App\Form\TypeprodType;
use App\Repository\TypeprodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeprod')]
class TypeprodController extends AbstractController
{
    #[Route('/', name: 'app_typeprod_index', methods: ['GET'])]
    public function index(TypeprodRepository $repo): Response
    {
        $typeprods = $repo->findAll();

        // Formulaires d'édition inline
        $formsEdit = [];
        foreach ($typeprods as $tp) {
            $formsEdit[$tp->getSEQTYPEPROD()] = $this->createForm(TypeprodType::class, $tp, [
                'action' => $this->generateUrl('app_typeprod_edit', ['SEQTYPEPROD' => $tp->getSEQTYPEPROD()]),
                'method' => 'POST',
            ])->createView();
        }

        // Formulaire d'ajout
        $formNew = $this->createForm(TypeprodType::class, null, [
            'action' => $this->generateUrl('app_typeprod_new'),
            'method' => 'POST',
        ]);

        return $this->render('typeprod/index.html.twig', [
            'typeprods' => $typeprods,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_typeprod_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $typeprod = new Typeprod();
        $form = $this->createForm(TypeprodType::class, $typeprod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($typeprod);
            $em->flush();

            $this->addFlash('success', 'Type de produit ajouté avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de l\'ajout du type de produit.');
        }

        return $this->redirectToRoute('app_typeprod_index');
    }

    #[Route('/{SEQTYPEPROD}/edit', name: 'app_typeprod_edit', methods: ['POST'])]
    public function edit(Request $request, Typeprod $typeprod, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypeprodType::class, $typeprod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Type de produit modifié avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la modification du type de produit.');
        }

        return $this->redirectToRoute('app_typeprod_index');
    }

    #[Route('/{SEQTYPEPROD}/delete', name: 'app_typeprod_delete', methods: ['POST'])]
    public function delete(Request $request, Typeprod $typeprod, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $typeprod->getSEQTYPEPROD(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Jeton CSRF invalide.',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_typeprod_index');
        }
    
        try {
            $em->remove($typeprod);
            $em->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type de produit supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_typeprod_index'),
                ]);
            }
    
            $this->addFlash('success', 'Type de produit supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de produit.',
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
    
        return $this->redirectToRoute('app_typeprod_index');
    }
    
}
