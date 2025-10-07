<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Entity\Ville;
use App\Entity\Affreteur;
use App\Form\VolType;
use App\Repository\VolRepository;
use App\Repository\VilleRepository;
use App\Repository\AffreteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
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
    public function new(Request $request, EntityManagerInterface $em, VilleRepository $villeRepository): Response
    {
        $vol = new Vol();
        $vol->setVendu(0);
        $vol->setReserve(0);
        $vol->setOuvert(0);
        $vol->setTypevol(1);
        $vol->setNomfour($vol->getNomfour() ?? '');

        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        // Debug seulement
        if ($form->isSubmitted()) {
            dd([
                'is_valid' => $form->isValid(),
                'form_data' => $form->getData(),
                'raw_post' => $request->request->all(),
                'errors' => (string) $form->getErrors(true, false)
            ]);

            // ARRÊTE ici avec dd(), donc pas de sauvegarde
        }

        return $this->render('vol/new.html.twig', [
            'vol'    => $vol,
            'form'   => $form->createView(),
            'villes' => $villeRepository->findAll(),
        ]);
    }

    private function getFormErrors($form): array
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
    public function edit(Request $request, Vol $vol, EntityManagerInterface $em, VilleRepository $villeRepository): Response
    {
        $formattedSeqvol = str_pad($vol->getSeqvol(), 4, '0', STR_PAD_LEFT);
        $aerodep = $vol->getVilleD() ? $vol->getVilleD()->getAero() : '';
        $aeroarr = $vol->getVilleA() ? $vol->getVilleA()->getAero() : '';

        $form = $this->createForm(VolType::class, $vol, [
            'seqvol_value'   => $formattedSeqvol,
            'aerodep_value'  => $aerodep,
            'aeroarr_value'  => $aeroarr,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($vol->getVilleD()) {
                $vol->setAerodep($vol->getVilleD()->getAero());
            }
            if ($vol->getVilleA()) {
                $vol->setAeroarr($vol->getVilleA()->getAero());
            }

            $em->flush();
            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vol/edit.html.twig', [
            'vol'    => $vol,
            'form'   => $form,
            'villes' => $villeRepository->findAll(),
        ]);
    }

    #[Route('/{seqvol}', name: 'app_vol_delete', methods: ['POST'])]
    public function delete(Request $request, Vol $vol, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $vol->getSeqvol(), $request->request->get('_token'))) {
            if ($request->isXmlHttpRequest()) {
                return $this->json(['success' => false, 'message' => 'Token CSRF invalide'], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirectToRoute('app_vol_index');
        }

        try {
            $em->remove($vol);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success'  => true,
                    'message'  => 'Vol supprimé avec succès.',
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
                    'message'   => $e->getMessage(),
                    'trace'     => $e->getTraceAsString(),
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
        return $this->json(['aeroport' => $ville->getAero()]);
    }

    #[Route('/get-affret/{id}', name: 'vol_get_affret', methods: ['GET'])]
    public function getAffret($id, AffreteurRepository $affreteurRepository): JsonResponse
    {
        $affreteur = $affreteurRepository->find($id);
        if (!$affreteur) {
            return $this->json(['libaffret' => '']);
        }
        return $this->json(['libaffret' => $affreteur->getLibaffret()]);
    }

    #[Route('/validate-tab', name: 'app_vol_validate_tab', methods: ['POST'])]
    public function validateTab(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $data = $request->request->all();
            $tab  = $data['tab'] ?? 'general';

            $vol = new Vol();
            $this->mapDataToVol($vol, $data);

            $errors = $validator->validate($vol); // groupes simplifiés ici
            $errorMessages = [];
            foreach ($errors as $error) {
                $propertyPath = $error->getPropertyPath();
                $errorMessages[$propertyPath] = $error->getMessage();
            }

            return $this->json([
                'valid'  => count($errors) === 0,
                'errors' => $errorMessages
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'valid'  => false,
                'errors' => ['general' => 'Erreur de validation: ' . $e->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /** Mappe quelques champs simples depuis $data vers $vol (version simplifiée) */
    private function mapDataToVol(Vol $vol, array $data): void
    {
        $simpleFields = [
            'seqvol', 'nvol', 'datevol', 'jo', 'jplus', 'pnr', 'datRetro', 'destination',
            'ouvert', 'vendu', 'reserve', 'dispo'
        ];

        foreach ($simpleFields as $field) {
            if (!isset($data[$field])) continue;
            $setter = 'set' . ucfirst($field);
            if (!method_exists($vol, $setter)) continue;

            $value = $data[$field];

            if (in_array($field, ['seqvol', 'jo', 'ouvert', 'vendu', 'reserve', 'dispo'], true)) {
                $value = ($value === '' ? null : (int)$value);
            } elseif ($field === 'jplus') {
                $value = ($value === '' ? null : $value);
            }

            $vol->$setter($value);
        }
    }

    /** Groupes de validation par tab (si besoin plus tard) */
    private function getValidationGroupsForTab(string $tab): array
    {
        $groups = [
            'general'    => ['general'],
            'capacities' => ['capacities'],
            'pricing'    => ['pricing'],
            'convocation'=> ['convocation'],
            'baggage'    => ['baggage'],
        ];

        return $groups[$tab] ?? ['Default'];
    }
}
