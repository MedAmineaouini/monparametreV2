<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/region')]
class RegionController extends AbstractController
{
    #[Route('/', name: 'app_region_index', methods: ['GET'])]
    public function index(RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findAll();

        // Formulaires d'édition inline
        $formsEdit = [];
        foreach ($regions as $region) {
            $formsEdit[$region->getSeqregion()] = $this->createForm(RegionType::class, $region, [
                'action' => $this->generateUrl('app_region_edit', ['seqregion' => $region->getSeqregion()]),
                'method' => 'POST',
            ])->createView();
        }

        // Formulaire d'ajout
        $formNew = $this->createForm(RegionType::class, null, [
            'action' => $this->generateUrl('app_region_new'),
            'method' => 'POST',
        ]);

        return $this->render('region/index.html.twig', [
            'regions' => $regions,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_region_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $region = new Region();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($region);
            $em->flush();

            $this->addFlash('success', 'Région ajoutée avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de l\'ajout de la région.');
        }

        return $this->redirectToRoute('app_region_index');
    }

    #[Route('/{seqregion}/edit', name: 'app_region_edit', methods: ['POST'])]
    public function edit(Request $request, Region $region, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Région modifiée avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la modification de la région.');
        }

        return $this->redirectToRoute('app_region_index');
    }

    #[Route('/{seqregion}', name: 'app_region_delete', methods: ['POST'])]
    public function delete(Request $request, Region $region, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $region->getSeqregion(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_region_index');
        }
    
        try {
            $entityManager->remove($region);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Région supprimée avec succès.',
                    'redirect' => $this->generateUrl('app_region_index')
                ]);
            }
    
            $this->addFlash('success', 'La région a été supprimée avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression de la région.',
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
    
        return $this->redirectToRoute('app_region_index');
    }
    
}
