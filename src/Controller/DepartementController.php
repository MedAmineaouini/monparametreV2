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
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departement')]
class DepartementController extends AbstractController
{
    #[Route('/', name: 'app_departement_index', methods: ['GET', 'POST'])]
    public function index(
        DepartementRepository $departementRepository,
        RegionRepository $regionRepository,
        CommercialRepository $commercialRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Récupérer tous les départements avec leurs relations
        $departements = $departementRepository->findAllWithRelations();

        // Gestion de la modification
        $editId = $request->query->get('edit');
        $editForm = null;
        $departementToEdit = null;

        if ($editId) {
            $departementToEdit = $departementRepository->find($editId);

            if ($departementToEdit) {
                $editForm = $this->createForm(DepartementType::class, $departementToEdit, [
                    'regions' => $regionRepository->findAll(),
                    'commercials' => $commercialRepository->findAll()
                ]);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $em->flush();
                    return $this->redirectToRoute('app_departement_index');
                }
            }
        }

        // Formulaire d'ajout
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement, [
            'regions' => $regionRepository->findAll(),
            'commercials' => $commercialRepository->findAll()
        ]);

        // Ne traite le formulaire d'ajout que si on n'est pas en mode édition
        if (!$editId) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($departement);
                $em->flush();
                return $this->redirectToRoute('app_departement_index');
            }
        }

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
            'form' => $form->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'departementToEdit' => $departementToEdit,
        ]);
    }

    #[Route('/departement/{seqdepartement}', name: 'app_departement_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Departement $departement,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete' . $departement->getSeqDepartement(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide',
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_departement_index');
        }
    
        try {
            $entityManager->remove($departement);
            $entityManager->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Département supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_departement_index'),
                ]);
            }
    
            $this->addFlash('success', 'Le département a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du département.',
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
    
        return $this->redirectToRoute('app_departement_index');
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

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="departements.pdf"');

        return $response;
    }
}