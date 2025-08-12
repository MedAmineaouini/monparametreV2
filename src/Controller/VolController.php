<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Form\VolType;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VilleRepository;
use App\Entity\Ville;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vol')]
class VolController extends AbstractController
{
    #[Route('/', name: 'app_vol_index', methods: ['GET'])]
    public function index(VolRepository $volRepository): Response
    {
        return $this->render('vol/index.html.twig', [
            'vols' => $volRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository): Response
    {
        $vol = new Vol();

        $lastSeq = $entityManager->createQueryBuilder()
            ->select('MAX(v.seqvol)')
            ->from(Vol::class, 'v')
            ->getQuery()
            ->getSingleScalarResult();

        $nextSeq = $lastSeq ? ((int) $lastSeq + 1) : 1;
        $vol->setSeqvol($nextSeq);
        $formattedSeqvol = str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

        $aerodep = $vol->getVilleD() ? $vol->getVilleD()->getAero() : '';
        $aeroarr = $vol->getVilleA() ? $vol->getVilleA()->getAero() : '';

        $form = $this->createForm(VolType::class, $vol, [
            'seqvol_value' => $formattedSeqvol,
            'aerodep_value' => $aerodep,
            'aeroarr_value' => $aeroarr,
        ]);

        // $dispoValue = ($vol->getOuvert() ?? 0) - ($vol->getReserve() ?? 0) - ($vol->getVendu() ?? 0);
        // $form->get('dispo')->setData(max(0, $dispoValue));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $dispoValue = ($vol->getOuvert() ?? 0) - ($vol->getReserve() ?? 0) - ($vol->getVendu() ?? 0);
            // $form->get('dispo')->setData(max(0, $dispoValue));

            // if ($vol->getVilleD()) {
            //     $vol->setAerodep($vol->getVilleD()->getAero());
            // }
            // if ($vol->getVilleA()) {
            //     $vol->setAeroarr($vol->getVilleA()->getAero());
            // }

            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form,
            'villes' => $villeRepository->findAll(),
        ]);
    }




    #[Route('/{seqvol}', name: 'app_vol_show', methods: ['GET'])]
    public function show(Vol $vol): Response
    {
        return $this->render('vol/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    #[Route('/{seqvol}/edit', name: 'app_vol_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager, VilleRepository $villeRepository): Response
    {
        $formattedSeqvol = str_pad($vol->getSeqvol(), 4, '0', STR_PAD_LEFT);
        $aerodep = $vol->getVilleD() ? $vol->getVilleD()->getAero() : '';
        $aeroarr = $vol->getVilleA() ? $vol->getVilleA()->getAero() : '';

        $form = $this->createForm(VolType::class, $vol, [
            'seqvol_value' => $formattedSeqvol,
            'aerodep_value' => $aerodep,
            'aeroarr_value' => $aeroarr,
        ]);

        // $dispoValue = ($vol->getOuvert() ?? 0) - ($vol->getReserve() ?? 0) - ($vol->getVendu() ?? 0);
        // $form->get('dispo')->setData(max(0, $dispoValue));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($vol->getVilleD()) {
                $vol->setAerodep($vol->getVilleD()->getAero());
            }
            if ($vol->getVilleA()) {
                $vol->setAeroarr($vol->getVilleA()->getAero());
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form,
            'villes' => $villeRepository->findAll(),
        ]);
    }

    #[Route('/{seqvol}', name: 'app_vol_delete', methods: ['POST'])]
    public function delete(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $vol->getSeqvol(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_vol_index');
        }
    
        try {
            $entityManager->remove($vol);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Vol supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_vol_index'),
                ]);
            }
    
            $this->addFlash('success', 'Le vol a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du vol.',
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
    
        return $this->redirectToRoute('app_vol_index');
    }

    #[Route('/get-aeroport/{ville}', name: 'get_aeroport', methods: ['GET'])]
    public function getAeroport(Ville $ville): JsonResponse
    {
        return $this->json([
            'aeroport' => $ville->getAero()
        ]);
    }
    
}
