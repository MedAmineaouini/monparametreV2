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

    #[Route('/new', name: 'app_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository, ValidatorInterface $validator): Response
    {
        $vol = new Vol();

        // Générez seqvol comme avant
        $lastSeq = $entityManager->createQueryBuilder()
            ->select('MAX(v.seqvol)')
            ->from(Vol::class, 'v')
            ->getQuery()
            ->getSingleScalarResult();

        $nextSeq = $lastSeq ? ((int) $lastSeq + 1) : 1;
        $vol->setSeqvol($nextSeq);

        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($vol);
                $entityManager->flush();

                if ($request->isXmlHttpRequest()) {
                    return $this->json([
                        'success' => true,
                        'message' => 'Vol créé avec succès',
                        'volId' => $vol->getSeqvol()
                    ]);
                }

                return $this->redirectToRoute('app_vol_index');

            } catch (\Exception $e) {
                if ($request->isXmlHttpRequest()) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Erreur lors de la création du vol',
                        'error' => $e->getMessage()
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                $this->addFlash('error', 'Erreur lors de la création du vol');
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

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
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager, VilleRepository $villeRepository, ValidatorInterface $validator): Response
    {
        $formattedSeqvol = str_pad($vol->getSeqvol(), 4, '0', STR_PAD_LEFT);
        $aerodep = $vol->getVilleD() ? $vol->getVilleD()->getAero() : '';
        $aeroarr = $vol->getVilleA() ? $vol->getVilleA()->getAero() : '';

        $form = $this->createForm(VolType::class, $vol, [
            'seqvol_value' => $formattedSeqvol,
            'aerodep_value' => $aerodep,
            'aeroarr_value' => $aeroarr,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Validate the form
            $errors = $validator->validate($vol);

            if ($form->isValid() && count($errors) === 0) {
                if ($vol->getVilleD()) {
                    $vol->setAerodep($vol->getVilleD()->getAero());
                }
                if ($vol->getVilleA()) {
                    $vol->setAeroarr($vol->getVilleA()->getAero());
                }

                $entityManager->flush();

                return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Add form errors to flash messages
                foreach ($errors as $error) {
                    $this->addFlash('error', ucfirst($error->getPropertyPath()) . ': ' . $error->getMessage());
                }
            }
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
                return $this->json($errorData, Response::HTTP_INTERNAL_SERVER);
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
    public function validateTab(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $tab = $data['tab'] ?? '';
        $formData = $data['formData'] ?? [];

        // Create a partial validation based on the tab
        $vol = new Vol();

        // Set properties based on form data
        foreach ($formData as $key => $value) {
            // Skip empty values
            if ($value === '' || $value === null) {
                continue;
            }

            $setter = 'set' . ucfirst($key);
            if (method_exists($vol, $setter)) {
                // Handle different data types appropriately
                try {
                    switch ($key) {
                        case 'villeD':
                        case 'villeA':
                        case 'villeV':
                            // Handle Ville entities
                            if ($value) {
                                $ville = $entityManager->getRepository(Ville::class)->find($value);
                                if ($ville) {
                                    $vol->$setter($ville);
                                }
                            }
                            break;

                        case 'codaffret':
                            // Handle Affreteur entities
                            if ($value) {
                                $affreteur = $entityManager->getRepository(Affreteur::class)->find($value);
                                if ($affreteur) {
                                    $vol->$setter($affreteur);
                                }
                            }
                            break;

                        case 'datevol':
                        case 'dateconvo':
                        case 'dateconf':
                        case 'datedeconf':
                        case 'datRetro':
                            // Handle date fields
                            if ($value) {
                                $vol->$setter(new \DateTimeImmutable($value));
                            }
                            break;

                        case 'typevol':
                        case 'ouvert':
                        case 'vendu':
                        case 'reserve':
                        case 'freesale':
                        case 'sg':
                        case 'fictif':
                        case 'ferry':
                        case 'stopsale':
                        case 'volsec':
                        case 'venduVolsec':
                        case 'bagagesoute':
                        case 'allotFreesale':
                        case 'blocsiege':
                        case 'kilos':
                        case 'kilocabine':
                        case 'kilobebe':
                        case 'bagagesoption':
                        case 'nbrbagagesoption':
                            // Handle integer fields
                            $vol->$setter((int) $value);
                            break;

                        case 'prixada':
                        case 'prixzza':
                        case 'prixbba':
                        case 'taxea':
                        case 'prixadv':
                        case 'prixzzv':
                        case 'prixbbv':
                        case 'prixadv2':
                        case 'prixzzv2':
                        case 'prixbbv2':
                        case 'prixadv3':
                        case 'prixzzv3':
                        case 'prixbbv3':
                        case 'supp1':
                        case 'supp2':
                        case 'taxevente':
                        case 'cartevente':
                        case 'taxesovente':
                        case 'suppvol':
                        case 'prixYield':
                        case 'prixadav':
                        case 'prixbbav':
                        case 'prixzzav':
                            // Handle decimal fields
                            $vol->$setter((string) $value);
                            break;

                        default:
                            // Handle string fields
                            $vol->$setter($value);
                            break;
                    }
                } catch (\Exception $e) {
                    // Skip fields that can't be set properly
                    continue;
                }
            }
        }

        // Define validation groups based on the tab
        $validationGroups = [];
        switch ($tab) {
            case 'general':
                $validationGroups = ['general'];
                break;
            case 'capacities':
                $validationGroups = ['capacities'];
                break;
            case 'pricing':
                $validationGroups = ['pricing'];
                break;
            case 'convocation':
                $validationGroups = ['convocation'];
                break;
            case 'baggage':
                $validationGroups = ['baggage'];
                break;
            default:
                $validationGroups = ['Default'];
        }

        // Validate with the specific group
        $errors = $validator->validate($vol, null, $validationGroups);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json([
                'valid' => false,
                'errors' => $errorMessages
            ]);
        }

        return $this->json([
            'valid' => true
        ]);
    }
}