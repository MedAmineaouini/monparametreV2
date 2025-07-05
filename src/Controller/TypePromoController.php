<?php

namespace App\Controller;

use App\Entity\TypePromo;
use App\Form\TypePromoType;
use App\Repository\TypePromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type-promo')]
class TypePromoController extends AbstractController
{
    #[Route('/', name: 'app_type_promo_index', methods: ['GET'])]
    public function index(TypePromoRepository $repo): Response
    {
        $promos = $repo->findAll();

        $formsEdit = [];
        foreach ($promos as $promo) {
            $formsEdit[$promo->getSeqTypePromo()] = $this->createForm(TypePromoType::class, $promo, [
                'action' => $this->generateUrl('app_type_promo_edit', ['seqTypePromo' => $promo->getSeqTypePromo()]),
                'method' => 'POST',
            ])->createView();
        }

        $formNew = $this->createForm(TypePromoType::class, new TypePromo(), [
            'action' => $this->generateUrl('app_type_promo_new'),
            'method' => 'POST',
        ]);

        return $this->render('type_promo/index.html.twig', [
            'type_promos' => $promos,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_type_promo_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $promo = new TypePromo();
        $form = $this->createForm(TypePromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($promo);
            $em->flush();

            $this->addFlash('success', 'Type promo ajouté avec succès.');
        }

        return $this->redirectToRoute('app_type_promo_index');
    }

    #[Route('/{seqTypePromo}/edit', name: 'app_type_promo_edit', methods: ['POST'])]
    public function edit(Request $request, TypePromo $promo, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypePromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Type promo modifié avec succès.');
        }

        return $this->redirectToRoute('app_type_promo_index');
    }

    #[Route('/{seqTypePromo}/delete', name: 'app_type_promo_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        TypePromo $promo,
        EntityManagerInterface $em
    ): Response {
        $csrfTokenId = 'delete' . $promo->getSeqTypePromo();
    
        if (!$this->isCsrfTokenValid($csrfTokenId, $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Jeton CSRF invalide.',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_type_promo_index');
        }
    
        try {
            $em->remove($promo);
            $em->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Type promo supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_type_promo_index')
                ]);
            }
    
            $this->addFlash('success', 'Type promo supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du type promo.',
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
    
        return $this->redirectToRoute('app_type_promo_index');
    }
    
}
