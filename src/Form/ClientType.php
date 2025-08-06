<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commission;
use App\Entity\Typeregle;
use App\Entity\SousReseau;
use App\Entity\Commercial;
use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\TypeClt;
use App\Entity\SuperReseau;
use App\Entity\Reseau;
use App\Entity\GroupementClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('seqclt', TextType::class, [
            'label' => 'Code',
            'required' => false,
            'label_attr' => [
                'class' => 'text-end d-block' 
            ],
            'attr' => [
                'readonly' => true,
                'class' => 'form-control bg-light text-muted'
            ],
            ])
            ->add('clientPrincipal', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'seqclt',
                'placeholder' => 'Choisir un responsable',
                'required' => false,
            ])
            ->add('pointcom', CheckboxType::class, [
                'label' => 'pointcom',
                'required' => false,
            ])
            // ->add('sousReseau', TextType::class, [
            //     'label' => 'sousReseau',
            //     'required' => false,
            // ])
            ->add('seqcltpackdb', IntegerType::class, [
                'label' => 'Sequence Client Pack DB',
                'required' => false,
                'label_attr' => [
                    'class' => 'text-end d-block' 
                ],
            ])
            ->add('refpackdb', TextType::class, [
                'label' => 'Référence Pack DB',
                'required' => false,
                'label_attr' => [
                    'class' => 'text-end d-block' 
                ],
            ])
            ->add('nomclt', TextType::class, [
                'label' => 'Nom Client',
                'required' => false,
                'label_attr' => [
                    'class' => 'text-end d-block' 
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('cp', TextType::class, [
                'label' => 'Code Postal',
                'required' => false,
            ])
            ->add('VILLE', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libville',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.libville', 'ASC');
                },
                'label' => 'Ville',
                'placeholder' => 'Sélectionner une ville',
                'attr' => ['class' => 'form-select']
            ])
            ->add('PAYS', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'LIBPAYS',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.LIBPAYS', 'ASC');
                },
                'label' => 'Pays',
                'placeholder' => 'Sélectionner un pays',
                'attr' => ['class' => 'form-select']
            ])
            ->add('SEQCOMMERCIAL', EntityType::class, [
                'class' => Commercial::class,
                'choice_label' => 'nomCommercial',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.nomCommercial', 'ASC');
                },
                'label' => 'Commercial',
                'placeholder' => 'Sélectionner Commercial',
                'attr' => ['class' => 'form-select']
            ])
            ->add('NOMRESEAU', EntityType::class, [
                'class' => Reseau::class,
                'choice_label' => 'nomreseau',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.nomreseau', 'ASC');
                },
                'label' => 'Réseau',
                'placeholder' => 'Sélectionner Réseau',
                'attr' => ['class' => 'form-select']
            ])
            ->add('libtyperegle', EntityType::class, [
                'class' => Typeregle::class,
                'choice_label' => 'libtyperegle',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.libtyperegle', 'ASC');
                },
                'label' => 'Type réglement',
                'placeholder' => 'Sélectionner un type',
                'attr' => ['class' => 'form-select']
            ])
            ->add('seqcomm', EntityType::class, [
                'class' => Commission::class,
                'choice_label' => 'categorie',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.categorie', 'ASC');
                },
                'label' => 'Comission',
                'placeholder' => 'Sélectionner Commission',
                'attr' => ['class' => 'form-select']
            ])
            ->add('refpackdb', EntityType::class, [
                'class' => TypeClt::class,
                'choice_label' => 'libtypeclt',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.libtypeclt', 'ASC');
                },
                'label' => 'Modalité',
                'placeholder' => 'Sélectionner type client',
                'attr' => ['class' => 'form-select']
            ])
            ->add('tel1', TextType::class, [
                'label' => 'Téléphone 1',
                'required' => false,
            ])
            ->add('tel2', TextType::class, [
                'label' => 'Téléphone 2',
                'required' => false,
            ])
            ->add('tel3', TextType::class, [
                'label' => 'Téléphone 3',
                'required' => false,
            ])
            ->add('fax', TextType::class, [
                'label' => 'Fax',
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('patron', TextType::class, [
                'label' => 'Patron',
                'required' => false,
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact',
                'required' => false,
            ])
            ->add('ccompta', TextType::class, [
                'label' => 'Compte Comptable',
                'required' => false,
            ])
            // ->add('commiss', NumberType::class, [
            //     'label' => 'Commission 1',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('commiss2', NumberType::class, [
            //     'label' => 'Commission 2',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('commiss3', NumberType::class, [
            //     'label' => 'Commission 3',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('commiss4', NumberType::class, [
            //     'label' => 'Commission 4',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            ->add('comttc', CheckboxType::class, [
                'label' => 'Compte TTC',
                'required' => false,
            ])
            ->add('obs', TextareaType::class, [
                'label' => 'Observations',
                'required' => false,
            ])
            ->add('libre', CheckboxType::class, [
                'label' => 'Libre',
                'required' => false,
            ])

            ->add('confirmation', CheckboxType::class, [
                'label' => 'Avec confirmation',
                'required' => false,
            ])
            // ->add('frais', NumberType::class, [
            //     'label' => 'Frais',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('taxe', NumberType::class, [
            //     'label' => 'Taxe',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('codecommercial', TextType::class, [
            //     'label' => 'Code Commercial',
            //     'required' => false,
            // ])
            // ->add('libtyperegle', TextType::class, [
            //     'label' => 'Libellé Type Règle',
            //     'required' => false,
            // ])
            ->add('paiement', CheckboxType::class, [
                'label' => 'Paiement',
                'required' => false,
            ])
            ->add('datesaisie', DateType::class, [
                'label' => 'Date de Saisie',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true, 
                ],
            ])
            ->add('compta', TextType::class, [
                'label' => 'Compta',
                'required' => false,
            ])
            ->add('convoc', TextType::class, [
                'label' => 'Convocation',
                'required' => false,
            ])
            ->add('resa', TextType::class, [
                'label' => 'Réservation',
                'required' => false,
            ])
            // ->add('typeRegle', TextType::class, [
            //     'label' => 'typeRegle',
            //     'required' => false,
            // ])
            ->add('libtypeclt', EntityType::class, [
                'class' => GroupementClient::class,
                'choice_label' => 'nomgroupeclient',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nomgroupeclient', 'ASC');
                },
                'label' => 'Grp.Agence',
                'placeholder' => 'Sélectionner Groupement ',
                'attr' => ['class' => 'form-select']
            ])
            // ->add('ccredit', IntegerType::class, [
            //     'label' => 'Crédit',
            //     'required' => false,
            // ])
            ->add('adresse2', TextType::class, [
                'label' => 'Adresse 2',
                'required' => false,
            ])
            ->add('refunique', CheckboxType::class, [
                'label' => 'refunique',
                'required' => false,
            ])
            ->add('groupeclient', TextType::class, [
                'label' => 'groupeclient',
                'required' => false,
            ])
            ->add('litige', CheckboxType::class, [
                'label' => 'litige',
                'required' => false,
            ])
            // ->add('login', TextType::class, [
            //     'label' => 'Login',
            //     'required' => false,
            // ])
            // ->add('mdp', TextType::class, [
            //     'label' => 'Mot de passe',
            //     'required' => false,
            // ])
            ->add('codeamadeus', TextType::class, [
                'label' => 'Code Amadeus',
                'required' => false,
            ])
            // ->add('annulationTechnique', CheckboxType::class, [
            //     'label' => 'Annulation Technique',
            //     'required' => false,
            // ])
            // ->add('delaiAt', IntegerType::class, [
            //     'label' => 'Délai AT',
            //     'required' => false,
            // ])
            ->add('carnetvoyage', CheckboxType::class, [
                'label' => 'Carnetvoyage',
                'required' => false,
            ])
            ->add('archiver', CheckboxType::class, [
                'label' => 'Archiver',
                'required' => false,
            ])
            // ->add('loginGalileo', TextType::class, [
            //     'label' => 'Login Galileo',
            //     'required' => false,
            // ])
            // ->add('mdpGalileo', TextType::class, [
            //     'label' => 'MDP Galileo',
            //     'required' => false,
            // ])
            // ->add('couleur', IntegerType::class, [
            //     'label' => 'Couleur',
            //     'required' => false,
            // ])
            // ->add('libclassification', TextType::class, [
            //     'label' => 'Libellé Classification',
            //     'required' => false,
            // ])
            // ->add('categorie', TextType::class, [
            //     'label' => 'Catégorie',
            //     'required' => false,
            // ])
            // ->add('comcoffret', NumberType::class, [
            //     'label' => 'Commission Coffret',
            //     'required' => false,
            //     'scale' => 2,
            // ])
            // ->add('loginAdpack', TextType::class, [
            //     'label' => 'Login Adpack',
            //     'required' => false,
            // ])
            // ->add('mdpAdpack', TextType::class, [
            //     'label' => 'MDP Adpack',
            //     'required' => false,
            // ])
            ->add('codeAgence', TextType::class, [
                'label' => 'Code Agence',
                'required' => false,
            ])
            // ->add('motCle', TextType::class, [
            //     'label' => 'Mot Clé',
            //     'required' => false,
            // ])
            // ->add('seqreseau', IntegerType::class, [
            //     'label' => 'Séq Réseau',
            //     'required' => false,
            // ])
            // ->add('seqsousreseau', IntegerType::class, [
            //     'label' => 'Séq Sous-Réseau',
            //     'required' => false,
            // ])
            // ->add('seqcommercial', IntegerType::class, [
            //     'label' => 'Séq Commercial',
            //     'required' => false,
            // ])
            // ->add('seqtyperegle', IntegerType::class, [
            //     'label' => 'Séq Type Règle',
            //     'required' => false,
            // ])
            // ->add('seqcomm', IntegerType::class, [
            //     'label' => 'Séq Comm',
            //     'required' => false,
            // ])
            // ->add('seqclientPrincipal', IntegerType::class, [
            //     'label' => 'Séq Client Principal',
            //     'required' => false,
            // ])
            // ->add('commission', IntegerType::class, [
            //     'label' => 'commission',
            //     'required' => false,
            // ])
            // ->add('seqtypeclt', IntegerType::class, [
            //     'label' => 'seqtypeclt',
            //     'required' => false,
            // ])
            ->add('loginbtob', TextType::class, [
                'label' => 'Login BtoB',
                'required' => false,
            ])
            ->add('mdpbtob', TextType::class, [
                'label' => 'Mot de passe BtoB',
                'required' => false,
            ])
            ->add('analytique', ChoiceType::class, [
                'label' => 'S.Analytique',
                'choices' => [
                    'GROUPES' => 'GROUPES',
                    'VPG' => 'VPG',
                    'B2C' => 'B2C',
                    'VENTE PRIVEE' => 'VENTE PRIVEE',
                    'ATTENTE' => 'ATTENTE',
                    'VOYAGES PRIVE' => 'VOYAGES PRIVE',
                    'VOLS SECS' => 'VOLS SECS',
                    'AGENCES' => 'AGENCES',
                    'COM' => 'COM',
                    'AUTRES REVENUS' => 'AUTRES REVENUS',
                ],
                'placeholder' => 'Sélectionner...',
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])

            ->add('basculeAutoReglement', CheckboxType::class, [
                'label' => 'Bascule auto règlement',
                'required' => false,
            ])
            ->add('docLangue', ChoiceType::class, [
                'label' => 'Langue des documents',
                'required' => false,
                'choices' => [
                    'FR' => 'FR',
                    'DE' => 'DE',
                    'EN' => 'EN',
                    'ES' => 'ES',
                    'NL' => 'NL',
                    'IT' => 'IT',
                ],
                'placeholder' => 'Choisir...',
            ])

            // ->add('envoiMctoGestour', IntegerType::class, [
            //     'label' => 'Envoi MCTO Gestour',
            //     'required' => false,
            // ])
            // ->add('nomclt2', TextType::class, [
            //     'label' => 'Nom client 2',
            //     'required' => false,
            // ])
            // ->add('codeiso', TextType::class, [
            //     'label' => 'Code ISO',
            //     'required' => false,
            // ])
            // ->add('modereglt', TextType::class, [
            //     'label' => 'Mode de règlement',
            //     'required' => false,
            // ])
            // ->add('echancement', TextType::class, [
            //     'label' => 'Échancement',
            //     'required' => false,
            // ])
            // ->add('siren', TextType::class, [
            //     'label' => 'SIREN',
            //     'required' => false,
            // ])
            // ->add('siret', TextType::class, [
            //     'label' => 'SIRET',
            //     'required' => false,
            // ])
            // ->add('numtva', TextType::class, [
            //     'label' => 'Numéro TVA',
            //     'required' => false,
            // ])
            // ->add('typepers', TextType::class, [
            //     'label' => 'Type personne',
            //     'required' => false,
            // ])
            // ->add('grouperelance', TextType::class, [
            //     'label' => 'Groupe relance',
            //     'required' => false,
            // ])
            // ->add('clientpayeur', TextType::class, [
            //     'label' => 'Client payeur',
            //     'required' => false,
            // ])
            ->add('principal', TextType::class, [
                'label' => 'principal',
                'required' => false,
            ]);
            // ->add('principal', CheckboxType::class, [
            //     'label' => 'Client Principal',
            //     'required' => false,
            //     'mapped' => false 
            // ]);
            
                        // ->add('superReseau', TextType::class, [
            //     'label' => 'superReseau',
            //     'required' => false,
            // ])
            // ->add('superReseau', EntityType::class, [
            //     'class' => SuperReseau::class,
            //     'choice_label' => 'nomsuperreseau',
            //     'label' => 'Super Réseau',
            //     'required' => false,
            //     'attr' => ['class' => 'form-select'],
            //     'query_builder' => function(EntityRepository $er) {
            //         return $er->createQueryBuilder('sr')
            //             ->orderBy('sr.nomsuperreseau', 'ASC');
            //     },
            // ])
            // ->add('commercial', TextType::class, [
            //     'label' => 'commercial',
            //     'required' => false,
            // ])
            // ->add('typeClt', TextType::class, [
            //     'label' => 'typeClt',
            //     'required' => false,
            // ])
            // ->add('commission', TextType::class, [
            //     'label' => 'commission',
            //     'required' => false,
            // ])

            // ->add('commission', EntityType::class, [
            //     'class' => Commission::class,
            //     'choice_label' => 'libelle',
            //     'label' => 'Commission',
            //     'required' => false,
            //     'placeholder' => 'Sélectionner une commission',
            // ])

        // ->add('commercial', EntityType::class, [
        //     'class' => Commercial::class,
        //     'choice_label' => 'nomCommercial',
        //     'label' => 'Commercial',
        //     'required' => false,
        //     'attr' => ['class' => 'form-select'],
        // ])
        // ->add('typeClt', EntityType::class, [
        //     'class' => TypeClt::class,
        //     'choice_label' => 'libtypeclt',
        //     'label' => 'Type Client',
        //     'required' => false,
        //     'attr' => ['class' => 'form-select'],
        //     'placeholder' => 'Select a client type',
        // ])
        // ->add('commission', EntityType::class, [
        //     'class' => Commission::class,
        //     'choice_label' => 'categorie',
        //     'label' => 'Commission',
        //     'required' => false,
        //     'attr' => ['class' => 'form-select'],
        // ])
        // ->add('principal', EntityType::class, [
        //     'class' => Client::class,
        //     'choice_label' => 'nomclt',
        //     'label' => 'Client Principal',
        //     'required' => false,
        //     'attr' => ['class' => 'form-select'],
        //     'placeholder' => 'Select Principal Client',
        // ]);
                    // ->add('sousReseau', EntityType::class, [
            //     'class' => SousReseau::class,
            //     'choice_label' => 'nomsousreseau',
            //     'query_builder' => function(EntityRepository $er) {
            //         return $er->createQueryBuilder('s')
            //             ->orderBy('s.nomsousreseau', 'ASC');
            //     },
            //     'label' => 'Sous-réseau',
            //     'attr' => ['class' => 'form-select'],
            //     'required' => false,
            // ])
                        // ->add('typeRegle', EntityType::class, [
            //     'class' => Typeregle::class,
            //     'choice_label' => 'libtyperegle',
            //     'label' => 'Type de Règle',
            //     'required' => false,
            //     'attr' => ['class' => 'form-select'],
            // ])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'empty_data' => function (FormInterface $form) {
                return new Client();
            },
        ]);
    }
}