<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/niveau')]
class NiveauController extends AbstractController
{
    #[Route('/', name: 'app_niveau_index', methods: ['GET'])]
    public function index(NiveauRepository $repo): Response
    {
        $niveaux = $repo->findAll();

        $formsEdit = [];
        foreach ($niveaux as $niveau) {
            $formsEdit[$niveau->getId()] = $this->createForm(NiveauType::class, $niveau, [
                'action' => $this->generateUrl('app_niveau_edit', ['id' => $niveau->getId()]),
                'method' => 'POST',
            ])->createView();
        }

        $formNew = $this->createForm(NiveauType::class, new Niveau(), [
            'action' => $this->generateUrl('app_niveau_new'),
            'method' => 'POST',
        ]);

        return $this->render('niveau/index.html.twig', [
            'niveaux' => $niveaux,
            'forms_edit' => $formsEdit,
            'form_new' => $formNew->createView(),
        ]);
    }

    #[Route('/new', name: 'app_niveau_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $niveau = new Niveau();
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($niveau);
            $em->flush();

            $this->addFlash('success', 'Niveau ajouté avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de l\'ajout du niveau.');
        }

        return $this->redirectToRoute('app_niveau_index');
    }

    #[Route('/{id}/edit', name: 'app_niveau_edit', methods: ['POST'])]
    public function edit(Request $request, Niveau $niveau, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Niveau modifié avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la modification du niveau.');
        }

        return $this->redirectToRoute('app_niveau_index');
    }

    #[Route('/{id}/delete', name: 'app_niveau_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Niveau $niveau,
        EntityManagerInterface $em
    ): Response {
        $csrfTokenId = 'delete' . $niveau->getId();
    
        if (!$this->isCsrfTokenValid($csrfTokenId, $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Jeton CSRF invalide.',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_niveau_index');
        }
    
        try {
            $em->remove($niveau);
            $em->flush();
    
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Niveau supprimé avec succès.',
                    'redirect' => $this->generateUrl('app_niveau_index')
                ]);
            }
    
            $this->addFlash('success', 'Niveau supprimé avec succès.');
        } catch (\Exception $e) {
            $errorData = [
                'success' => false,
                'message' => 'Erreur lors de la suppression du niveau.',
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
    
        return $this->redirectToRoute('app_niveau_index');
    }
    
}
