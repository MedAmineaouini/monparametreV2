<?php
// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Security $security): RedirectResponse
    {
        if ($security->getUser()) {
            // Utilisateur connecté → redirection vers le tableau de bord
            return $this->redirectToRoute('dashboard');
        }

        // Sinon, redirection vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
}
