<?php

namespace App\Controller;

use App\Entity\PensionOrchestra;
use App\Form\PensionOrchestraType;
use App\Repository\PensionOrchestraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pension_orchestra')]
class PensionOrchestraController extends AbstractController
{
    #[Route('/', name: 'app_pension_orchestra_index', methods: ['GET'])]
    public function index(PensionOrchestraRepository $repo): Response
    {
        $pensionOrchestras = $repo->findAll();

        $formsEdit = [];
        foreach ($pensionOrchestras as $pensionOrchestra) {
            $formsEdit[$pensionOrchestra->getSeqPensionOrchestra()] = $this->createForm(PensionOrchestraType::class, $pensionOrchestra, [
                'action' => $this->generateUrl('app_pension_orchestra_edit', ['seqPensionOrchestra' => $pensionOrchestra->getSeqPensionOrchestra()]),
                'method' => 'POST',
            ])->createView();
        }

        $formNew = $this->createForm(PensionOrchestraType::class, new PensionOrchestra(), [
            'action' => $this->generateUrl('app_pension_orchestra_new'),
            'method' => 'POST',
        ]);

        return $this->render('pension_orchestra/index.html.twig', [
            'pension_orchestras' => $pensionOrchestras,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_pension_orchestra_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $pensionOrchestra = new PensionOrchestra();
        $form = $this->createForm(PensionOrchestraType::class, $pensionOrchestra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pensionOrchestra);
            $em->flush();

            $this->addFlash('success', 'Pension Orchestra ajouté avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de l\'ajout du Pension Orchestra.');
        }

        return $this->redirectToRoute('app_pension_orchestra_index');
    }

    #[Route('/{seqPensionOrchestra}/edit', name: 'app_pension_orchestra_edit', methods: ['POST'])]
    public function edit(Request $request, PensionOrchestra $pensionOrchestra, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PensionOrchestraType::class, $pensionOrchestra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Pension Orchestra modifié avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la modification du Pension Orchestra.');
        }

        return $this->redirectToRoute('app_pension_orchestra_index');
    }

    #[Route('/{seqPensionOrchestra}/delete', name: 'app_pension_orchestra_delete', methods: ['POST'])]
    public function delete(Request $request, PensionOrchestra $pensionOrchestra, EntityManagerInterface $em): Response
    {
        $csrfTokenId = 'delete' . $pensionOrchestra->getSeqPensionOrchestra();

        if (!$this->isCsrfTokenValid($csrfTokenId, $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Jeton CSRF invalide.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_pension_orchestra_index');
        }

        try {
            $em->remove($pensionOrchestra);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Pension Orchestra supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_pension_orchestra_index'),
                ]);
            }

            $this->addFlash('success', 'Pension Orchestra supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du Pension Orchestra.',
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

        return $this->redirectToRoute('app_pension_orchestra_index');
    }
}
