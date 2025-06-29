<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Souspays;
use App\Entity\Ville;
use App\Form\PaysType;
use Dompdf\Dompdf;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pays')]
class PaysController extends AbstractController
{

    #[Route('/', name: 'app_pays_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        PaysRepository $paysRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des pays
        $pays = $paysRepository->findAll();
    
        // === Formulaire d'ajout ===
        $newPays = new Pays();
        $addForm = $this->createForm(PaysType::class, $newPays);
        $addForm->handleRequest($request);
    
        if ($addForm->isSubmitted() && $addForm->isValid() && !$request->query->get('edit')) {
            $entityManager->persist($newPays);
            $entityManager->flush();
            $this->addFlash('success', 'Le pays a été ajouté avec succès.');
            return $this->redirectToRoute('app_pays_index');
        }
    
        // === Formulaire de modification ===
        $editId = $request->query->get('edit');
        $paysToEdit = null;
        $editForm = null;
    
        if ($editId) {
            $paysToEdit = $paysRepository->find($editId);
    
            if ($paysToEdit) {
                $editForm = $this->createForm(PaysType::class, $paysToEdit);
                $editForm->handleRequest($request);
    
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Le pays a été modifié avec succès.');
                    return $this->redirectToRoute('app_pays_index');
                }
            }
        }
    
        return $this->render('pays/index.html.twig', [
            'pays' => $pays,
            'addForm' => $addForm->createView(),
            'editForm' => $editForm ? $editForm->createView() : null,
            'paysToEdit' => $paysToEdit,
        ]);
    }

    #[Route('/new', name: 'app_pays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pay = new Pays();
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pay);
            $entityManager->flush();

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/new.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{IDPAYS}', name: 'app_pays_show', methods: ['GET'])]
    public function show(Pays $pay): Response
    {
        return $this->render('pays/show.html.twig', [
            'pay' => $pay,
        ]);
    }

    #[Route('/{IDPAYS}/edit', name: 'app_pays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pays $pay, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays/edit.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }
    #[Route('/{IDPAYS}', name: 'app_pays_delete', methods: ['POST'])]
    public function delete(
        Request $request, 
        Pays $pay,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete'.$pay->getIDPAYS(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token CSRF invalide'
                ], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_pays_index');
        }
    
        try {
            $dependencies = [];
            
            $villeCount = $entityManager->getRepository(Ville::class)
                ->createQueryBuilder('v')
                ->select('COUNT(v.seqville)')
                ->where('v.pays = :pays')
                ->setParameter('pays', $pay)
                ->getQuery()
                ->getSingleScalarResult();
                
            if ($villeCount > 0) {
                $dependencies[] = 'Villes ';
            }
            
            $sousPaysCount = $entityManager->getRepository(SousPays::class)
                ->createQueryBuilder('sp')
                ->select('COUNT(sp.seqsouspays)')
                ->where('sp.pays = :pays')
                ->setParameter('pays', $pay)
                ->getQuery()
                ->getSingleScalarResult();
                
            if ($sousPaysCount > 0) {
                $dependencies[] = 'Sous-pays ';
            }
    
            if (!empty($dependencies)) {
                $message = 'Impossible de supprimer ce pays car il est utilisé dans : ';
                $message .= implode(' et ', $dependencies);
                
                if ($request->isXmlHttpRequest()) {
                    return $this->json([
                        'success' => false,
                        'message' => $message,
                        'relations' => $dependencies
                    ], Response::HTTP_CONFLICT);
                }
                
                $this->addFlash('error', $message);
                return $this->redirectToRoute('app_pays_index');
            }
    
            // Suppression
            $entityManager->remove($pay);
            $entityManager->flush();
            
            // Réponse
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Pays supprimé avec succès',
                    'redirect' => $this->generateUrl('app_pays_index')
                ]);
            }
            
            $this->addFlash('success', 'Le pays a été supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du pays',
                'details' => $this->getParameter('kernel.debug') ? [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ];
    
            if ($request->isXmlHttpRequest()) {
                return $this->json($errorData, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $this->addFlash('error', $errorData['message']);
        }
    
        return $this->redirectToRoute('app_pays_index');
    }

    #[Route('/export/pdf', name: 'app_pays_export_pdf', methods: ['GET'])]
public function exportPdf(PaysRepository $paysRepository): Response
{
    $pays = $paysRepository->findAll();

    $html = $this->renderView('pays/export_pdf.html.twig', [
        'pays' => $pays,
        'title' => 'Liste des pays'
    ]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $response = new Response($dompdf->output());
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment;filename="liste_pays.pdf"');

    return $response;
}
}
