<?php

namespace App\Controller;

use App\Entity\Affreteur;
use App\Entity\Vol;
use App\Form\VolType;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VilleRepository;
use App\Repository\AffreteurRepository;
use App\Entity\Ville;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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

//    #[Route('/new', name: 'app_vol_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository): Response
//    {
//        $vol = new Vol();
//
//        // Générer seqvol
//        $lastSeq = $entityManager->createQueryBuilder()
//            ->select('MAX(v.seqvol)')
//            ->from(Vol::class, 'v')
//            ->getQuery()
//            ->getSingleScalarResult();
//
//        $nextSeq = $lastSeq ? ((int) $lastSeq + 1) : 1;
//        $vol->setSeqvol($nextSeq);
//
//        // Définir des valeurs par défaut pour éviter les erreurs de validation
//        $vol->setVendu(0);
//        $vol->setReserve(0);
//        $vol->setOuvert(0);
//        $vol->setTypevol(1); // Aller par défaut
//
//        $form = $this->createForm(VolType::class, $vol);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                // Définir les aéroports basés sur les villes sélectionnées
//                if ($villeD = $vol->getVilleD()) {
//                    $vol->setAerodep($villeD->getAero());
//                }
//                if ($villeA = $vol->getVilleA()) {
//                    $vol->setAeroarr($villeA->getAero());
//                }
//
//                // Définir la date de création
//                $vol->setDateCreation(new \DateTime());
//
//                $entityManager->persist($vol);
//                $entityManager->flush();
//
//                $this->addFlash('success', 'Vol créé avec succès!');
//                return $this->redirectToRoute('app_vol_index');
//
//            } catch (\Exception $e) {
//                $this->addFlash('error', 'Erreur lors de la création du vol: ' . $e->getMessage());
//            }
//        } elseif ($form->isSubmitted()) {
//            // Afficher les erreurs de validation
//            $errors = [];
//            foreach ($form->getErrors(true) as $error) {
//                $errors[] = $error->getMessage();
//            }
//            $this->addFlash('error', 'Erreurs de validation: ' . implode(', ', $errors));
//        }
//
//        return $this->render('vol/new.html.twig', [
//            'vol' => $vol,
//            'form' => $form->createView(),
//            'villes' => $villeRepository->findAll(),
//        ]);
//    }
//
    #[Route('/new', name: 'app_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository): Response
    {
        $vol = new Vol();

        // Générer seqvol
        $lastSeq = $entityManager->createQueryBuilder()
            ->select('MAX(v.seqvol)')
            ->from(Vol::class, 'v')
            ->getQuery()
            ->getSingleScalarResult();

        $nextSeq = $lastSeq ? ((int) $lastSeq + 1) : 1;
        $vol->setSeqvol($nextSeq);

        // Définir des valeurs par défaut pour éviter les erreurs de validation
        $vol->setVendu(0);
        $vol->setReserve(0);
        $vol->setOuvert(0);
        $vol->setTypevol(1); // Aller par défaut

        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        // DEBUG: Vérifier ce qui se passe quand le formulaire est soumis
        if ($form->isSubmitted()) {
            error_log("=== FORMULAIRE SOUMIS ===");
            error_log("Est valide: " . ($form->isValid() ? 'OUI' : 'NON'));

            // Afficher les erreurs de validation
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errorMsg = "Champ: " . $error->getOrigin()->getName() . " - Erreur: " . $error->getMessage();
                $errors[] = $errorMsg;
                error_log($errorMsg);
            }

            error_log("Données vol:");
            error_log("Seqvol: " . $vol->getSeqvol());
            error_log("Nvol: " . $vol->getNvol());
            error_log("Datevol: " . ($vol->getDatevol() ? $vol->getDatevol()->format('Y-m-d') : 'NULL'));
            error_log("VilleD: " . ($vol->getVilleD() ? $vol->getVilleD()->getId() : 'NULL'));
            error_log("VilleA: " . ($vol->getVilleA() ? $vol->getVilleA()->getId() : 'NULL'));
            error_log("Heured: " . $vol->getHeured());
            error_log("Heurea: " . $vol->getHeurea());
            error_log("Typevol: " . $vol->getTypevol());

            // Si le formulaire n'est pas valide, afficher les erreurs et arrêter pour debug
            if (!$form->isValid()) {
                // Pour le debug, afficher les erreurs et s'arrêter
                echo "<pre>";
                echo "FORMULAIRE INVALIDE - ERREURS:\n";
                print_r($errors);
                echo "\nDONNÉES VOL:\n";
                var_dump([
                    'seqvol' => $vol->getSeqvol(),
                    'nvol' => $vol->getNvol(),
                    'datevol' => $vol->getDatevol(),
                    'villeD' => $vol->getVilleD() ? $vol->getVilleD()->getId() : null,
                    'villeA' => $vol->getVilleA() ? $vol->getVilleA()->getId() : null,
                    'heured' => $vol->getHeured(),
                    'heurea' => $vol->getHeurea(),
                    'typevol' => $vol->getTypevol(),
                ]);
                echo "</pre>";
                die(); // Arrêter pour voir les erreurs
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Définir les aéroports basés sur les villes sélectionnées
                if ($villeD = $vol->getVilleD()) {
                    $vol->setAerodep($villeD->getAero());
                }
                if ($villeA = $vol->getVilleA()) {
                    $vol->setAeroarr($villeA->getAero());
                }

                // Définir la date de création
                $vol->setDateCreation(new \DateTime());

                error_log("Tentative de persistance...");
                $entityManager->persist($vol);
                $entityManager->flush();
                error_log("Vol enregistré avec succès! ID: " . $vol->getSeqvol());

                $this->addFlash('success', 'Vol créé avec succès!');
                return $this->redirectToRoute('app_vol_index');

            } catch (\Exception $e) {
                error_log("ERREUR lors de l'enregistrement: " . $e->getMessage());
                $this->addFlash('error', 'Erreur lors de la création du vol: ' . $e->getMessage());
            }
        } elseif ($form->isSubmitted()) {
            // Afficher les erreurs de validation
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            $this->addFlash('error', 'Erreurs de validation: ' . implode(', ', $errors));
        }

        return $this->render('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
            'villes' => $villeRepository->findAll(),
        ]);
    }
    private function getFormErrors($form)
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }
        return $errors;
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

    #[Route('/get-affret/{id}', name: 'vol_get_affret', methods: ['GET'])]
    public function getAffret($id, AffreteurRepository $affreteurRepository): JsonResponse
    {
        $affreteur = $affreteurRepository->find($id);
        
        if (!$affreteur) {
            return $this->json([
                'libaffret' => ''
            ]);
        }
    
        return $this->json([
            'libaffret' => $affreteur->getLibaffret()
        ]);
    }
    #[Route('/validate-tab', name: 'app_vol_validate_tab', methods: ['POST'])]
    public function validateTab(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $data = $request->request->all();
            $tab = $data['tab'] ?? 'general';

            // Log pour debug
            error_log("Validation tab: " . $tab);

            // Créez une instance de Vol avec les données soumises
            $vol = new Vol();
            $this->mapDataToVol($vol, $data);

            // Pour l'instant, validez sans groupes (simplifié)
            $errors = $validator->validate($vol);

            $errorMessages = [];
            foreach ($errors as $error) {
                $propertyPath = $error->getPropertyPath();
                $errorMessages[$propertyPath] = $error->getMessage();
            }

            return $this->json([
                'valid' => count($errors) === 0,
                'errors' => $errorMessages
            ]);

        } catch (\Exception $e) {
            error_log("Exception in validateTab: " . $e->getMessage());

            return $this->json([
                'valid' => false,
                'errors' => ['general' => 'Erreur de validation: ' . $e->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mappe les données du formulaire sur l'entité Vol (version simplifiée)
     */
    private function mapDataToVol(Vol $vol, array $data): void
    {
        // Seulement les champs de base pour tester
        $simpleFields = [
            'seqvol', 'nvol', 'datevol', 'jo', 'jplus', 'pnr', 'datRetro', 'destination',
            'ouvert', 'vendu', 'reserve', 'dispo'
        ];

        foreach ($simpleFields as $field) {
            if (isset($data[$field])) {
                $setter = 'set' . ucfirst($field);
                if (method_exists($vol, $setter)) {
                    $value = $data[$field];

                    // Conversion simple
                    if (in_array($field, ['seqvol', 'jo', 'ouvert', 'vendu', 'reserve', 'dispo'])) {
                        $value = $value === '' ? null : (int) $value;
                    } elseif ($field === 'jplus') {
                        $value = $value === '' ? null : $value;
                    }


                    $vol->$setter($value);
                }
            }
        }
    }

    /**
     * Retourne les groupes de validation pour un tab donné
     */
    private function getValidationGroupsForTab(string $tab): array
    {
        $groups = [
            'general' => ['general'],
            'capacities' => ['capacities'],
            'pricing' => ['pricing'],
            'convocation' => ['convocation'],
            'baggage' => ['baggage'],
        ];

        return $groups[$tab] ?? ['Default'];
    }
}
