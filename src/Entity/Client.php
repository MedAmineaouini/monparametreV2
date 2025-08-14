<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'CLIENT')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'NUMCLT', type: Types::INTEGER)]
    private ?int $numclt = null;

    #[ORM\Column(name: 'SEQCLT', type: Types::STRING, length: 6, nullable: true,unique: true,options: ['default' => ''])]
    private ?string $seqclt = '';

    #[ORM\Column(name: 'SOUSRESEAU', type: Types::STRING, length: 50,nullable: true, options: ['default' => ''])]
    private ?string $sousreseau = '';
    
    #[ORM\Column(name: 'SEQCLTPACKDB', type: Types::INTEGER, nullable: true,options: ['default' => 0])]
    private ?int $seqcltpackdb = 0;
    
    
    // #[ORM\Column(name: 'REFPACKDB', type: Types::STRING, length: 6, nullable: true,options: ['default' => ''])]
    // private ?string $refpackdb = '';
    
    #[ORM\Column(name: 'NOMCLT', type: Types::STRING, length: 50, nullable: true, options: ['default' => ''])]
    private ?string $nomclt = '';
    
    #[ORM\Column(name: 'ADRESSE', type: Types::STRING, length: 80, nullable: true, options: ['default' => ''])]
    private ?string $adresse = '';
    
    #[ORM\Column(name: 'CP', type: Types::STRING, length: 6, nullable: true, options: ['default' => ''])]
    private ?string $cp = '';
    
    #[ORM\Column(name: 'TEL1', type: Types::STRING, length: 20, nullable: true, options: ['default' => ''])]
    private ?string $tel1 = '';
    
    #[ORM\Column(name: 'TEL2', type: Types::STRING, length: 20, nullable: true, options: ['default' => ''])]
    private ?string $tel2 = '';
    
    #[ORM\Column(name: 'TEL3', type: Types::STRING, length: 20,nullable: true, options: ['default' => ''])]
    private ?string $tel3 = '';
    
    #[ORM\Column(name: 'FAX', type: Types::STRING, length: 20, nullable: true, options: ['default' => ''])]
    private ?string $fax = '';

    #[ORM\Column(name: 'EMAIL', type: Types::STRING, length: 150, nullable: true,options: ['default' => ''])]
    private ?string $email = '';
    
    #[ORM\Column(name: 'PATRON', type: Types::STRING, length: 60, nullable: true,options: ['default' => ''])]
    private ?string $patron = '';
    
    #[ORM\Column(name: 'CONTACT', type: Types::STRING, length: 60,nullable: true, options: ['default' => ''])]
    private ?string $contact = '';
    
    #[ORM\Column(name: 'CCOMPTA', type: Types::STRING, length: 8, nullable: true,options: ['default' => ''])]
    private ?string $ccompta = '';
    
    #[ORM\Column(name: 'COMMISS', type: Types::DECIMAL, precision: 6, scale: 2, nullable: true, options: ['default' => '0.00'])]
    private ?string $commiss = '0.00';
    
    #[ORM\Column(name: 'COMMISS2', type: Types::DECIMAL, precision: 5, scale: 2, nullable: true, options: ['default' => '0.00'])]
    private ?string $commiss2 = '0.00';
    
    #[ORM\Column(name: 'COMMISS3', type: Types::DECIMAL, precision: 5, scale: 2, nullable: true,options: ['default' => '0.00'])]
    private ?string $commiss3 ='0.00';
    
    #[ORM\Column(name: 'COMMISS4', type: Types::DECIMAL, precision: 5, scale: 2, nullable: true,options: ['default' => '0.00'])]
    private ?string $commiss4 = '0.00';
    
    #[ORM\Column(name: 'COMTTC', type: Types::INTEGER, nullable: true,options: ['default' => 0])]
    private ?int  $comttc = 0;
    
    #[ORM\Column(name: 'OBS', type: Types::TEXT,nullable: true, options: ['default' => ''])]
    private ?string $obs = '';
    
    #[ORM\Column(name: 'LIBRE', type: Types::INTEGER, nullable: true,options: ['default' => 0])]
    private ?int  $libre = 0;
    
    #[ORM\Column(name: 'CONFIRMATION', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $confirmation = 0;
    
    #[ORM\Column(name: 'FRAIS', type: Types::DECIMAL, precision: 7, scale: 2,nullable: true, options: ['default' => '0.00'])]
    private ?string $frais ='0.00';
    
    #[ORM\Column(name: 'TAXE', type: Types::DECIMAL, precision: 7, scale: 2, nullable: true,options: ['default' => '0.00'])]
    private ?string $taxe = '0.00';
    
    #[ORM\Column(name: 'CODECOMMERCIAL', type: Types::STRING, nullable: true,length: 4, options: ['default' => ''])]
    private ?string $codecommercial = '';

    
    #[ORM\Column(name: 'PAIEMENT', type: Types::INTEGER, nullable: true,options: ['default' => 0])]
    private ?int  $paiement = 0;
    
    #[ORM\Column(name: 'DATESAISIE', type: Types::DATETIME_MUTABLE,nullable: true,)]
    private \DateTimeInterface $datesaisie;
    
    #[ORM\Column(name: 'COMPTA', type: Types::STRING,nullable: true, length: 150, options: ['default' => ''])]
    private ?string $compta = '';
    
    #[ORM\Column(name: 'CONVOC', type: Types::STRING, nullable: true,length: 150, options: ['default' => ''])]
    private ?string $convoc = '';
    
    #[ORM\Column(name: 'RESA', type: Types::STRING, nullable: true,length: 150, options: ['default' => ''])]
    private ?string $resa = '';
    
    #[ORM\Column(name: 'TYPEREGLE', type: Types::STRING,nullable: true, length: 50, options: ['default' => ''])]
    private ?string $typeregle = '';
    
    #[ORM\Column(name: 'CCREDIT', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $ccredit = 0;
    
    #[ORM\Column(name: 'ADRESSE2', type: Types::STRING,nullable: true, length: 60, options: ['default' => ''])]
    private ?string $adresse2 = '';
    
    #[ORM\Column(name: 'PRINCIPAL', type: Types::STRING,nullable: true, length: 10, options: ['default' => ''])]
    private ?string $principal = '';
    
    #[ORM\Column(name: 'POINTCOM', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $pointcom = 0;
    
    #[ORM\Column(name: 'REFUNIQUE', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $refunique = 0;
    
    #[ORM\Column(name: 'GROUPECLIENT', type: Types::STRING,nullable: true, length: 50, options: ['default' => '' ] )]
    private ?string $groupeclient = '';
    
    #[ORM\Column(name: 'LITIGE', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $litige = 0;
    
    #[ORM\Column(name: 'LOGIN', type: Types::STRING, length: 10,nullable: true, options: ['default' => ''])]
    private ?string $login = '';
    
    #[ORM\Column(name: 'MDP', type: Types::STRING, length: 10,nullable: true, options: ['default' => ''])]
    private ?string $mdp = '';
    
    #[ORM\Column(name: 'CODEAMADEUS', type: Types::STRING, length: 10, nullable: true,options: ['default' => ''])]
    private ?string $codeamadeus = '';
    
    #[ORM\Column(name: 'ANNULATION_TECHNIQUE', type: Types::BOOLEAN,nullable: true, options: ['default' => 0])]
    private bool $annulationTechnique;
    
    #[ORM\Column(name: 'DELAI_AT', type: Types::INTEGER, nullable: true,options: ['default' => 0])]
    private ?int  $delaiAt = 0;
    
    #[ORM\Column(name: 'CARNETVOYAGE', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $carnetvoyage = 0;
    
    #[ORM\Column(name: 'ARCHIVER', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $archiver = 0;
    
    #[ORM\Column(name: 'LOGIN_GALILEO', type: Types::STRING,nullable: true, length: 10, options: ['default' => ''])]
    private ?string $loginGalileo = '';
    
    #[ORM\Column(name: 'MDP_GALILEO', type: Types::STRING, nullable: true,length: 10, options: ['default' => ''])]
    private ?string $mdpGalileo = '';
    
    #[ORM\Column(name: 'COULEUR', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $couleur = 0;
    
    #[ORM\Column(name: 'LIBCLASSIFICATION', type: Types::STRING, nullable: true,length: 20, options: ['default' => ''])]
    private ?string $libclassification = '';
    
    #[ORM\Column(name: 'CATEGORIE', type: Types::STRING, nullable: true,length: 2, options: ['default' => ''])]
    private ?string $categorie = '';
    
    #[ORM\Column(name: 'COMCOFFRET', type: Types::DECIMAL, nullable: true,precision: 7, scale: 2, options: ['default' => '0.00'])]
    private ?string $comcoffret = '0.00';
    
    #[ORM\Column(name: 'login_adpack', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $loginAdpack = '';
    
    #[ORM\Column(name: 'mdp_adpack', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $mdpAdpack = '';
    
    #[ORM\Column(name: 'CODE_AGENCE', type: Types::STRING,nullable: true, length: 10, options: ['default' => ''])]
    private ?string $codeAgence = '';
    
    #[ORM\Column(name: 'MOT_CLE', type: Types::STRING,nullable: true, length: 50, options: ['default' => ''])]
    private ?string $motCle = '';
    
    #[ORM\Column(name: 'LOGINBTOB', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $loginbtob = '';
    
    #[ORM\Column(name: 'MDPBTOB', type: Types::STRING, nullable: true,length: 30, options: ['default' => ''])]
    private ?string $mdpbtob = '';
    
    #[ORM\Column(name: 'ANALYTIQUE', type: Types::STRING,nullable: true, length: 14, options: ['default' => ''])]
    private ?string $analytique = '';
    
    #[ORM\Column(name: 'BASCULE_AUTO_REGLEMENT',nullable: true, type: Types::INTEGER, options: ['default' => 0])]
    private ?int  $basculeAutoReglement = 0;
    
    #[ORM\Column(name: 'DOC_LANGUE', type: Types::STRING,nullable: true, length: 2, options: ['default' => ''])]
    private ?string $docLangue = '';
    
    #[ORM\Column(name: 'ENVOI_MCTO_GESTOUR', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $envoiMctoGestour = 0;
    
    #[ORM\Column(name: 'NOMCLT2', type: Types::STRING,nullable: true, length: 50, options: ['default' => ''])]
    private ?string $nomclt2 = '';
    
    #[ORM\Column(name: 'CODEISO', type: Types::STRING,nullable: true, length: 15, options: ['default' => ''])]
    private ?string $codeiso = '';
    
    #[ORM\Column(name: 'MODEREGLT', type: Types::STRING, nullable: true,length: 20, options: ['default' => ''])]
    private ?string $modereglt = '';
    
    #[ORM\Column(name: 'ECHANCEMENT', type: Types::STRING,nullable: true, length: 12, options: ['default' => ''])]
    private ?string $echancement = '';
    
    #[ORM\Column(name: 'SIREN', type: Types::STRING,nullable: true, length: 15, options: ['default' => ''])]
    private ?string $siren = '';
    
    #[ORM\Column(name: 'SIRET', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $siret = '';
    
    #[ORM\Column(name: 'NUMTVA', type: Types::STRING, nullable: true,length: 20, options: ['default' => ''])]
    private ?string $numtva = '';
    
    #[ORM\Column(name: 'TYPEPERS', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $typepers = '';
    
    #[ORM\Column(name: 'GROUPERELANCE', type: Types::STRING,nullable: true, length: 20, options: ['default' => ''])]
    private ?string $grouperelance = '';
    

    #[ORM\Column(name: 'CLIENTPAYEUR', type: Types::STRING,nullable: true, length: 10, options: ['default' => ''])]
    private ?string $clientpayeur = '';
    
    #[ORM\Column(name: 'SEQTYPECLT', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $seqtypeclt = 0;
    
    #[ORM\Column(name: 'SEQRESEAU', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $seqreseau = 0;
    
    #[ORM\Column(name: 'SEQSOUSRESEAU', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $seqsousreseau = 0;
    
    #[ORM\Column(name: 'SEQTYPEREGLE', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    private ?int  $seqtyperegle = 0;
    // #[ORM\Column(name: 'SEQCOMM', type: Types::INTEGER,nullable: true, options: ['default' => 0])]
    // private ?int  $seqcomm = 0;
    
    #[ORM\Column(name: 'SEQCLIENT_PRINCIPAL', type: Types::INTEGER, nullable: true, options: ['default' => 0])]
    private ?int $seqclientPrincipal = null;
    
    #[ORM\Column(name: 'Commission', type: Types::INTEGER, nullable: true, options: ['default' => 0])]
    private ?int $commission = null;


    // #[ORM\ManyToOne(targetEntity: self::class)]
    // #[ORM\JoinColumn(name: 'SEQCLIENT_PRINCIPAL', referencedColumnName: 'SEQCLT', nullable: true, onDelete: 'SET NULL')]
    // private ?Client $clientPrincipal = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'VILLE', referencedColumnName: 'SEQVILLE', nullable: false)]
    private ?ville $VILLE = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'PAYS', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?pays $PAYS = null;

    #[ORM\ManyToOne(targetEntity: Commercial::class)]
    #[ORM\JoinColumn(name: 'SEQCOMMERCIAL', referencedColumnName: 'SEQCOMMERCIAL', nullable: false)]
    private ?Commercial $seqcommercial = null;

    #[ORM\ManyToOne(targetEntity: Typeregle::class)]
    #[ORM\JoinColumn(name: 'LIBTYPEREGLE', referencedColumnName: 'SEQTYPEREGLE', nullable: false)]
    private ?Typeregle $libtyperegle = null;

    #[ORM\ManyToOne(targetEntity: Commission::class)]
    #[ORM\JoinColumn(name: 'SEQCOMM', referencedColumnName: 'SEQCOMM', nullable: false)]
    private ?Commission $seqcomm = null;


    #[ORM\ManyToOne(targetEntity: Reseau::class)]
    #[ORM\JoinColumn(name: 'NOMRESEAU', referencedColumnName: 'SEQRESEAU', nullable: false)]
    private ?Reseau $nomreseau = null;

    #[ORM\ManyToOne(targetEntity: TypeClt::class)]
    #[ORM\JoinColumn(name: 'REFPACKDB', referencedColumnName: 'SEQTYPECLT', nullable: false)]
    private ?TypeClt $refpackdb = null;

    #[ORM\ManyToOne(targetEntity: GroupementClient::class)]
    #[ORM\JoinColumn(name: 'LIBTYPECLT', referencedColumnName: 'SEQGROUPEMENTCLIENT', nullable: false)]
    private ?GroupementClient $libtypeclt = null;

    public function __construct()
    {
        $this->subordonnes = new ArrayCollection();
        $this->datesaisie = new \DateTime();
        $this->clients = new ArrayCollection();
    }
    public function getNumclt(): ?int
    {
        return $this->numclt;
    }
    
    public function getSeqclt(): ?string
    {
        return $this->seqclt ?? '';
    }

    public function getCodeAgence(): ?string
    {
        return $this->codeAgence ?? '';
    }
    
       
    public function setCodeAgence(?string $codeAgence): self
    {
        $this->codeAgence = $codeAgence ?? '';
        return $this;
    }

    public function getMotCle(): ?string
    {
        return $this->motCle ?? '';
    }
    
       
    public function setMotCle(?string $motCle): self
    {
        $this->motCle = $motCle ?? '';
        return $this;
    }
    
    
    public function setSeqclt(?string $seqclt): self
    {
        $this->seqclt = $seqclt ?? '';
        return $this;
    }
    
    public function getSousreseau(): ?string
    {
        return $this->sousreseau ?? '';
    }
    
    public function setSousreseau(?string $sousreseau): self
    {
        $this->sousreseau = $sousreseau ?? '';
        return $this;
    }

    public function getNomreseau(): ?Reseau
    {
        return $this->nomreseau;
    }
    
    public function setNomreseau(?Reseau $nomreseau): self
    {
        $this->nomreseau = $nomreseau;
        return $this;
    }
    
    public function getSeqcltpackdb():?int
    {
        return $this->seqcltpackdb;
    }
    
    public function setSeqcltpackdb(int $seqcltpackdb): self
    {
        $this->seqcltpackdb = $seqcltpackdb;
        return $this;
    }

    public function getRefpackdb(): ?TypeClt
    {
        return $this->refpackdb;
    }

    public function setRefpackdb(?TypeClt $refpackdb): self
    {
        $this->refpackdb = $refpackdb;
        return $this;
    }

    
    public function getNomclt(): string
    {
        return $this->nomclt ?? '';
    }
    
    public function setNomclt(?string $nomclt): self
    {
        $this->nomclt = $nomclt ?? '';
        return $this;
    }
    
    public function getAdresse(): string
    {
        return $this->adresse ?? '';
    }
    
    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse ?? '';
        return $this;
    }
    
    public function getCp(): string
    {
        return $this->cp ?? ''; 
    }
    
    public function setCp(?string $cp): self
    {
        $this->cp = $cp ?? '';
        return $this;
    }
    
    public function getVILLE(): ?Ville
    {
        return $this->VILLE;
    }

    public function setVILLE(?Ville $VILLE): self
    {
        $this->VILLE = $VILLE;
        return $this;
    }

    public function getPAYS(): ?Pays
    {
        return $this->PAYS;
    }

    public function setPAYS(?Pays $PAYS): self
    {
        $this->PAYS = $PAYS;
        return $this;
    }

    
    public function getTel1(): string
    {
        return $this->tel1 ?? '';
    }
    
    public function setTel1(?string $tel1): self
    {
        $this->tel1 = $tel1 ?? '';
        return $this;
    }
    
    public function getTel2(): string
    {
        return $this->tel2 ?? '';
    }
    
    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2 ? preg_replace('/[^0-9+]/', '', $tel2) : '';
        return $this;
    }
    public function getTel3(): string
    {
        return $this->tel3 ?? '';
    }
    
    public function setTel3(?string $tel3): self
    {
        $this->tel3 = $tel3 ?? '';
        return $this;
    }

    
    public function getFax(): string
    {
        return $this->fax ?? '';
    }
    
    public function setFax(?string $fax): self
    {
        $this->fax = $fax ?? '';
        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email ?? '';
    }
    
    public function setEmail(?string $email): self
    {
        $this->email = $email ?? '';
        return $this;
    }
    
    public function getPatron(): ?string
    {
        return $this->patron ?? '';
    }
    
    public function setPatron(?string $patron): self
    {
        $this->patron = $patron?? '';
        return $this;
    }
    
    public function getContact():  ?string
    {
        return $this->contact?? '';
    }
    
    public function setContact(?string $contact): self
    {
        $this->contact = $contact?? '';
        return $this;
    }
    
    public function getCcompta():  ?string
    {
        return $this->ccompta?? '';
    }
    
    public function setCcompta(?string $ccompta): self
    {
        $this->ccompta = $ccompta?? '';
        return $this;
    }
    
    public function getCommiss():  ?string
    {
        return $this->commiss?? '';
    }
    
    public function getCommiss2(): ?string
    {
        return $this->commiss2?? '';
    }
    
    
    public function getCommiss3(): ?string
    {
        return $this->commiss3?? '';
    }
    
    public function setCommiss3(?string $commiss3): self
    {
        $this->commiss3 = $commiss3?? '';
        return $this;
    }
    
    public function getCommiss4(): ?string
    {
        return $this->commiss4?? '';
    }
    
    public function setCommiss4(?string $commiss4): self
    {
        $this->commiss4 = $commiss4?? '';
        return $this;
    }
    
    public function getComttc(): bool
    {
        return (bool) $this->comttc;
    }


    public function setComttc(bool $comttc): self
    {
        $this->comttc = $comttc ? 1 : 0;
        return $this;
    }
    
    public function getObs(): ?string
    {
        return $this->obs?? '';
    }
    
    public function setObs(?string $obs): self
    {
        $this->obs = $obs?? '';
        return $this;
    }


    public function getLibre(): bool
    {
        return (bool) $this->libre;
    }


    public function setLibre(bool $libre): self
    {
        $this->libre = $libre ? 1 : 0;
        return $this;
    }

    public function getConfirmation(): bool
    {
        return (bool) $this->confirmation;
    }


    public function setConfirmation(bool $confirmation): self
    {
        $this->confirmation = $confirmation ? 1 : 0;
        return $this;
    }
    
    
    public function getFrais(): ?string
    {
        return $this->frais;
    }
    
    public function getTaxe(): ?string
    {
        return $this->taxe;
    }
    
    public function setTaxe(string $taxe): self
    {
        $this->taxe = $taxe;
        return $this;
    }
    
    public function getCodecommercial(): ?string
    {
        return $this->codecommercial;
    }
    
    public function setCodecommercial(string $codecommercial): self
    {
        $this->codecommercial = $codecommercial;
        return $this;
    }
    

    public function getPaiement(): bool
    {
        return (bool) $this->paiement;
    }


    public function setPaiement(bool $paiement): self
    {
        $this->paiement = $paiement ? 1 : 0;
        return $this;
    }
    
    
    
    public function getDatesaisie(): \DateTimeInterface
    {
        return $this->datesaisie;
    }
    
    public function setDatesaisie(\DateTimeInterface $datesaisie): self
    {
        $this->datesaisie = $datesaisie;
        return $this;
    }
    
    public function getCompta(): ?string
    {
        return $this->compta?? '';
    }
    
    public function setCompta(?string $compta): self
    {
        $this->compta = $compta?? '';
        return $this;
    }
    
    public function getConvoc(): ?string
    {
        return $this->convoc?? '';
    }
    
    public function setConvoc(?string $convoc): self
    {
        $this->convoc = $convoc?? '';
        return $this;
    }
    
    public function getResa(): ?string
    {
        return $this->resa?? '';
    }
    
    public function setResa(?string $resa): self
    {
        $this->resa = $resa?? '';
        return $this;
    }
    
    public function getSEQCOMMERCIAL(): ?Commercial
    {
        return $this->seqcommercial;
    }

    public function setSEQCOMMERCIAL(?Commercial $seqcommercial): self
    {
        $this->seqcommercial = $seqcommercial;
        return $this;
    }
    public function getSEQCOMM(): ?Commission
    {
        return $this->seqcomm;
    }

    public function setSEQCOMM(?Commission $seqcomm): self
    {
        $this->seqcomm = $seqcomm;
        return $this;
    }

    public function getLIBTYPEREGLE(): ?Typeregle
    {
        return $this->libtyperegle;
    }
    
    public function setLIBTYPEREGLE(?Typeregle $libtyperegle): self
    {
        $this->libtyperegle = $libtyperegle;
        return $this;
    }
    
    public function getLibtypeclt(): ?GroupementClient
    {
        return $this->libtypeclt;
    }
    
    public function setLibtypeclt(?GroupementClient $libtypeclt): self
    {
        $this->libtypeclt = $libtypeclt;
        return $this;
    }
    
    public function getCcredit():?int
    {
        return $this->ccredit;
    }
    
    public function setCcredit(int $ccredit): self
    {
        $this->ccredit = $ccredit;
        return $this;
    }
    
    public function getAdresse2(): ?string
    {
        return $this->adresse2?? '';
    }
    
    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2?? '';
        return $this;
    }
    public function getPrincipal(): ?string
    {
        return $this->principal?? '';
    }

    public function setPrincipal(?string $principal): self
    {
        $this->principal = $principal?? '';
        return $this;
    }

    public function getClientPrincipal(): ?self
    {
        return $this->clientPrincipal;
    }

    public function setClientPrincipal(?self $clientPrincipal): self
    {
        $this->clientPrincipal = $clientPrincipal;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getSubordonnes(): Collection
    {
        return $this->subordonnes;
    }

    public function addSubordonne(Client $subordonne): self
    {
        if (!$this->subordonnes->contains($subordonne)) {
            $this->subordonnes[] = $subordonne;
            $subordonne->setPrincipal($this);
        }

        return $this;
    }

    public function removeSubordonne(Client $subordonne): self
    {
        if ($this->subordonnes->removeElement($subordonne)) {
            if ($subordonne->getPrincipal() === $this) {
                $subordonne->setPrincipal(null);
            }
        }

        return $this;
    }
    
    public function getPointcom(): bool
    {
        return (bool) $this->pointcom;
    }


    public function setPointcom(bool $pointcom): self
    {
        $this->pointcom = $pointcom ? 1 : 0;
        return $this;
    }
    
    public function getRefunique(): bool
    {
        return (bool) $this->refunique;
    }


    public function setRefunique(bool $refunique): self
    {
        $this->refunique = $refunique ? 1 : 0;
        return $this;
    }
    
    
    
    public function getGroupeclient(): ?string
    {
        return $this->groupeclient?? '';
    }
    
    public function setGroupeclient(?string $groupeclient): self
    {
        $this->groupeclient = $groupeclient?? '';
        return $this;
    }
    

    public function getLitige(): bool
    {
        return (bool) $this->litige;
    }


    public function setLitige(bool $litige): self
    {
        $this->litige = $litige ? 1 : 0;
        return $this;
    }
    
    
    public function getLogin(): ?string
    {
        return $this->login?? '';
    }
    
    public function setLogin(?string $login): self
    {
        $this->login = $login?? '';
        return $this;
    }
    
    public function getMdp(): ?string
    {
        return $this->mdp?? '';
    }
    
    public function setMdp(?string $mdp): self
    {
        $this->mdp = $mdp?? '';
        return $this;
    }
    
    public function getCodeamadeus(): ?string
    {
        return $this->codeamadeus?? '';
    }
    
    public function setCodeamadeus(?string $codeamadeus): self
    {
        $this->codeamadeus = $codeamadeus?? '';
        return $this;
    }
    
    public function isAnnulationTechnique(): bool
    {
        return $this->annulationTechnique;
    }
    
    public function setAnnulationTechnique(bool $annulationTechnique): self
    {
        $this->annulationTechnique = $annulationTechnique;
        return $this;
    }
    
    public function getDelaiAt():?int
    {
        return $this->delaiAt;
    }
    
    public function setDelaiAt(int $delaiAt): self
    {
        $this->delaiAt = $delaiAt;
        return $this;
    }

    public function getCarnetvoyage(): bool
    {
        return (bool) $this->carnetvoyage;
    }


    public function setCarnetvoyage(bool $carnetvoyage): self
    {
        $this->carnetvoyage = $carnetvoyage ? 1 : 0;
        return $this;
    }
    
    public function getArchiver(): bool
    {
        return (bool) $this->archiver;
    }


    public function setArchiver(bool $archiver): self
    {
        $this->archiver = $archiver ? 1 : 0;
        return $this;
    }
    
    
    public function getLoginGalileo(): ?string
    {
        return $this->loginGalileo?? '';
    }
    
    public function setLoginGalileo(?string $loginGalileo): self
    {
        $this->loginGalileo = $loginGalileo?? '';
        return $this;
    }
    
    public function getMdpGalileo(): ?string
    {
        return $this->mdpGalileo?? '';
    }
    
    public function setMdpGalileo(?string $mdpGalileo): self
    {
        $this->mdpGalileo = $mdpGalileo?? '';
        return $this;
    }
    
    public function getCouleur():?int
    {
        return $this->couleur;
    }
    
    public function setCouleur(?int $couleur): self
    {
        $this->couleur = $couleur;
        return $this;
    }
    
    public function getLibclassification(): ?string
    {
        return $this->libclassification?? '';
    }
    
    public function setLibclassification(?string $libclassification): self
    {
        $this->libclassification = $libclassification?? '';
        return $this;
    }
    
    public function getCategorie(): ?string
    {
        return $this->categorie?? '';
    }
    
    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie?? '';
        return $this;
    }
    
    public function getComcoffret(): ?string
    {
        return $this->comcoffret?? '';
    }
    
    public function setComcoffret(?string $comcoffret): self
    {
        $this->comcoffret = $comcoffret?? '';
        return $this;
    }
    
    public function getLoginAdpack(): ?string
    {
        return $this->loginAdpack?? '';
    }
    
    public function setLoginAdpack(?string $loginAdpack): self
    {
        $this->loginAdpack = $loginAdpack?? '';
        return $this;
    }
    
    public function getMdpAdpack(): ?string
    {
        return $this->mdpAdpack?? '';
    }
    
    public function setMdpAdpack(?string $mdpAdpack): self
    {
        $this->mdpAdpack = $mdpAdpack?? '';
        return $this;
    }
    
    // public function getCodeclientDirect(): string
    // {
    //     return $this->codeclientDirect;
    // }
    
    // public function setCodeclientDirect(string $codeclientDirect): self
    // {
    //     $this->codeclientDirect = $codeclientDirect;
    //     return $this;
    // }
    
    // public function getCaution(): int
    // {
    //     return $this->caution;
    // }
    
    // public function setCaution(int $caution): self
    // {
    //     $this->caution = $caution;
    //     return $this;
    // }
    
    // public function getFournisseur(): int
    // {
    //     return $this->fournisseur;
    // }
    
    // public function setFournisseur(int $fournisseur): self
    // {
    //     $this->fournisseur = $fournisseur;
    //     return $this;
    // }
    
    // public function getHebergement(): string
    // {
    //     return $this->hebergement;
    // }
    
    // public function setHebergement(string $hebergement): self
    // {
    //     $this->hebergement = $hebergement;
    //     return $this;
    // }
    
    // public function getCategorieGroup(): string
    // {
    //     return $this->categorieGroup;
    // }
    
    // public function setCategorieGroup(string $categorieGroup): self
    // {
    //     $this->categorieGroup = $categorieGroup;
    //     return $this;
    // }
    
    // public function getCodeTypeClt(): string
    // {
    //     return $this->codeTypeClt;
    // }
    
    // public function setCodeTypeClt(string $codeTypeClt): self
    // {
    //     $this->codeTypeClt = $codeTypeClt;
    //     return $this;
    // }


    public function getCommission(): ?int
    {
        return $this->commission;
    }

    public function getSeqtypeclt():?int
    {
        return $this->seqtypeclt;
    }

    public function setSeqtypeclt(?int $seqtypeclt): self
    {
        $this->seqtypeclt = $seqtypeclt;
        return $this;
    }

    public function getSeqreseau():?int
    {
        return $this->seqreseau;
    }

    public function setSeqreseau(?int $seqreseau): self
    {
        $this->seqreseau = $seqreseau;
        return $this;
    }

    public function getSeqsousreseau():?int
    {
        return $this->seqsousreseau;
    }

    public function setSeqsousreseau(?int $seqsousreseau): self
    {
        $this->seqsousreseau = $seqsousreseau;
        return $this;
    }

  
 

    public function getSeqtyperegle():?int
    {
        return $this->seqtyperegle;
    }

    public function setSeqtyperegle(?int $seqtyperegle): self
    {
        $this->seqtyperegle = $seqtyperegle;
        return $this;
    }


    
    public function getSeqclientPrincipal(): ?int
    {
        return $this->seqclientPrincipal;
    }

    public function setSeqclientPrincipal(?int $seqclientPrincipal): self
    {
        $this->seqclientPrincipal = $seqclientPrincipal;
        return $this;
    }

    public function getLoginbtob(): ?string
{
    return $this->loginbtob?? '';
}

public function setLoginbtob(?string $loginbtob): self
{
    $this->loginbtob = $loginbtob?? '';
    return $this;
}

public function getMdpbtob(): ?string
{
    return $this->mdpbtob?? '';
}

public function setMdpbtob(?string $mdpbtob): self
{
    $this->mdpbtob = $mdpbtob?? '';
    return $this;
}

public function getAnalytique(): ?string
{
    return $this->analytique?? '';
}

public function setAnalytique(?string $analytique): self
{
    $this->analytique = $analytique?? '';
    return $this;
}


public function getBasculeAutoReglement(): bool
{
    return (bool) $this->basculeAutoReglement;
}


public function setBasculeAutoReglement(bool $basculeAutoReglement): self
{
    $this->basculeAutoReglement = $basculeAutoReglement ? 1 : 0;
    return $this;
}

public function getDocLangue(): ?string
{
    return $this->docLangue?? '';
}

public function setDocLangue(?string $docLangue): self
{
    $this->docLangue = $docLangue?? '';
    return $this;
}

public function getEnvoiMctoGestour():?int
{
    return $this->envoiMctoGestour;
}

public function setEnvoiMctoGestour(?int $envoiMctoGestour): self
{
    $this->envoiMctoGestour = $envoiMctoGestour;
    return $this;
}

public function getNomclt2(): ?string
{
    return $this->nomclt2?? '';
}

public function setNomclt2(?string $nomclt2): self
{
    $this->nomclt2 = $nomclt2?? '';
    return $this;
}

public function getCodeiso(): ?string
{
    return $this->codeiso?? '';
}

public function setCodeiso(?string $codeiso): self
{
    $this->codeiso = $codeiso?? '';
    return $this;
}

public function getModereglt(): ?string
{
    return $this->modereglt?? '';
}

public function setModereglt(?string $modereglt): self
{
    $this->modereglt = $modereglt?? '';
    return $this;
}

public function getEchancement(): ?string
{
    return $this->echancement?? '';
}

public function setEchancement(?string $echancement): self
{
    $this->echancement = $echancement?? '';
    return $this;
}

public function getSiren(): ?string
{
    return $this->siren?? '';
}

public function setSiren(?string $siren): self
{
    $this->siren = $siren?? '';
    return $this;
}

public function getSiret(): ?string
{
    return $this->siret?? '';
}

public function setSiret(?string $siret): self
{
    $this->siret = $siret?? '';
    return $this;
}

public function getNumtva(): ?string
{
    return $this->numtva?? '';
}

public function setNumtva(?string $numtva): self
{
    $this->numtva = $numtva?? '';
    return $this;
}

public function getTypepers(): ?string
{
    return $this->typepers?? '';
}

public function setTypepers(?string $typepers): self
{
    $this->typepers = $typepers?? '';
    return $this;
}

public function getGrouperelance(): ?string
{
    return $this->grouperelance?? '';
}

public function setGrouperelance(?string $grouperelance): self
{
    $this->grouperelance = $grouperelance?? '';
    return $this;
}

public function getClientpayeur(): ?string
{
    return $this->clientpayeur?? '';
}

public function setClientpayeur(?string $clientpayeur): self
{
    $this->clientpayeur = $clientpayeur?? '';
    return $this;
}

public function setFrais($frais): self
{
    $this->frais = $this->sanitizeDecimal($frais, 7, 2);
    return $this;
}

private function sanitizeDecimal($value, int $precision, int $scale): string
{
    if ($value === null || $value === '') {
        return number_format(0, $scale, '.', '');
    }
    

    if (is_string($value)) {
        $value = str_replace(',', '.', $value);
    }
    
    // Ensure proper decimal format
    $number = (float)$value;
    $formatted = number_format($number, $scale, '.', '');
    
    // Handle precision overflow
    $maxValue = pow(10, $precision - $scale) - pow(10, -$scale);
    if ($number > $maxValue) {
        return number_format($maxValue, $scale, '.', '');
    }
    
    return $formatted;
}

public function setCommiss($commiss): self
{
    $this->commiss = $this->formatDecimal($commiss, 6, 2);
    return $this;
}

public function setCommiss2($commiss2): self
{
    $this->commiss2 = $this->formatDecimal($commiss2, 5, 2);
    return $this;
}

// Add this helper method to your entity
private function formatDecimal($value, int $precision, int $scale): string
{
    if ($value === null || $value === '') {
        return number_format(0, $scale, '.', '');
    }
    
    // Handle comma decimal separator
    if (is_string($value)) {
        $value = str_replace(',', '.', $value);
    }
    
    $number = (float)$value;
    return number_format($number, $scale, '.', '');
}



    
}
