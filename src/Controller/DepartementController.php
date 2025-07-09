<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use App\Repository\RegionRepository;
use App\Repository\CommercialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departement')]
class DepartementController extends AbstractController
{
    #[Route('/', name: 'app_departement_index', methods: ['GET', 'POST'])]
    public function index(
        DepartementRepository $departementRepository,
        RegionRepository $regionRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $departements = $departementRepository->findAllWithRelations();
        $departement = new Departement();
        $editId = $request->query->get('edit');
        $editForm = null;
        $departementToEdit = null;

        // Formulaire création
        $form = $this->createForm(DepartementType::class, $departement, [
            'regions' => $regionRepository->findAll(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($departement);
            $em->flush();
            return $this->redirectToRoute('app_departement_index');
        }

        // Formulaire édition
        if ($editId) {
            $departementToEdit = $departementRepository->find($editId);
            if ($departementToEdit) {
                $editForm = $this->createForm(DepartementType::class, $departementToEdit, [
                    'regions' => $regionRepository->findAll(),
                ]);

                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_departement_index');
                }
            }
        }

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'departementToEdit' => $departementToEdit,
        ]);
    }

    #[Route('/fetch-commercial', name: 'app_fetch_commercial_by_code', methods: ['GET'])]
    public function fetchCommercialByCode(Request $request, CommercialRepository $commercialRepository): JsonResponse
    {
        $code = $request->query->get('code');
        
        if (!$code) {
            return $this->json([
                'success' => false,
                'message' => 'Code commercial requis'
            ], Response::HTTP_BAD_REQUEST);
        }

        $commercial = $commercialRepository->findOneBy(['codeCommercial' => $code]);

        if (!$commercial) {
            return $this->json([
                'success' => false,
                'message' => 'Aucun commercial trouvé'
            ]);
        }

        return $this->json([
            'success' => true,
            'nom' => $commercial->getNomCommercial(),
            'code' => $commercial->getCodeCommercial()
        ]);
    }

    #[Route('/{seqdepartement}', name: 'app_departement_delete', methods: ['POST'])]
public function delete(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
{
    $csrfId = 'delete' . $departement->getSeqDepartement();
    $token = $request->request->get('_token');

    if (!$this->isCsrfTokenValid($csrfId, $token)) {
        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'success' => false,
                'message' => 'Token CSRF invalide'
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->addFlash('error', 'Token CSRF invalide');
        return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
    }

    try {
        // À adapter si vous voulez vérifier des dépendances (ex: offres, communes, etc.)
        $dependencies = [];

        $usedIn = array_filter($dependencies, fn($count) => $count > 0);

        if (!empty($usedIn)) {
            $message = 'Ce département ne peut pas être supprimé car il est utilisé dans : ';
            $message .= implode(', ', array_keys($usedIn));
            throw new \Exception($message);
        }

        $entityManager->remove($departement);
        $entityManager->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'success' => true,
                'message' => 'Le département a été supprimé avec succès'
            ]);
        }

        $this->addFlash('success', 'Le département a été supprimé avec succès.');
    } catch (\Exception $e) {
        $errorData = [
            'success' => false,
            'message' => $e->getMessage(),
            'reference' => $departement->getSeqDepartement(),
            'details' => []
        ];

        if ($this->getParameter('kernel.environment') === 'dev') {
            $errorData['details'] = [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ];
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json($errorData, Response::HTTP_CONFLICT);
        }

        $this->addFlash('error', $errorData['message']);
    }

    return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
}

    #[Route('/export/pdf', name: 'app_departement_export_pdf', methods: ['GET'])]
    public function exportPdf(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAllWithRelations();

        $html = $this->renderView('departement/export_pdf.html.twig', [
            'departements' => $departements,
            'title' => 'Liste des départements'
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="departements.pdf"'
            ]
        );
    }
}