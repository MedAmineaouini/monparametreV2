<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VolRepository::class)]
#[ORM\Table(name: 'VOL')]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQVOL', type: Types::INTEGER)]
    private ?int $seqvol = null;

    #[ORM\Column(name: 'NVOL', type: Types::STRING, length: 8, nullable: true)]
    #[Assert\NotBlank(message: "Le numéro de vol est obligatoire", groups: ["general"])]
    #[Assert\Length(
        min: 2,
        max: 8,
        minMessage: "Le numéro de vol doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le numéro de vol ne peut pas dépasser {{ limit }} caractères",
        groups: ["general"]
    )]
    private ?string $nvol = null;

    #[ORM\Column(name: "DATEVOL", type: "datetime_immutable", nullable: true)]
    #[Assert\NotBlank(message: "La date du vol est obligatoire", groups: ["general"])]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "La date du vol ne peut pas être dans le passé",
        groups: ["general"]
    )]
    private ?\DateTimeImmutable $datevol = null;

    #[ORM\Column(name: "DATEVOLAU", type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $datevolau = null;

    #[ORM\Column(name: 'JO', type: Types::INTEGER, nullable: true)]
    private ?int $jo = null;

    #[ORM\Column(name: 'JPLUS', type: Types::STRING, length: 2, nullable: true)]
    private ?string $jplus = null;

    #[ORM\Column(name: 'HEURED', type: Types::STRING, length: 8, nullable: true)]
    #[Assert\NotBlank(message: "L'heure de départ est obligatoire", groups: ["general"])]
    private ?string $heured = '';

    #[ORM\Column(name: 'HEUREA', type: Types::STRING, length: 8, nullable: true)]
    #[Assert\NotBlank(message: "L'heure d'arrivée est obligatoire", groups: ["general"])]
    private ?string $heurea = '';

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'VILLED', referencedColumnName: 'SEQVILLE', nullable: false)]
    #[Assert\NotBlank(message: "La ville de départ est obligatoire", groups: ["general"])]
    private ?Ville $villeD = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'VILLEA', referencedColumnName: 'SEQVILLE', nullable: false)]
    #[Assert\NotBlank(message: "La ville d'arrivée est obligatoire", groups: ["general"])]
    private ?Ville $villeA = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'VILLEV', referencedColumnName: 'SEQVILLE', nullable: true)]
    private ?Ville $villeV = null;

    #[ORM\ManyToOne(targetEntity: Affreteur::class)]
    #[ORM\JoinColumn(name: 'CODAFFRET', referencedColumnName: 'SEQAFFRET')]
    private ?Affreteur $codaffret = null;

    #[ORM\Column(name: 'TYPEVOL', type: Types::INTEGER, nullable: true)]
    #[Assert\NotBlank(message: "Le type de vol est obligatoire", groups: ["general"])]
    private ?int $typevol = 0;

    #[ORM\Column(name: 'KILOS', type: Types::INTEGER, nullable: true)]
    #[Assert\PositiveOrZero(message: "Les kilos doivent être positifs ou zéro", groups: ["baggage"])]
    private ?int $kilos = 0;

    #[ORM\Column(name: 'SG', type: Types::INTEGER, nullable: true)]
    #[Assert\PositiveOrZero(message: "Les sièges engagés doivent être positifs ou zéro", groups: ["capacities"])]
    private ?int $sg = 0;

    #[ORM\Column(name: 'VENDU', type: Types::INTEGER, nullable: true)]
    #[Assert\NotBlank(message: "Le nombre de places vendues est obligatoire", groups: ["capacities"])]
    #[Assert\PositiveOrZero(message: "Le nombre de places vendues doit être positif ou zéro", groups: ["capacities"])]
    private ?int $vendu = 0;

    #[ORM\Column(name: 'RESERVE', type: Types::INTEGER, nullable: true)]
    #[Assert\NotBlank(message: "Le nombre de places réservées est obligatoire", groups: ["capacities"])]
    #[Assert\PositiveOrZero(message: "Le nombre de places réservées doit être positif ou zéro", groups: ["capacities"])]
    private ?int $reserve = 0;

    #[ORM\Column(name: 'PRIXADA', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix adulte achat doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixada = null;

    #[ORM\Column(name: 'PRIXZZA', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix enfant achat doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixzza = '0';

    #[ORM\Column(name: 'PRIXBBA', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix bébé achat doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixbba = '0';

    #[ORM\Column(name: 'TAXEA', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "La taxe achat doit être positive ou zéro", groups: ["pricing"])]
    private ?string $taxea = '0';

    #[ORM\Column(name: 'PRIXADV', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix adulte vente doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixadv = '0';

    #[ORM\Column(name: 'PRIXZZV', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix enfant vente doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixzzv = '0';

    #[ORM\Column(name: 'PRIXBBV', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix bébé vente doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixbbv = '0';

    #[ORM\Column(name: 'PRIXADV2', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix adulte vente 2 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixadv2 = '0';

    #[ORM\Column(name: 'PRIXZZV2', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix enfant vente 2 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixzzv2 = '0';

    #[ORM\Column(name: 'PRIXBBV2', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix bébé vente 2 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixbbv2 = '0';

    #[ORM\Column(name: 'PRIXADV3', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix adulte vente 3 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixadv3 = '0';

    #[ORM\Column(name: 'PRIXZZV3', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix enfant vente 3 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixzzv3 = '0';

    #[ORM\Column(name: 'PRIXBBV3', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix bébé vente 3 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixbbv3 = '0';

    #[ORM\Column(name: 'SUPP1', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le supplément 1 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $supp1 = '0';

    #[ORM\Column(name: 'SUPP2', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le supplément 2 doit être positif ou zéro", groups: ["pricing"])]
    private ?string $supp2 = '0';

    #[ORM\Column(name: 'TAXEVENTE', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "La taxe vente doit être positive ou zéro", groups: ["pricing"])]
    private ?string $taxevente = '0';

    #[ORM\Column(name: 'CARTEVENTE', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "La carte vente doit être positive ou zéro", groups: ["pricing"])]
    private ?string $cartevente = '0';

    #[ORM\Column(name: 'TAXESOVENTE', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "La taxe de sortie vente doit être positive ou zéro", groups: ["pricing"])]
    private ?string $taxesovente = '0';

    #[ORM\Column(name: 'SUPPVOL', type: Types::DECIMAL, precision: 7, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le supplément vol doit être positif ou zéro", groups: ["pricing"])]
    private ?string $suppvol = '0';

    #[ORM\Column(name: 'DATECONVO',type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateconvo = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $heureconvo = null;

    #[ORM\Column(name: 'LIEUCONVO', type: Types::STRING, length: 30, nullable: true)]
    private ?string $lieuconvo = '';

    #[ORM\Column(name: 'COMPTOIR', type: Types::STRING, length: 50, nullable: true)]
    private ?string $comptoir = '';

    #[ORM\Column(name: 'PORTE', type: Types::STRING, length: 50, nullable: true)]
    private ?string $porte = '';

    #[ORM\Column(name: 'AGENCE', type: Types::STRING, length: 30, nullable: true)]
    private ?string $agence = '';

    #[ORM\Column(name: 'TELAGENCE', type: Types::STRING, length: 20, nullable: true)]
    private ?string $telagence = '';

    #[ORM\Column(name: 'FORMFORF', type: Types::STRING, length: 30, nullable: true)]
    private ?string $formforf = '';

    #[ORM\Column(name: 'FORMSEC', type: Types::STRING, length: 30, nullable: true)]
    private ?string $formsec = '';

    #[ORM\Column(name: 'OBS', type: Types::TEXT, nullable: true)]
    private ?string $obs = '';

    #[ORM\Column(name: 'DATECONF', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateconf = null;

    #[ORM\Column(name: 'DATEDECONF', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datedeconf = null;

    #[ORM\Column(name: 'FREESALE', type: Types::INTEGER, nullable: true)]
    #[Assert\PositiveOrZero(message: "Le free sale doit être positif ou zéro", groups: ["capacities"])]
    private ?int $freesale = 0;

    #[ORM\Column(name: 'ASSVOL', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $assvol = '0';

    #[ORM\Column(name: 'OUVERT', type: Types::INTEGER)]
    #[Assert\NotBlank(message: "L'offre totale est obligatoire", groups: ["capacities"])]
    #[Assert\PositiveOrZero(message: "L'offre totale doit être positive ou zéro", groups: ["capacities"])]
    private ?int $ouvert = 0;

    #[ORM\Column(name: 'TAXEA2', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $taxea2 = '0';

    #[ORM\Column(name: 'AUTRES', type: Types::STRING, length: 35, nullable: true)]
    private ?string $autres = '';

    #[ORM\Column(name: 'COAF', type: Types::INTEGER)]
    private ?int $coaf = 0;

    #[ORM\Column(name: 'FICTIF', type: Types::BOOLEAN, nullable: true)]
    private ?bool $fictif = null;


    #[ORM\Column(name: 'LIEN', type: Types::INTEGER)]
    private ?int $lien = 0;

    #[ORM\Column(name: 'TYPEAVION', type: Types::STRING, length: 20, nullable: true)]
    private ?string $typeavion = '';

    #[ORM\Column(name: 'COMPAGNIE', type: Types::STRING, length: 20, nullable: true)]
    private ?string $compagnie = '';

    #[ORM\Column(name: 'STOPSALE', type: Types::INTEGER)]
    private ?int $stopsale = 0;

    #[ORM\Column(name: 'TAXESOLIDARITE', type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $taxesolidarite = '0';

    #[ORM\Column(name: 'NOMAXE', type: Types::STRING, length: 10, nullable: true)]
    private ?string $nomaxe = '';

    #[ORM\Column(name: 'RETRO', type: Types::INTEGER)]
    private ?int $retro = 0;

    #[ORM\Column(name: 'PAX_RETRO', type: Types::INTEGER)]
    private ?int $paxRetro = 0;

    #[ORM\Column(name: 'DAT_RETRO', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datRetro = null;

    #[ORM\Column(name: 'HEUREDV', type: Types::STRING, length: 4, nullable: true)]
    private ?string $heuredv = '';

    #[ORM\Column(name: 'HEUREAV', type: Types::STRING, length: 4, nullable: true)]
    private ?string $heureav = '';

    #[ORM\Column(name: 'DUREEVOL', type: Types::STRING, length: 4, nullable: true)]
    private ?string $dureevol = '';

    #[ORM\Column(name: 'CONVO_WEB', type: Types::INTEGER)]
    private ?int $convoWeb = 1;

    #[ORM\Column(name: 'OBS_RESA', type: Types::TEXT, nullable: true)]
    private ?string $obsResa = '';

    #[ORM\Column(name: 'pax_embarque', type: Types::INTEGER)]
    private ?int $paxEmbarque = 0;

    #[ORM\Column(name: 'heure_embarque', type: Types::STRING, length: 4, nullable: true)]
    private ?string $heureEmbarque = '';

    #[ORM\Column(name: 'PREST_ABORD', type: Types::INTEGER)]
    private ?int $prestAbord = 0;

    #[ORM\Column(name: 'STOCKG', type: Types::INTEGER)]
    private ?int $stockg = 0;

    #[ORM\Column(name: 'VILLEDD', type: Types::STRING, length: 3, nullable: true)]
    private ?string $villedd = '';

    #[ORM\Column(name: 'VILLEAA', type: Types::STRING, length: 3, nullable: true)]
    private ?string $villeaa = '';

    #[ORM\Column(name: 'VENDUG', type: Types::INTEGER)]
    private ?int $vendug = 0;

    #[ORM\Column(name: 'INCLUS_SG', type: Types::STRING, length: 10, nullable: true)]
    private ?string $inclusSg = '';

    #[ORM\Column(name: 'CRON', type: Types::INTEGER)]
    private ?int $cron = 0;

    #[ORM\Column(name: 'SOUSTOCK', type: Types::INTEGER)]
    private ?int $soustock = 0;

    #[ORM\Column(name: 'RESERVES', type: Types::INTEGER)]
    private ?int $reserves = 0;

    #[ORM\Column(name: 'VENDUS', type: Types::INTEGER)]
    private ?int $vendus = 0;

    #[ORM\Column(name: 'ENGAGEMENT', type: Types::INTEGER)]
    private ?int $engagement = 0;

    #[ORM\Column(name: 'SEQVOL_GENERIQUE', type: Types::INTEGER)]
    private ?int $seqvolGenerique = 0;

    #[ORM\Column(name: 'CODAFFRET1', type: Types::STRING, length: 3, nullable: true)]
    private ?string $codaffret1 = '';

//    #[ORM\Column(name: 'DESTINATION', type: Types::STRING, length: 30)]
//    #[Assert\NotBlank(message: "La destination est obligatoire", groups: ["general"])]
//    #[Assert\Length(
//        min: 2,
//        max: 30,
//        minMessage: "La destination doit contenir au moins {{ limit }} caractères",
//        maxMessage: "La destination ne peut pas dépasser {{ limit }} caractères",
//        groups: ["general"]
//    )]
//    private ?string $destination = '';
    #[ORM\Column(name: 'NATURE', type: Types::INTEGER)]
    private ?int $nature = 2;

    #[ORM\Column(name: 'NVOL2', type: Types::STRING, length: 8, nullable: true)]
    private ?string $nvol2 = '';

    #[ORM\Column(name: 'TAXEV', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $taxev = '0';

    #[ORM\Column(name: 'TAXESOLIDARITEV', type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $taxesolidaritev = '0';

    #[ORM\Column(name: 'TAXESOVENTEV', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $taxesoventev = '0';

    #[ORM\Column(name: 'TOTALTAXEA', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $totaltaxea = '0';

    #[ORM\Column(name: 'PRIXADULTE', type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $prixadulte = '0';

    #[ORM\Column(name: 'CODAFFRET2', type: Types::STRING, length: 3, nullable: true)]
    private ?string $codaffret2 = '';

    #[ORM\Column(name: 'MAX_VOLSEC_ALLOUE', type: Types::INTEGER)]
    private ?int $maxVolsecAlloue = 0;

    #[ORM\Column(name: 'VENDU_VOLSEC', type: Types::INTEGER)]
    private ?int $venduVolsec = 0;

    #[ORM\Column(name: 'NVOLVIA', type: Types::STRING, length: 8, nullable: true)]
    private ?string $nvolvia = '';

    #[ORM\Column(name: 'OBS_VIA', type: Types::STRING, length: 80, nullable: true)]
    private ?string $obsVia = '';

    #[ORM\Column(name: 'AFFECTER', type: Types::INTEGER)]
    private ?int $affecter = 0;

    #[ORM\Column(name: 'FREESALE1', type: Types::INTEGER)]
    private ?int $freesale1 = 0;

    #[ORM\Column(name: 'TOT_MAX_VOLSEC', type: Types::INTEGER)]
    private ?int $totMaxVolsec = 0;

    #[ORM\Column(name: 'TOT_FREESALE', type: Types::INTEGER)]
    private ?int $totFreesale = 0;

    #[ORM\Column(name: 'SEQRECEPTIF', type: Types::INTEGER)]
    private ?int $seqreceptif = 0;

    #[ORM\Column(name: 'RACHAT_IMMEDIAT', type: Types::INTEGER)]
    private ?int $rachatImmediat = 0;

    #[ORM\Column(name: 'SEQVILLED', type: Types::INTEGER)]
    private ?int $seqvilled = 0;

    #[ORM\Column(name: 'SEQVILLEA', type: Types::INTEGER)]
    private ?int $seqvillea = 0;

    #[ORM\Column(name: 'SEQVILLEV', type: Types::INTEGER)]
    private ?int $seqvillev = 0;

    #[ORM\Column(name: 'SEQAFFRET1', type: Types::INTEGER)]
    private ?int $seqaffret1 = 0;

    #[ORM\Column(name: 'SEQAFFRET2', type: Types::INTEGER)]
    private ?int $seqaffret2 = 0;

    #[ORM\Column(name: 'AFFECTERS', type: Types::INTEGER)]
    private ?int $affecters = 0;

    #[ORM\Column(name: 'BOARDING_PASS', type: Types::INTEGER)]
    private ?int $boardingPass = 0;

    #[ORM\Column(name: 'BAGAGESOPTION', type: Types::INTEGER)]
    private ?int $bagagesoption = 0;

    #[ORM\Column(name: 'PRIXBAGAGESOPTION', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix des bagages optionnels doit être positif ou zéro", groups: ["baggage"])]
    private ?string $prixbagagesoption = '0';

    #[ORM\Column(name: 'NBRBAGAGESOPTION', type: Types::INTEGER)]
    #[Assert\PositiveOrZero(message: "Le nombre de bagages optionnels doit être positif ou zéro", groups: ["baggage"])]
    private ?int $nbrbagagesoption = 0;

    #[ORM\Column(name: 'PNR', type: Types::STRING, length: 10, nullable: true)]
    private ?string $pnr = null;

    #[ORM\Column(name: 'ETABLISSEMENT', type: Types::INTEGER)]
    private ?int $etablissement = 0;

    #[ORM\Column(name: 'NATURE_VOL', type: Types::INTEGER)]
    private ?int $natureVol = 0;

    #[ORM\Column(name: 'ARCHIVER', type: Types::INTEGER)]
    private ?int $archiver = 0;

    #[ORM\Column(name: 'KILOCABINE', type: Types::INTEGER)]
    #[Assert\PositiveOrZero(message: "Les kilos cabine doivent être positifs ou zéro", groups: ["baggage"])]
    private ?int $kilocabine = 0;

    #[ORM\Column(name: 'PRIX_YIELD', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le yield doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixYield = '0';

    #[ORM\Column(name: 'aerod', type: Types::STRING, length: 6, nullable: true)]
    private ?string $aerod = '';

    #[ORM\Column(name: 'aeroa', type: Types::STRING, length: 6, nullable: true)]
    private ?string $aeroa = '';

    #[ORM\Column(name: 'pas_afficher_horaire', type: Types::INTEGER)]
    private ?int $pasAfficherHoraire = 0;

    #[ORM\Column(name: 'kilobebe', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Les kilos bébé doivent être positifs ou zéro", groups: ["baggage"])]
    private ?string $kilobebe = '0';

    #[ORM\Column(name: 'aerodep', type: Types::STRING, length: 10, nullable: true)]
    private ?string $aerodep = '';

    #[ORM\Column(name: 'aeroarr', type: Types::STRING, length: 10, nullable: true)]
    private ?string $aeroarr = '';

    #[ORM\Column(name: 'specification', type: Types::INTEGER)]
    private ?int $specification = 0;

    #[ORM\Column(name: 'bagagesoute', type: Types::DECIMAL, precision: 5, scale: 0)]
    private ?string $bagagesoute = '0';

    #[ORM\Column(name: 'coafv', type: Types::INTEGER)]
    private ?int $coafv = 0;

    #[ORM\Column(name: 'volsec', type: Types::INTEGER)]
    private ?int $volsec = 0;

    #[ORM\Column(name: 'allot_freesale', type: Types::DECIMAL, precision: 5, scale: 0)]
    private ?string $allotFreesale = '0';

    #[ORM\Column(name: 'retro_vol', type: Types::DECIMAL, precision: 18, scale: 0)]
    private ?string $retroVol = '0';

    #[ORM\Column(name: 'prixada2', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixada2 = '0';

    #[ORM\Column(name: 'prixada3', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixada3 = '0';

    #[ORM\Column(name: 'prixzza2', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixzza2 = '0';

    #[ORM\Column(name: 'prixzza3', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixzza3 = '0';

    #[ORM\Column(name: 'prixbba2', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixbba2 = '0';

    #[ORM\Column(name: 'prixbba3', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $prixbba3 = '0';

    #[ORM\Column(name: 'VIlle', type: Types::STRING, length: 20, nullable: true)]
    private ?string $ville = '';

    #[ORM\Column(name: 'Nomfour', type: Types::STRING, length: 30, nullable: true)]
    private ?string $nomfour = null;

    #[ORM\Column(name: 'semaine1', type: Types::INTEGER)]
    private ?int $semaine1 = 0;

    #[ORM\Column(name: 'blocsiege', type: Types::INTEGER)]
    private ?int $blocsiege = 0;

    #[ORM\Column(name: 'prixadav', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix adulte vol sec doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixadav = '0';

    #[ORM\Column(name: 'prixbbav', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix bébé vol sec doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixbbav = '0';

    #[ORM\Column(name: 'prixzzav', type: Types::DECIMAL, precision: 9, scale: 2)]
    #[Assert\PositiveOrZero(message: "Le prix enfant vol sec doit être positif ou zéro", groups: ["pricing"])]
    private ?string $prixzzav = '0';

    #[ORM\Column(name: 'TAXE_B2B', type: Types::DECIMAL, precision: 9, scale: 2)]
    private ?string $taxeB2b = '0';

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $ferry = null;
    #[ORM\Column(name: 'SG_GARANTIS', type: Types::INTEGER)]
    private ?int $sgGarantis = 0;

    #[ORM\Column(name: "RETROCEDE", type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $retrocede = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS')]
    private ?Pays $IDPAYS = null;
    public function __construct(
        ?int $seqvol = null,
        ?string $nvol = null,
        ?\DateTimeImmutable $datevol = null,
        ?int $jo = null,
        ?string $jplus = '',
        ?string $heured = '',
        ?string $heurea = '',
        ?Ville $villeD = null,
        ?Ville $villeA = null,
        ?Ville $villeV = null,
        ?Affreteur $codaffret = null,
        ?int $typevol = 0,
        ?int $kilos = 0,
        ?int $sg = 0,
        ?int $vendu = 0,
        ?int $reserve = 0,
        ?string $prixada = null,
        ?string $prixzza = '0',
        ?string $prixbba = '0',
        ?string $taxea = '0',
        ?string $prixadv = '0',
        ?string $prixzzv = '0',
        ?string $prixbbv = '0',
        ?string $prixadv2 = '0',
        ?string $prixzzv2 = '0',
        ?string $prixbbv2 = '0',
        ?string $prixadv3 = '0',
        ?string $prixzzv3 = '0',
        ?string $prixbbv3 = '0',
        ?string $supp1 = '0',
        ?string $supp2 = '0',
        ?string $taxevente = '0',
        ?string $cartevente = '0',
        ?string $taxesovente = '0',
        ?string $suppvol = '0',
        ?\DateTimeInterface $dateconvo = null,
        ?string $heureconvo = null,
        ?string $lieuconvo = '',
        ?string $comptoir = '',
        ?string $porte = '',
        ?string $agence = '',
        ?string $telagence = '',
        ?string $formforf = '',
        ?string $formsec = '',
        ?string $obs = '',
        ?\DateTimeInterface $dateconf = null,
        ?\DateTimeInterface $datedeconf = null,
        ?int $freesale = 0,
        ?string $assvol = '0',
        ?int $ouvert = 0,
        ?string $taxea2 = '0',
        ?string $autres = '',
        ?int $coaf = 0,
        ?int $fictif = null,
        ?int $lien = 0,
        ?string $typeavion = '',
        ?string $compagnie = '',
        ?int $stopsale = 0,
        ?string $taxesolidarite = '0',
        ?string $nomaxe = '',
        ?int $retro = 0,
        ?int $paxRetro = 0,
        ?\DateTimeInterface $datRetro = null,
        ?string $heuredv = '',
        ?string $heureav = '',
        ?string $dureevol = '',
        ?int $convoWeb = 1,
        ?string $obsResa = '',
        ?int $paxEmbarque = 0,
        ?string $heureEmbarque = '',
        ?int $prestAbord = 0,
        ?int $stockg = 0,
        ?string $villedd = '',
        ?string $villeaa = '',
        ?int $vendug = 0,
        ?string $inclusSg = '',
        ?int $cron = 0,
        ?int $soustock = 0,
        ?int $reserves = 0,
        ?int $vendus = 0,
        ?int $engagement = 0,
        ?int $seqvolGenerique = 0,
        ?string $codaffret1 = '',
        ?string $destination = '',
        ?int $nature = 2,
        ?string $nvol2 = '',
        ?string $taxev = '0',
        ?string $taxesolidaritev = '0',
        ?string $taxesoventev = '0',
        ?string $totaltaxea = '0',
        ?string $prixadulte = '0',
        ?string $codaffret2 = '',
        ?int $maxVolsecAlloue = 0,
        ?int $venduVolsec = 0,
        ?string $nvolvia = '',
        ?string $obsVia = '',
        ?int $affecter = 0,
        ?int $freesale1 = 0,
        ?int $totMaxVolsec = 0,
        ?int $totFreesale = 0,
        ?int $seqreceptif = 0,
        ?int $rachatImmediat = 0,
        ?int $seqvilled = 0,
        ?int $seqvillea = 0,
        ?int $seqvillev = 0,
        ?int $seqaffret1 = 0,
        ?int $seqaffret2 = 0,
        ?int $affecters = 0,
        ?int $boardingPass = 0,
        ?int $bagagesoption = 0,
        ?string $prixbagagesoption = '0',
        ?int $nbrbagagesoption = 0,
        ?string $pnr = null,
        ?int $etablissement = 0,
        ?int $natureVol = 0,
        ?int $archiver = 0,
        ?int $kilocabine = 0,
        ?string $prixYield = '0',
        ?string $aerod = '',
        ?string $aeroa = '',
        ?int $pasAfficherHoraire = 0,
        ?string $kilobebe = '0',
        ?string $aerodep = '',
        ?string $aeroarr = '',
        ?int $specification = 0,
        ?string $bagagesoute = '0',
        ?int $coafv = 0,
        ?int $volsec = 0,
        ?string $allotFreesale = '0',
        ?string $retroVol = '0',
        ?string $prixada2 = '0',
        ?string $prixada3 = '0',
        ?string $prixzza2 = '0',
        ?string $prixzza3 = '0',
        ?string $prixbba2 = '0',
        ?string $prixbba3 = '0',
        ?string $ville = '',
        ?string $nomfour = '',
        ?int $semaine1 = 0,
        ?int $blocsiege = 0,
        ?string $prixadav = '0',
    ) {
        $this->seqvol = $seqvol;
        $this->nvol = $nvol;
        $this->datevol = $datevol;
        $this->jo = $jo;
        $this->jplus = $jplus;
        $this->heured = $heured;
        $this->heurea = $heurea;
        $this->villeD = $villeD;
        $this->villeA = $villeA;
        $this->villeV = $villeV;
        $this->codaffret = $codaffret;
        $this->typevol = $typevol;
        $this->kilos = $kilos;
        $this->sg = $sg;
        $this->vendu = $vendu;
        $this->reserve = $reserve;
        $this->prixada = $prixada;
        $this->prixzza = $prixzza;
        $this->prixbba = $prixbba;
        $this->taxea = $taxea;
        $this->prixadv = $prixadv;
        $this->prixzzv = $prixzzv;
        $this->prixbbv = $prixbbv;
        $this->prixadv2 = $prixadv2;
        $this->prixzzv2 = $prixzzv2;
        $this->prixbbv2 = $prixbbv2;
        $this->prixadv3 = $prixadv3;
        $this->prixzzv3 = $prixzzv3;
        $this->prixbbv3 = $prixbbv3;
        $this->supp1 = $supp1;
        $this->supp2 = $supp2;
        $this->taxevente = $taxevente;
        $this->cartevente = $cartevente;
        $this->taxesovente = $taxesovente;
        $this->suppvol = $suppvol;
        $this->dateconvo = $dateconvo;
        $this->heureconvo = $heureconvo;
        $this->lieuconvo = $lieuconvo;
        $this->comptoir = $comptoir;
        $this->porte = $porte;
        $this->agence = $agence;
        $this->telagence = $telagence;
        $this->formforf = $formforf;
        $this->formsec = $formsec;
        $this->obs = $obs;
        $this->dateconf = $dateconf;
        $this->datedeconf = $datedeconf;
        $this->freesale = $freesale;
        $this->assvol = $assvol;
        $this->ouvert = $ouvert;
        $this->taxea2 = $taxea2;
        $this->autres = $autres;
        $this->coaf = $coaf;
        $this->fictif = $fictif;
        $this->lien = $lien;
        $this->typeavion = $typeavion;
        $this->compagnie = $compagnie;
        $this->stopsale = $stopsale;
        $this->taxesolidarite = $taxesolidarite;
        $this->nomaxe = $nomaxe;
        $this->retro = $retro;
        $this->paxRetro = $paxRetro;
        $this->datRetro = $datRetro;
        $this->heuredv = $heuredv;
        $this->heureav = $heureav;
        $this->dureevol = $dureevol;
        $this->convoWeb = $convoWeb;
        $this->obsResa = $obsResa;
        $this->paxEmbarque = $paxEmbarque;
        $this->heureEmbarque = $heureEmbarque;
        $this->prestAbord = $prestAbord;
        $this->stockg = $stockg;
        $this->villedd = $villedd;
        $this->villeaa = $villeaa;
        $this->vendug = $vendug;
        $this->inclusSg = $inclusSg;
        $this->cron = $cron;
        $this->soustock = $soustock;
        $this->reserves = $reserves;
        $this->vendus = $vendus;
        $this->engagement = $engagement;
        $this->seqvolGenerique = $seqvolGenerique;
        $this->codaffret1 = $codaffret1;
        $this->destination = $destination;
        $this->nature = $nature;
        $this->nvol2 = $nvol2;
        $this->taxev = $taxev;
        $this->taxesolidaritev = $taxesolidaritev;
        $this->taxesoventev = $taxesoventev;
        $this->totaltaxea = $totaltaxea;
        $this->prixadulte = $prixadulte;
        $this->codaffret2 = $codaffret2;
        $this->maxVolsecAlloue = $maxVolsecAlloue;
        $this->venduVolsec = $venduVolsec;
        $this->nvolvia = $nvolvia;
        $this->obsVia = $obsVia;
        $this->affecter = $affecter;
        $this->freesale1 = $freesale1;
        $this->totMaxVolsec = $totMaxVolsec;
        $this->totFreesale = $totFreesale;
        $this->seqreceptif = $seqreceptif;
        $this->rachatImmediat = $rachatImmediat;
        $this->seqvilled = $seqvilled;
        $this->seqvillea = $seqvillea;
        $this->seqvillev = $seqvillev;
        $this->seqaffret1 = $seqaffret1;
        $this->seqaffret2 = $seqaffret2;
        $this->affecters = $affecters;
        $this->boardingPass = $boardingPass;
        $this->bagagesoption = $bagagesoption;
        $this->prixbagagesoption = $prixbagagesoption;
        $this->nbrbagagesoption = $nbrbagagesoption;
        $this->pnr = $pnr;
        $this->etablissement = $etablissement;
        $this->natureVol = $natureVol;
        $this->archiver = $archiver;
        $this->kilocabine = $kilocabine;
        $this->prixYield = $prixYield;
        $this->aerod = $aerod;
        $this->aeroa = $aeroa;
        $this->pasAfficherHoraire = $pasAfficherHoraire;
        $this->kilobebe = $kilobebe;
        $this->aerodep = $aerodep;
        $this->aeroarr = $aeroarr;
        $this->specification = $specification;
        $this->bagagesoute = $bagagesoute;
        $this->coafv = $coafv;
        $this->volsec = $volsec;
        $this->allotFreesale = $allotFreesale;
        $this->retroVol = $retroVol;
        $this->prixada2 = $prixada2;
        $this->prixada3 = $prixada3;
        $this->prixzza2 = $prixzza2;
        $this->prixzza3 = $prixzza3;
        $this->prixbba2 = $prixbba2;
        $this->prixbba3 = $prixbba3;
        $this->ville = $ville;
        $this->nomfour = $nomfour;
        $this->semaine1 = $semaine1;
        $this->blocsiege = $blocsiege;
        $this->prixadav = $prixadav;
    }


    public function getSeqvol(): ?int
    {
        return $this->seqvol;
    }
    public function setSeqvol(int $seqvol): self
    {
        $this->seqvol = $seqvol;
        return $this;
    }

    public function getNvol(): string
    {
        return $this->nvol;
    }

    public function setNvol(string $nvol): self
    {
        $this->nvol = $nvol;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDatevol(): ?\DateTimeInterface
    {
        return $this->datevol;
    }

    /**
     * @param \DateTimeInterface|null $datevol
     */
    public function setDatevol(?\DateTimeInterface $datevol): void
    {
        $this->datevol = $datevol;
    }

    /**
     * @return int
     */
    public function getJo(): int
    {
        return $this->jo;
    }

    /**
     * @param int $jo
     */
    public function setJo(int $jo): void
    {
        $this->jo = $jo;
    }

    /**
     * @return string
     */
    public function getJplus(): string
    {
        return $this->jplus;
    }

    /**
     * @param string $jplus
     */
    public function setJplus(?string $jplus): void
    {
        $this->jplus = $jplus;
    }


    // /**
    //  * @return string
    //  */
    // public function getVilled(): string
    // {
    //     return $this->villed;
    // }

    // /**
    //  * @param string $villed
    //  */
    // public function setVilled(string $villed): void
    // {
    //     $this->villed = $villed;
    // }

    /**
     * @return string
     */
    public function getHeured(): string
    {
        return $this->heured;
    }

    /**
     * @param string $heured
     */
    public function setHeured(string $heured): void
    {
        $this->heured = $heured;
    }

    // /**
    //  * @return string
    //  */
    // public function getVillea(): string
    // {
    //     return $this->villea;
    // }

    // /**
    //  * @param string $villea
    //  */
    // public function setVillea(string $villea): void
    // {
    //     $this->villea = $villea;
    // }

    /**
     * @return string
     */
    public function getHeurea(): string
    {
        return $this->heurea;
    }

    /**
     * @param string $heurea
     */
    public function setHeurea(string $heurea): void
    {
        $this->heurea = $heurea;
    }

    // /**
    //  * @return string
    //  */
    // public function getVillev(): string
    // {
    //     return $this->villev;
    // }

    // /**
    //  * @param string $villev
    //  */
    // public function setVillev(string $villev): void
    // {
    //     $this->villev = $villev;
    // }

    /**
     * @return int
     */
    public function getTypevol(): int
    {
        return $this->typevol;
    }

    /**
     * @param int $typevol
     */
    public function setTypevol(int $typevol): void
    {
        $this->typevol = $typevol;
    }

    /**
     * @return int
     */
    public function getKilos(): int
    {
        return $this->kilos;
    }

    /**
     * @param int $kilos
     */
    public function setKilos(int $kilos): void
    {
        $this->kilos = $kilos;
    }

    public function getCodaffret(): ?Affreteur
    {
        return $this->codaffret;
    }

    public function setCodaffret(?Affreteur $codaffret): self
    {
        $this->codaffret = $codaffret;
        return $this;
    }

    /**
     * @return int
     */
    public function getSg(): int
    {
        return $this->sg;
    }

    /**
     * @param int $sg
     */
    public function setSg(int $sg): void
    {
        $this->sg = $sg;
    }

    /**
     * @return int
     */
    public function getVendu(): int
    {
        return $this->vendu;
    }

    /**
     * @param int $vendu
     */
    public function setVendu(int $vendu): void
    {
        $this->vendu = $vendu;
    }

    /**
     * @return int
     */
    public function getReserve(): int
    {
        return $this->reserve;
    }

    /**
     * @param int $reserve
     */
    public function setReserve(int $reserve): void
    {
        $this->reserve = $reserve;
    }

    /**
     * @return string
     */
    public function getPrixada(): string
    {
        return $this->prixada;
    }

    /**
     * @param string $prixada
     */
    public function setPrixada(string $prixada): void
    {
        $this->prixada = $prixada;
    }

    /**
     * @return string
     */
    public function getPrixzza(): string
    {
        return $this->prixzza;
    }

    /**
     * @param string $prixzza
     */
    public function setPrixzza(string $prixzza): void
    {
        $this->prixzza = $prixzza;
    }

    /**
     * @return string
     */
    public function getPrixbba(): string
    {
        return $this->prixbba;
    }

    /**
     * @param string $prixbba
     */
    public function setPrixbba(string $prixbba): void
    {
        $this->prixbba = $prixbba;
    }

    /**
     * @return string
     */
    public function getTaxea(): string
    {
        return $this->taxea;
    }

    /**
     * @param string $taxea
     */
    public function setTaxea(string $taxea): void
    {
        $this->taxea = $taxea;
    }

    /**
     * @return string
     */
    public function getPrixadv(): string
    {
        return $this->prixadv;
    }

    /**
     * @param string $prixadv
     */
    public function setPrixadv(string $prixadv): void
    {
        $this->prixadv = $prixadv;
    }

    /**
     * @return string
     */
    public function getPrixzzv(): string
    {
        return $this->prixzzv;
    }

    /**
     * @param string $prixzzv
     */
    public function setPrixzzv(string $prixzzv): void
    {
        $this->prixzzv = $prixzzv;
    }

    /**
     * @return string
     */
    public function getPrixbbv(): string
    {
        return $this->prixbbv;
    }

    /**
     * @param string $prixbbv
     */
    public function setPrixbbv(string $prixbbv): void
    {
        $this->prixbbv = $prixbbv;
    }

    /**
     * @return string
     */
    public function getPrixadv2(): string
    {
        return $this->prixadv2;
    }

    /**
     * @param string $prixadv2
     */
    public function setPrixadv2(string $prixadv2): void
    {
        $this->prixadv2 = $prixadv2;
    }

    /**
     * @return string
     */
    public function getPrixzzv2(): string
    {
        return $this->prixzzv2;
    }

    /**
     * @param string $prixzzv2
     */
    public function setPrixzzv2(string $prixzzv2): void
    {
        $this->prixzzv2 = $prixzzv2;
    }

    /**
     * @return string
     */
    public function getPrixbbv2(): string
    {
        return $this->prixbbv2;
    }

    /**
     * @param string $prixbbv2
     */
    public function setPrixbbv2(string $prixbbv2): void
    {
        $this->prixbbv2 = $prixbbv2;
    }

    /**
     * @return string
     */
    public function getPrixadv3(): string
    {
        return $this->prixadv3;
    }

    /**
     * @param string $prixadv3
     */
    public function setPrixadv3(string $prixadv3): void
    {
        $this->prixadv3 = $prixadv3;
    }

    /**
     * @return string
     */
    public function getPrixzzv3(): string
    {
        return $this->prixzzv3;
    }

    /**
     * @param string $prixzzv3
     */
    public function setPrixzzv3(string $prixzzv3): void
    {
        $this->prixzzv3 = $prixzzv3;
    }

    /**
     * @return string
     */
    public function getPrixbbv3(): string
    {
        return $this->prixbbv3;
    }

    /**
     * @param string $prixbbv3
     */
    public function setPrixbbv3(string $prixbbv3): void
    {
        $this->prixbbv3 = $prixbbv3;
    }

    /**
     * @return string
     */
    public function getSupp1(): string
    {
        return $this->supp1;
    }

    /**
     * @param string $supp1
     */
    public function setSupp1(string $supp1): void
    {
        $this->supp1 = $supp1;
    }

    /**
     * @return string
     */
    public function getSupp2(): string
    {
        return $this->supp2;
    }

    /**
     * @param string $supp2
     */
    public function setSupp2(string $supp2): void
    {
        $this->supp2 = $supp2;
    }

    /**
     * @return string
     */
    public function getTaxevente(): string
    {
        return $this->taxevente;
    }

    /**
     * @param string $taxevente
     */
    public function setTaxevente(string $taxevente): void
    {
        $this->taxevente = $taxevente;
    }

    /**
     * @return string
     */
    public function getCartevente(): string
    {
        return $this->cartevente;
    }

    /**
     * @param string $cartevente
     */
    public function setCartevente(string $cartevente): void
    {
        $this->cartevente = $cartevente;
    }

    /**
     * @return string
     */
    public function getTaxesovente(): string
    {
        return $this->taxesovente;
    }

    /**
     * @param string $taxesovente
     */
    public function setTaxesovente(string $taxesovente): void
    {
        $this->taxesovente = $taxesovente;
    }

    /**
     * @return string
     */
    public function getSuppvol(): string
    {
        return $this->suppvol;
    }

    /**
     * @param string $suppvol
     */
    public function setSuppvol(string $suppvol): void
    {
        $this->suppvol = $suppvol;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateconvo(): ?\DateTimeInterface
    {
        return $this->dateconvo;
    }

    /**
     * @param \DateTimeInterface|null $dateconvo
     */
    public function setDateconvo(?\DateTimeInterface $dateconvo): void
    {
        $this->dateconvo = $dateconvo;
    }

    public function getHeureconvo(): ?string
    {
        return $this->heureconvo;
    }

    public function setHeureconvo(?string $heureconvo): self
    {
        $this->heureconvo = $heureconvo;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getLieuconvo(): ?string
    {
        return $this->lieuconvo;
    }

    /**
     * @param ?string $lieuconvo
     */
    public function setLieuconvo(?string $lieuconvo): void
    {
        $this->lieuconvo = $lieuconvo;
    }

    /**
     * @return string
     */
    public function getComptoir(): ?string
    {
        return $this->comptoir;
    }

    /**
     * @param string $comptoir
     */
    public function setComptoir(?string $comptoir): void
    {
        $this->comptoir = $comptoir;
    }

    /**
     * @return string
     */
    public function getPorte(): ?string
    {
        return $this->porte;
    }

    /**
     * @param string $porte
     */
    public function setPorte(?string $porte): void
    {
        $this->porte = $porte;
    }

    /**
     * @return string
     */
    public function getAgence(): ?string
    {
        return $this->agence;
    }

    /**
     * @param string $agence
     */
    public function setAgence(?string $agence): void
    {
        $this->agence = $agence;
    }

    /**
     * @return string
     */
    public function getTelagence(): ?string
    {
        return $this->telagence;
    }

    /**
     * @param string $telagence
     */
    public function setTelagence(?string $telagence): void
    {
        $this->telagence = $telagence;
    }

    /**
     * @return string
     */
    public function getFormforf(): ?string
    {
        return $this->formforf;
    }

    /**
     * @param string $formforf
     */
    public function setFormforf(?string $formforf): void
    {
        $this->formforf = $formforf;
    }

    /**
     * @return string
     */
    public function getFormsec(): ?string
    {
        return $this->formsec;
    }

    /**
     * @param string $formsec
     */
    public function setFormsec(?string $formsec): void
    {
        $this->formsec = $formsec;
    }

    /**
     * @return string
     */
    public function getObs(): ?string
    {
        return $this->obs;
    }

    /**
     * @param string $obs
     */
    public function setObs(?string $obs): void
    {
        $this->obs = $obs;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateconf(): ?\DateTimeInterface
    {
        return $this->dateconf;
    }

    /**
     * @param \DateTimeInterface|null $dateconf
     */
    public function setDateconf(?\DateTimeInterface $dateconf): void
    {
        $this->dateconf = $dateconf;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDatedeconf(): ?\DateTimeInterface
    {
        return $this->datedeconf;
    }

    /**
     * @param \DateTimeInterface|null $datedeconf
     */
    public function setDatedeconf(?\DateTimeInterface $datedeconf): void
    {
        $this->datedeconf = $datedeconf;
    }

    /**
     * @return int
     */
    public function getFreesale(): int
    {
        return $this->freesale;
    }

    /**
     * @param int $freesale
     */
    public function setFreesale(int $freesale): void
    {
        $this->freesale = $freesale;
    }

    /**
     * @return string
     */
    public function getAssvol(): string
    {
        return $this->assvol;
    }

    /**
     * @param string $assvol
     */
    public function setAssvol(string $assvol): void
    {
        $this->assvol = $assvol;
    }

    /**
     * @return int
     */
    public function getOuvert(): int
    {
        return $this->ouvert;
    }

    /**
     * @param int $ouvert
     */
    public function setOuvert(int $ouvert): void
    {
        $this->ouvert = $ouvert;
    }

    /**
     * @return string
     */
    public function getTaxea2(): string
    {
        return $this->taxea2;
    }

    /**
     * @param string $taxea2
     */
    public function setTaxea2(string $taxea2): void
    {
        $this->taxea2 = $taxea2;
    }

    /**
     * @return string
     */
    public function getAutres(): string
    {
        return $this->autres;
    }

    /**
     * @param string $autres
     */
    public function setAutres(string $autres): void
    {
        $this->autres = $autres;
    }

    /**
     * @return int
     */
    public function getCoaf(): int
    {
        return $this->coaf;
    }

    /**
     * @param int $coaf
     */
    public function setCoaf(int $coaf): void
    {
        $this->coaf = $coaf;
    }

    /**
     * @return int
     */
    public function getFictif(): int
    {
        return $this->fictif;
    }

    /**
     * @param int $fictif
     */
    public function setFictif(int $fictif): void
    {
        $this->fictif = $fictif;
    }

    /**
     * @return int
     */
    public function getLien(): int
    {
        return $this->lien;
    }

    /**
     * @param int $lien
     */
    public function setLien(int $lien): void
    {
        $this->lien = $lien;
    }

    /**
     * @return string
     */
    public function getTypeavion(): string
    {
        return $this->typeavion;
    }

    /**
     * @param string $typeavion
     */
    public function setTypeavion(string $typeavion): void
    {
        $this->typeavion = $typeavion;
    }

    /**
     * @return string
     */
    public function getCompagnie(): string
    {
        return $this->compagnie;
    }

    /**
     * @param string $compagnie
     */
    public function setCompagnie(string $compagnie): void
    {
        $this->compagnie = $compagnie;
    }


    /**
     * @return string
     */
    public function getTaxesolidarite(): string
    {
        return $this->taxesolidarite;
    }

    /**
     * @param string $taxesolidarite
     */
    public function setTaxesolidarite(string $taxesolidarite): void
    {
        $this->taxesolidarite = $taxesolidarite;
    }

    /**
     * @return string
     */
    public function getNomaxe(): string
    {
        return $this->nomaxe;
    }

    /**
     * @param string $nomaxe
     */
    public function setNomaxe(string $nomaxe): void
    {
        $this->nomaxe = $nomaxe;
    }

    /**
     * @return int
     */
    public function getRetro(): int
    {
        return $this->retro;
    }

    /**
     * @param int $retro
     */
    public function setRetro(int $retro): void
    {
        $this->retro = $retro;
    }

    /**
     * @return int
     */
    public function getPaxRetro(): int
    {
        return $this->paxRetro;
    }

    /**
     * @param int $paxRetro
     */
    public function setPaxRetro(int $paxRetro): void
    {
        $this->paxRetro = $paxRetro;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDatRetro(): ?\DateTimeInterface
    {
        return $this->datRetro;
    }

    /**
     * @param \DateTimeInterface|null $datRetro
     */
    public function setDatRetro(?\DateTimeInterface $datRetro): void
    {
        $this->datRetro = $datRetro;
    }

    /**
     * @return string
     */
    public function getHeuredv(): string
    {
        return $this->heuredv;
    }

    /**
     * @param string $heuredv
     */
    public function setHeuredv(string $heuredv): void
    {
        $this->heuredv = $heuredv;
    }

    /**
     * @return string
     */
    public function getHeureav(): string
    {
        return $this->heureav;
    }

    /**
     * @param string $heureav
     */
    public function setHeureav(string $heureav): void
    {
        $this->heureav = $heureav;
    }

    /**
     * @return string
     */
    public function getDureevol(): string
    {
        return $this->dureevol;
    }

    /**
     * @param string $dureevol
     */
    public function setDureevol(string $dureevol): void
    {
        $this->dureevol = $dureevol;
    }

    /**
     * @return int
     */
    public function getConvoWeb(): int
    {
        return $this->convoWeb;
    }

    /**
     * @param int $convoWeb
     */
    public function setConvoWeb(int $convoWeb): void
    {
        $this->convoWeb = $convoWeb;
    }

    /**
     * @return string
     */
    public function getObsResa(): string
    {
        return $this->obsResa;
    }

    /**
     * @param string $obsResa
     */
    public function setObsResa(string $obsResa): void
    {
        $this->obsResa = $obsResa;
    }

    /**
     * @return int
     */
    public function getPaxEmbarque(): int
    {
        return $this->paxEmbarque;
    }

    /**
     * @param int $paxEmbarque
     */
    public function setPaxEmbarque(int $paxEmbarque): void
    {
        $this->paxEmbarque = $paxEmbarque;
    }

    /**
     * @return string
     */
    public function getHeureEmbarque(): string
    {
        return $this->heureEmbarque;
    }

    /**
     * @param string $heureEmbarque
     */
    public function setHeureEmbarque(string $heureEmbarque): void
    {
        $this->heureEmbarque = $heureEmbarque;
    }

    /**
     * @return int
     */
    public function getPrestAbord(): int
    {
        return $this->prestAbord;
    }

    /**
     * @param int $prestAbord
     */
    public function setPrestAbord(int $prestAbord): void
    {
        $this->prestAbord = $prestAbord;
    }

    /**
     * @return int
     */
    public function getStockg(): int
    {
        return $this->stockg;
    }

    /**
     * @param int $stockg
     */
    public function setStockg(int $stockg): void
    {
        $this->stockg = $stockg;
    }

    /**
     * @return string
     */
    public function getVilledd(): string
    {
        return $this->villedd;
    }

    /**
     * @param string $villedd
     */
    public function setVilledd(string $villedd): void
    {
        $this->villedd = $villedd;
    }

    /**
     * @return string
     */
    public function getVilleaa(): string
    {
        return $this->villeaa;
    }

    /**
     * @param string $villeaa
     */
    public function setVilleaa(string $villeaa): void
    {
        $this->villeaa = $villeaa;
    }

    /**
     * @return int
     */
    public function getVendug(): int
    {
        return $this->vendug;
    }

    /**
     * @param int $vendug
     */
    public function setVendug(int $vendug): void
    {
        $this->vendug = $vendug;
    }

    /**
     * @return string
     */
    public function getInclusSg(): string
    {
        return $this->inclusSg;
    }

    /**
     * @param string $inclusSg
     */
    public function setInclusSg(string $inclusSg): void
    {
        $this->inclusSg = $inclusSg;
    }

    /**
     * @return int
     */
    public function getCron(): int
    {
        return $this->cron;
    }

    /**
     * @param int $cron
     */
    public function setCron(int $cron): void
    {
        $this->cron = $cron;
    }

    /**
     * @return int
     */
    public function getSoustock(): int
    {
        return $this->soustock;
    }

    /**
     * @param int $soustock
     */
    public function setSoustock(int $soustock): void
    {
        $this->soustock = $soustock;
    }

    /**
     * @return int
     */
    public function getReserves(): int
    {
        return $this->reserves;
    }

    /**
     * @param int $reserves
     */
    public function setReserves(int $reserves): void
    {
        $this->reserves = $reserves;
    }

    /**
     * @return int
     */
    public function getVendus(): int
    {
        return $this->vendus;
    }

    /**
     * @param int $vendus
     */
    public function setVendus(int $vendus): void
    {
        $this->vendus = $vendus;
    }

    /**
     * @return int
     */
    public function getEngagement(): int
    {
        return $this->engagement;
    }

    /**
     * @param int $engagement
     */
    public function setEngagement(int $engagement): void
    {
        $this->engagement = $engagement;
    }

    /**
     * @return int
     */
    public function getSeqvolGenerique(): int
    {
        return $this->seqvolGenerique;
    }

    /**
     * @param int $seqvolGenerique
     */
    public function setSeqvolGenerique(int $seqvolGenerique): void
    {
        $this->seqvolGenerique = $seqvolGenerique;
    }

    /**
     * @return string
     */
    public function getCodaffret1(): string
    {
        return $this->codaffret1;
    }

    /**
     * @param string $codaffret1
     */
    public function setCodaffret1(string $codaffret1): void
    {
        $this->codaffret1 = $codaffret1;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return int
     */
    public function getNature(): int
    {
        return $this->nature;
    }

    /**
     * @param int $nature
     */
    public function setNature(int $nature): void
    {
        $this->nature = $nature;
    }

    /**
     * @return string
     */
    public function getNvol2(): string
    {
        return $this->nvol2;
    }

    /**
     * @param string $nvol2
     */
    public function setNvol2(string $nvol2): void
    {
        $this->nvol2 = $nvol2;
    }

    /**
     * @return string
     */
    public function getTaxev(): string
    {
        return $this->taxev;
    }

    /**
     * @param string $taxev
     */
    public function setTaxev(string $taxev): void
    {
        $this->taxev = $taxev;
    }

    /**
     * @return string
     */
    public function getTaxesolidaritev(): string
    {
        return $this->taxesolidaritev;
    }

    /**
     * @param string $taxesolidaritev
     */
    public function setTaxesolidaritev(string $taxesolidaritev): void
    {
        $this->taxesolidaritev = $taxesolidaritev;
    }

    /**
     * @return string
     */
    public function getTaxesoventev(): string
    {
        return $this->taxesoventev;
    }

    /**
     * @param string $taxesoventev
     */
    public function setTaxesoventev(string $taxesoventev): void
    {
        $this->taxesoventev = $taxesoventev;
    }

    /**
     * @return string
     */
    public function getTotaltaxea(): string
    {
        return $this->totaltaxea;
    }

    /**
     * @param string $totaltaxea
     */
    public function setTotaltaxea(string $totaltaxea): void
    {
        $this->totaltaxea = $totaltaxea;
    }

    /**
     * @return string
     */
    public function getPrixadulte(): string
    {
        return $this->prixadulte;
    }

    /**
     * @param string $prixadulte
     */
    public function setPrixadulte(string $prixadulte): void
    {
        $this->prixadulte = $prixadulte;
    }

    /**
     * @return string
     */
    public function getCodaffret2(): string
    {
        return $this->codaffret2;
    }

    /**
     * @param string $codaffret2
     */
    public function setCodaffret2(string $codaffret2): void
    {
        $this->codaffret2 = $codaffret2;
    }

    /**
     * @return int
     */
    public function getMaxVolsecAlloue(): int
    {
        return $this->maxVolsecAlloue;
    }

    /**
     * @param int $maxVolsecAlloue
     */
    public function setMaxVolsecAlloue(int $maxVolsecAlloue): void
    {
        $this->maxVolsecAlloue = $maxVolsecAlloue;
    }

    /**
     * @return string
     */
    public function getNvolvia(): string
    {
        return $this->nvolvia;
    }

    /**
     * @param string $nvolvia
     */
    public function setNvolvia(string $nvolvia): void
    {
        $this->nvolvia = $nvolvia;
    }

    /**
     * @return string
     */
    public function getObsVia(): string
    {
        return $this->obsVia;
    }

    /**
     * @param string $obsVia
     */
    public function setObsVia(string $obsVia): void
    {
        $this->obsVia = $obsVia;
    }

    /**
     * @return int
     */
    public function getAffecter(): int
    {
        return $this->affecter;
    }

    /**
     * @param int $affecter
     */
    public function setAffecter(int $affecter): void
    {
        $this->affecter = $affecter;
    }

    /**
     * @return int
     */
    public function getFreesale1(): int
    {
        return $this->freesale1;
    }

    /**
     * @param int $freesale1
     */
    public function setFreesale1(int $freesale1): void
    {
        $this->freesale1 = $freesale1;
    }

    /**
     * @return int
     */
    public function getTotMaxVolsec(): int
    {
        return $this->totMaxVolsec;
    }

    /**
     * @param int $totMaxVolsec
     */
    public function setTotMaxVolsec(int $totMaxVolsec): void
    {
        $this->totMaxVolsec = $totMaxVolsec;
    }

    /**
     * @return int
     */
    public function getTotFreesale(): int
    {
        return $this->totFreesale;
    }

    /**
     * @param int $totFreesale
     */
    public function setTotFreesale(int $totFreesale): void
    {
        $this->totFreesale = $totFreesale;
    }

    /**
     * @return int
     */
    public function getSeqreceptif(): int
    {
        return $this->seqreceptif;
    }

    /**
     * @param int $seqreceptif
     */
    public function setSeqreceptif(int $seqreceptif): void
    {
        $this->seqreceptif = $seqreceptif;
    }

    /**
     * @return int
     */
    public function getRachatImmediat(): int
    {
        return $this->rachatImmediat;
    }

    /**
     * @param int $rachatImmediat
     */
    public function setRachatImmediat(int $rachatImmediat): void
    {
        $this->rachatImmediat = $rachatImmediat;
    }

    /**
     * @return int
     */
    public function getSeqvilled(): int
    {
        return $this->seqvilled;
    }

    /**
     * @param int $seqvilled
     */
    public function setSeqvilled(int $seqvilled): void
    {
        $this->seqvilled = $seqvilled;
    }

    /**
     * @return int
     */
    public function getSeqvillea(): int
    {
        return $this->seqvillea;
    }

    /**
     * @param int $seqvillea
     */
    public function setSeqvillea(int $seqvillea): void
    {
        $this->seqvillea = $seqvillea;
    }

    /**
     * @return int
     */
    public function getSeqvillev(): int
    {
        return $this->seqvillev;
    }

    /**
     * @param int $seqvillev
     */
    public function setSeqvillev(int $seqvillev): void
    {
        $this->seqvillev = $seqvillev;
    }

    /**
     * @return int
     */
    public function getSeqaffret1(): int
    {
        return $this->seqaffret1;
    }

    /**
     * @param int $seqaffret1
     */
    public function setSeqaffret1(int $seqaffret1): void
    {
        $this->seqaffret1 = $seqaffret1;
    }

    /**
     * @return int
     */
    public function getSeqaffret2(): int
    {
        return $this->seqaffret2;
    }

    /**
     * @param int $seqaffret2
     */
    public function setSeqaffret2(int $seqaffret2): void
    {
        $this->seqaffret2 = $seqaffret2;
    }

    /**
     * @return int
     */
    public function getAffecters(): int
    {
        return $this->affecters;
    }

    /**
     * @param int $affecters
     */
    public function setAffecters(int $affecters): void
    {
        $this->affecters = $affecters;
    }

    /**
     * @return int
     */
    public function getBoardingPass(): int
    {
        return $this->boardingPass;
    }

    /**
     * @param int $boardingPass
     */
    public function setBoardingPass(int $boardingPass): void
    {
        $this->boardingPass = $boardingPass;
    }

    /**
     * @return int
     */
    public function getBagagesoption(): int
    {
        return $this->bagagesoption;
    }

    /**
     * @param int $bagagesoption
     */
    public function setBagagesoption(int $bagagesoption): void
    {
        $this->bagagesoption = $bagagesoption;
    }

    /**
     * @return string
     */
    public function getPrixbagagesoption(): string
    {
        return $this->prixbagagesoption;
    }

    /**
     * @param string $prixbagagesoption
     */
    public function setPrixbagagesoption(string $prixbagagesoption): void
    {
        $this->prixbagagesoption = $prixbagagesoption;
    }

    /**
     * @return int
     */
    public function getNbrbagagesoption(): int
    {
        return $this->nbrbagagesoption;
    }

    /**
     * @param int $nbrbagagesoption
     */
    public function setNbrbagagesoption(int $nbrbagagesoption): void
    {
        $this->nbrbagagesoption = $nbrbagagesoption;
    }

    /**
     * @return string
     */
    public function getPnr(): ?string
    {
        return $this->pnr;
    }

    public function setPnr(?string $pnr): self
    {
        $this->pnr = $pnr;
        return $this;
    }
    /**
     * @return int
     */
    public function getEtablissement(): int
    {
        return $this->etablissement;
    }

    /**
     * @param int $etablissement
     */
    public function setEtablissement(int $etablissement): void
    {
        $this->etablissement = $etablissement;
    }

    /**
     * @return int
     */
    public function getNatureVol(): int
    {
        return $this->natureVol;
    }

    /**
     * @param int $natureVol
     */
    public function setNatureVol(int $natureVol): void
    {
        $this->natureVol = $natureVol;
    }

    /**
     * @return int
     */
    public function getArchiver(): int
    {
        return $this->archiver;
    }

    /**
     * @param int $archiver
     */
    public function setArchiver(int $archiver): void
    {
        $this->archiver = $archiver;
    }

    /**
     * @return int
     */
    public function getKilocabine(): int
    {
        return $this->kilocabine;
    }

    /**
     * @param int $kilocabine
     */
    public function setKilocabine(int $kilocabine): void
    {
        $this->kilocabine = $kilocabine;
    }

    /**
     * @return string
     */
    public function getPrixYield(): string
    {
        return $this->prixYield;
    }

    /**
     * @param string $prixYield
     */
    public function setPrixYield(string $prixYield): void
    {
        $this->prixYield = $prixYield;
    }

    /**
     * @return string
     */
    public function getAerod(): string
    {
        return $this->aerod;
    }

    /**
     * @param string $aerod
     */
    public function setAerod(string $aerod): void
    {
        $this->aerod = $aerod;
    }

    /**
     * @return string
     */
    public function getAeroa(): string
    {
        return $this->aeroa;
    }

    /**
     * @param string $aeroa
     */
    public function setAeroa(string $aeroa): void
    {
        $this->aeroa = $aeroa;
    }

    /**
     * @return int
     */
    public function getPasAfficherHoraire(): int
    {
        return $this->pasAfficherHoraire;
    }

    /**
     * @param int $pasAfficherHoraire
     */
    public function setPasAfficherHoraire(int $pasAfficherHoraire): void
    {
        $this->pasAfficherHoraire = $pasAfficherHoraire;
    }

    /**
     * @return string
     */
    public function getKilobebe(): string
    {
        return $this->kilobebe;
    }

    /**
     * @param string $kilobebe
     */
    public function setKilobebe(string $kilobebe): void
    {
        $this->kilobebe = $kilobebe;
    }

    /**
     * @return string
     */
    public function getAerodep(): string
    {
        return $this->aerodep;
    }

    /**
     * @param string $aerodep
     */
    public function setAerodep(string $aerodep): void
    {
        $this->aerodep = $aerodep;
    }

    /**
     * @return string
     */
    public function getAeroarr(): string
    {
        return $this->aeroarr;
    }

    /**
     * @param string $aeroarr
     */
    public function setAeroarr(string $aeroarr): void
    {
        $this->aeroarr = $aeroarr;
    }

    /**
     * @return int
     */
    public function getSpecification(): int
    {
        return $this->specification;
    }

    /**
     * @param int $specification
     */
    public function setSpecification(int $specification): void
    {
        $this->specification = $specification;
    }


    /**
     * @return int
     */
    public function getCoafv(): int
    {
        return $this->coafv;
    }

    /**
     * @param int $coafv
     */
    public function setCoafv(int $coafv): void
    {
        $this->coafv = $coafv;
    }

    public function getVolsec(): bool
    {
        return (bool) $this->volsec;
    }


    public function setVolsec(bool $volsec): self
    {
        $this->volsec = $volsec ? 1 : 0;
        return $this;
    }
    public function getVenduVolsec(): bool
    {
        return (bool) $this->venduVolsec;
    }


    public function setVenduVolsec(bool $venduVolsec): self
    {
        $this->venduVolsec = $venduVolsec ? 1 : 0;
        return $this;
    }

    public function getBagagesoute(): bool
    {
        return (bool) $this->bagagesoute;
    }


    public function setBagagesoute(bool $bagagesoute): self
    {
        $this->bagagesoute = $bagagesoute ? 1 : 0;
        return $this;
    }
    public function getAllotFreesale(): bool
    {
        return (bool) $this->allotFreesale;
    }

    public function setAllotFreesale(bool $allotFreesale): self
    {
        $this->allotFreesale = $allotFreesale ? 1 : 0;
        return $this;
    }


    public function getStopsale(): bool
    {
        return (bool) $this->stopsale;
    }

    public function setStopsale(bool $stopsale): self
    {
        $this->stopsale = $stopsale ? 1 : 0;
        return $this;
    }


    /**
     * @return string
     */
    public function getRetroVol(): string
    {
        return $this->retroVol;
    }

    /**
     * @param string $retroVol
     */
    public function setRetroVol(string $retroVol): void
    {
        $this->retroVol = $retroVol;
    }

    /**
     * @return string
     */
    public function getPrixada2(): string
    {
        return $this->prixada2;
    }

    /**
     * @param string $prixada2
     */
    public function setPrixada2(string $prixada2): void
    {
        $this->prixada2 = $prixada2;
    }

    /**
     * @return string
     */
    public function getPrixada3(): string
    {
        return $this->prixada3;
    }

    /**
     * @param string $prixada3
     */
    public function setPrixada3(string $prixada3): void
    {
        $this->prixada3 = $prixada3;
    }

    /**
     * @return string
     */
    public function getPrixzza2(): string
    {
        return $this->prixzza2;
    }

    /**
     * @param string $prixzza2
     */
    public function setPrixzza2(string $prixzza2): void
    {
        $this->prixzza2 = $prixzza2;
    }

    /**
     * @return string
     */
    public function getPrixzza3(): string
    {
        return $this->prixzza3;
    }

    /**
     * @param string $prixzza3
     */
    public function setPrixzza3(string $prixzza3): void
    {
        $this->prixzza3 = $prixzza3;
    }

    /**
     * @return string
     */
    public function getPrixbba2(): string
    {
        return $this->prixbba2;
    }

    /**
     * @param string $prixbba2
     */
    public function setPrixbba2(string $prixbba2): void
    {
        $this->prixbba2 = $prixbba2;
    }

    /**
     * @return string
     */
    public function getPrixbba3(): string
    {
        return $this->prixbba3;
    }

    /**
     * @param string $prixbba3
     */
    public function setPrixbba3(string $prixbba3): void
    {
        $this->prixbba3 = $prixbba3;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getNomfour(): string
    {
        return $this->nomfour;
    }

    /**
     * @param string $nomfour
     */
    public function setNomfour(?string $nomfour): void
    {
        $this->nomfour = $nomfour;
    }
    /**
     * @return int
     */
    public function getSemaine1(): int
    {
        return $this->semaine1;
    }

    /**
     * @param int $semaine1
     */
    public function setSemaine1(int $semaine1): void
    {
        $this->semaine1 = $semaine1;
    }

    /**
     * @return int
     */
    public function getBlocsiege(): int
    {
        return $this->blocsiege;
    }

    /**
     * @param int $blocsiege
     */
    public function setBlocsiege(int $blocsiege): void
    {
        $this->blocsiege = $blocsiege;
    }

    /**
     * @return string
     */
    public function getPrixadav(): string
    {
        return $this->prixadav;
    }

    /**
     * @param string $prixadav
     */
    public function setPrixadav(string $prixadav): void
    {
        $this->prixadav = $prixadav;
    }

    /**
     * @return string
     */
    public function getPrixbbav(): string
    {
        return $this->prixbbav;
    }

    /**
     * @param string $prixbbav
     */
    public function setPrixbbav(string $prixbbav): void
    {
        $this->prixbbav = $prixbbav;
    }

    /**
     * @return string
     */
    public function getPrixzzav(): string
    {
        return $this->prixzzav;
    }

    /**
     * @param string $prixzzav
     */
    public function setPrixzzav(string $prixzzav): void
    {
        $this->prixzzav = $prixzzav;
    }

    /**
     * @return string
     */
    public function getTaxeB2b(): string
    {
        return $this->taxeB2b;
    }

    /**
     * @param string $taxeB2b
     */
    public function setTaxeB2b(string $taxeB2b): void
    {
        $this->taxeB2b = $taxeB2b;
    }

    public function getFerry(): ?int
    {
        return $this->ferry;
    }

    public function setFerry(?int $ferry): self
    {
        $this->ferry = $ferry;
        return $this;
    }

    /**
     * @return int
     */
    public function getSgGarantis(): int
    {
        return $this->sgGarantis;
    }

    /**
     * @param int $sgGarantis
     */
    public function setSgGarantis(int $sgGarantis): void
    {
        $this->sgGarantis = $sgGarantis;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRetrocede(): ?\DateTimeInterface
    {
        return $this->retrocede;
    }

    /**
     * @param \DateTimeInterface|null $retrocede
     */
    public function setRetrocede(?\DateTimeInterface $retrocede): void
    {
        $this->retrocede = $retrocede;
    }
    public function getVilleD(): ?Ville
    {
        return $this->villeD;
    }

    public function setVilleD(?Ville $villeD): self
    {
        $this->villeD = $villeD;
        return $this;
    }

    public function getVilleA(): ?Ville
    {
        return $this->villeA;
    }

    public function setVilleA(?Ville $villeA): self
    {
        $this->villeA = $villeA;
        return $this;
    }
    public function getVilleV(): ?Ville
    {
        return $this->villeV;
    }

    public function setVilleV(?Ville $villeV): self
    {
        $this->villeV = $villeV;
        return $this;
    }



    // Continue with all other getters and setters...
    // Each property should have a getter and setter method

    public function getIDPAYS(): ?Pays
    {
        return $this->IDPAYS;
    }

    public function setIDPAYS(?Pays $IDPAYS): static
    {
        $this->IDPAYS = $IDPAYS;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDatevolau(): ?\DateTimeInterface { return $this->datevolau; }
    public function setDatevolau(?\DateTimeInterface $d): self { $this->datevolau = $d; return $this; }

}