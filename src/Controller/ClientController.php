<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CommissionRepository;
use App\Repository\SuperReseauRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        CommissionRepository $commissionRepository,
        SuperReseauRepository $superReseauRepository
    ): Response {
        $seqclt = $request->query->get('seqclt');
        $nomclt = $request->query->get('nomclt');
        $nomreseau = $request->query->get('nomreseau');
        $seqcomm = $request->query->get('seqcomm');
    
        $qb = $entityManager->getRepository(Client::class)->createQueryBuilder('c');

        if ($seqclt) {
            $qb->andWhere('c.seqclt LIKE :seqclt')
               ->setParameter('seqclt', $seqclt . '%');
        }
        
        if ($nomclt) {
            $qb->andWhere('c.nomclt LIKE :nomclt')
               ->setParameter('nomclt', '%' . $nomclt . '%');
        }
        
        if ($nomreseau) {
            $qb->andWhere('c.nomreseau = :nomreseau')
               ->setParameter('nomreseau', $nomreseau);
        }
        
        if ($seqcomm) {
            $qb->andWhere('c.commission = :seqcomm')
               ->setParameter('seqcomm', $seqcomm);
        }
    
        $clients = $qb->getQuery()->getResult();

        $commissions = $commissionRepository->findAll();

        $reseauOptions = $superReseauRepository->createQueryBuilder('r')
            ->select('r.nomsuperreseau')
            ->distinct()
            ->getQuery()
            ->getArrayResult();

        $reseauList = array_column($reseauOptions, 'nomsuperreseau');
    
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'commissions' => $commissions,
            'reseauOptions' => $reseauList,
            'searchParams' => [
                'seqclt' => $seqclt,
                'nomclt' => $nomclt,
                'nomreseau' => $nomreseau,
                'seqcomm' => $seqcomm
            ]
        ]);
    }
    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{numclt}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{numclt}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{numclt}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getNumclt(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
