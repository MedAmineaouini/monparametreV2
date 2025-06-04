<?php
// src/Controller/DashboardController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaysRepository;

// <-- ajoute cette ligne

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(PaysRepository $paysRepository): Response
    {
        $nombrePays = $paysRepository->count([]);

        return $this->render('dashboard/index.html.twig', [
            'nombrePays' => $nombrePays,
        ]);
    }
}
