<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Vol;
use App\Entity\Ville;
use App\Entity\Affreteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seqvol', TextType::class, [
                'label' => 'N° Séq:',
                'required' => true,
                'mapped' => false,
                'data' => $options['seqvol_value'] ?? '',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le numéro de séquence est obligatoire','groups' => ['general']]),
                ],
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control bg-light text-muted',
                ],
            ])
            ->add('pnr', TextType::class, [
                'label' => 'PNR',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('retro_vol', TextType::class, [
                'label' => 'Jours en retro',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('nvol', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le numéro de vol est obligatoire','groups' => ['general']]),
                    new Assert\Length([
                        'min' => 2,'max' => 10,
                        'minMessage' => 'Le numéro de vol doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le numéro de vol ne peut pas dépasser {{ limit }} caractères',
                        'groups' => ['general']
                    ])
                ],
            ])
            ->add('datevol', DateType::class, [
                'label' => 'Date de vol du ',
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime_immutable',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La date du vol est obligatoire','groups' => ['general']]),
                    new Assert\GreaterThanOrEqual(['value' => 'today','message' => 'La date du vol ne peut pas être dans le passé','groups' => ['general']])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'max' => (new \DateTimeImmutable('+1 year'))->format('Y-m-d'),
                ]
            ])
            ->add('datevolau', DateType::class, [
                'label'    => 'Date de vol au',
                'widget'   => 'single_text',        // input type="date"
                'html5'    => true,
                'required' => false,
                // IMPORTANT : fait renvoyer un \DateTimeImmutable au setter
                'input'    => 'datetime_immutable',
                // optionnels mais pratiques :
                'empty_data'      => null,
                'invalid_message' => 'Date invalide (format attendu : YYYY-MM-DD).',
            ])
            ->add('jo', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('jplus', ChoiceType::class, [
                'label' => 'J.Plus',
                'choices' => ['+1' => '+1', '+2' => '+2'],
                'required' => false,
                'placeholder' => 'Choisir',
                'attr' => ['class' => 'form-control bg-white'],
            ])
            ->add('heured', TimeType::class, [
                'label' => 'Heure de départ',
                'widget' => 'single_text',
                'input' => 'string',
                'html5' => true,
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'L\'heure de départ est obligatoire','groups' => ['general']])],
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('villeA', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libville',
                'choice_attr' => fn(Ville $v) => ['data-aero' => $v->getAero()],
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('v')->orderBy('v.libville', 'ASC'),
                'label' => 'Ville d\'arrivée',
                'placeholder' => 'Sélectionner une ville',
                'attr' => ['class' => 'form-select'],
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'La ville d\'arrivée est obligatoire','groups' => ['general']])],
            ])
            ->add('aeroarr', TextType::class, [
                'label' => 'Aéroport d\'arrivée',
                'attr' => ['class' => 'form-control aero-input','readonly' => true],
                'mapped' => false,
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'L\'aéroport d\'arrivée est obligatoire','groups' => ['general']])],
            ])
            ->add('heurea', TimeType::class, [
                'label' => 'Heure d\'arrivée',
                'widget' => 'single_text',
                'input' => 'string',
                'html5' => true,
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'L\'heure d\'arrivée est obligatoire','groups' => ['general']])],
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('villeD', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libville',
                'choice_attr' => fn(Ville $v) => ['data-aero' => $v->getAero()],
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('v')->orderBy('v.libville', 'ASC'),
                'label' => 'Ville de départ',
                'placeholder' => 'Sélectionner une ville',
                'attr' => ['class' => 'form-select'],
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'La ville de départ est obligatoire','groups' => ['general']])],
            ])
            ->add('aerodep', TextType::class, [
                'label' => 'Aéroport de départ',
                'attr' => ['class' => 'form-control aero-input','readonly' => true],
                'mapped' => false,
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'L\'aéroport de départ est obligatoire','groups' => ['general']])],
            ])
            ->add('codaffret', EntityType::class, [
                'class' => Affreteur::class,
                'choice_label' => 'codaffret',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('v')->orderBy('v.codaffret', 'ASC'),
                'label' => 'Code Affreteur',
                'placeholder' => '',
                'attr' => ['class' => 'form-select'],
                'required' => true,
            ])
            ->add('libaffret', TextType::class, [
                'label' => 'Affreteur',
                'attr' => ['class' => 'form-control','readonly' => true],
                'mapped' => false,
                'required' => false,
            ])
            ->add('villeV', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libville',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('v')->orderBy('v.libville', 'ASC'),
                'label' => 'Ville Via',
                'placeholder' => 'Sélectionner une ville',
                'attr' => ['class' => 'form-select'],
                'required' => false,
            ])
            ->add('typevol', ChoiceType::class, [
                'choices' => ['Aller' => 1,'Retour' => 2],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Type de vol',
                'required' => true,
                'constraints' => [new Assert\NotBlank(['message' => 'Le type de vol est obligatoire','groups' => ['general']])],
                'attr' => ['class' => 'form-check'],
                'data' => 1,
            ])
            ->add('sg', IntegerType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('vendu', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nombre de places vendues est obligatoire','groups' => ['capacities']]),
                    new Assert\PositiveOrZero(['message' => 'Le nombre de places vendues doit être positif ou zéro','groups' => ['capacities']])
                ],
            ])
            ->add('reserve', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nombre de places réservées est obligatoire','groups' => ['capacities']]),
                    new Assert\PositiveOrZero(['message' => 'Le nombre de places réservées doit être positif ou zéro','groups' => ['capacities']])
                ],
            ])
            ->add('dispo', IntegerType::class, [
                'mapped' => false,'required' => false,'attr' => ['readonly' => true, 'class' => 'form-control'],
            ])
            ->add('ouvert', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'offre totale est obligatoire','groups' => ['capacities']]),
                    new Assert\PositiveOrZero(['message' => 'L\'offre totale doit être positive ou zéro','groups' => ['capacities']])
                ],
            ])
            ->add('freesale', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le free sale doit être positif ou zéro','groups' => ['capacities']])],
            ])
            ->add('prixada', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix adulte achat doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixzza', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix enfant achat doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixbba', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix bébé achat doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('taxea', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'La taxe achat doit être positive ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixadv', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix adulte vente doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixzzv', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix enfant vente doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixbbv', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix bébé vente doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixadv2', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix adulte vente 2 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixzzv2', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix enfant vente 2 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixbbv2', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix bébé vente 2 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixadv3', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix adulte vente 3 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixzzv3', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix enfant vente 3 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixbbv3', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix bébé vente 3 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('supp1', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le supplément 1 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('supp2', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le supplément 2 doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('taxevente', NumberType::class, [
                'required' => false,
                'scale'   => 2,
                'html5'   => true,
                'attr'    => ['step' => '1.00'],
                // PAS de 'data' ici : on met la valeur par défaut via un event plus bas
                'constraints' => [new Assert\PositiveOrZero(['message' => 'La taxe vente doit être positive ou zéro','groups' => ['pricing']])]
            ])
            ->add('cartevente', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'La carte vente doit être positive ou zéro','groups' => ['pricing']])]
            ])
            ->add('taxesovente', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'La taxe de sortie vente doit être positive ou zéro','groups' => ['pricing']])]
            ])
            ->add('suppvol', IntegerType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le supplément vol doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('dateconvo', DateType::class, [
                'widget' => 'single_text','required' => false,'html5' => true,'attr' => ['class' => 'form-control'],'empty_data' => null,
            ])
            ->add('heureconvo', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('lieuconvo', TextType::class, ['required' => false,'empty_data' => null,'attr' => ['class' => 'form-control']])
            ->add('comptoir', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('porte', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('agence', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('formforf', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('formsec', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('obs', TextareaType::class, [
                'attr' => ['class' => 'form-control','rows' => 5,'placeholder' => 'Saisir une observation...'],
                'required' => false,
            ])
//            ->add('dateconf', DateType::class, [
//                'widget' => 'single_text','html5' => true,'attr' => ['class' => 'form-control'],'required' => false,
//            ])
//            ->add('datedeconf', DateType::class, [
//                'widget' => 'single_text','html5' => true,'attr' => ['class' => 'form-control'],'required' => false,
//            ])
            ->add('datRetro', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime',
                'required' => false,
                'attr' => [
                    'class' => 'form-control bg-light text-muted',
                    'readonly' => true
                ]
            ])
//            ->add('destination', TextType::class, [
//                'attr' => ['class' => 'form-control'],'required' => true,
//                'constraints' => [
//                    new Assert\NotBlank(['message' => 'La destination est obligatoire','groups' => ['general']]),
//                    new Assert\Length([
//                        'min' => 2,'max' => 50,
//                        'minMessage' => 'La destination doit contenir au moins {{ limit }} caractères',
//                        'maxMessage' => 'La destination ne peut pas dépasser {{ limit }} caractères',
//                        'groups' => ['general']
//                    ])
//                ],
//            ])
            ->add('IDPAYS', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => function(Pays $pays) {
                    return strtoupper($pays->getLibpays() ?? '');
                },
                'label' => 'Destination',
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Sélectionnez une destination',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La destination est obligatoire',
                        'groups' => ['general']
                    ])
                ],
            ])
//            ->add('bagagesoption', IntegerType::class, ['attr' => ['class' => 'form-control'],'required' => false])
//            ->add('prixbagagesoption', NumberType::class, [
//                'attr' => ['class' => 'form-control'],'required' => false,
//                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix des bagages optionnels doit être positif ou zéro','groups' => ['baggage']])]
//            ])
//            ->add('nbrbagagesoption', NumberType::class, [
//                'attr' => ['class' => 'form-control'],'required' => false,
//                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le nombre de bagages optionnels doit être positif ou zéro','groups' => ['baggage']])]
//            ])
            ->add('prixYield', NumberType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le yield doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('kilocabine', NumberType::class, [
                'label' => 'Kilos baggage cabine',
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Les kilos cabine doivent être positifs ou zéro','groups' => ['baggage']])]
            ])
            ->add('kilos', IntegerType::class, ['label' => 'Kilos baggage adulte','attr' => ['class' => 'form-control'],'required' => false])
            ->add('kilobebe', NumberType::class, [
                'label' => 'Kilos baggage bébé',
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Les kilos bébé doivent être positifs ou zéro','groups' => ['baggage']])]
            ])
            ->add('specification', ChoiceType::class, [
                'choices' => ['Pas de spécification' => 0,'Dernière Minute' => 1,'Bon Plan' => 2],
                'expanded' => true,'multiple' => false,'label' => false,'required' => false,
            ])
            ->add('nomfour', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('prixadav', NumberType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix adulte vol sec doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixbbav', NumberType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix bébé vol sec doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('prixzzav', NumberType::class, [
                'attr' => ['class' => 'form-control'],'required' => false,
                'constraints' => [new Assert\PositiveOrZero(['message' => 'Le prix enfant vol sec doit être positif ou zéro','groups' => ['pricing']])]
            ])
            ->add('volsec', CheckboxType::class, ['label' => 'Autorisé Vente Vol Sec Internet','required' => false])
            ->add('venduVolsec', CheckboxType::class, ['label' => 'venduVolsec','required' => false])
            ->add('bagagesoute', CheckboxType::class, ['label' => 'bagagesoute','required' => false])
            ->add('allotFreesale', CheckboxType::class, ['label' => 'allotFreesale','required' => false])
//            ->add('blocsiege', IntegerType.form-group-legend .form-control, .form-group-legend .form-select::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('ferry', CheckboxType::class, [
                'required' => false,'label' => 'Vol Ferry','attr' => ['class' => 'form-check-input'],
            ])
            ->add('fictif', CheckboxType::class, [
                'required' => false,'label' => 'Vol Fictif','attr' => ['class' => 'form-check-input'],
            ])
        ;

        /**
         * 1) Forcer la conversion des champs checkbox <-> bool (évite “Expected a Boolean” en édition)
         */
        $checkboxes = ['ferry','fictif','volsec','venduVolsec','bagagesoute','allotFreesale'];
        foreach ($checkboxes as $name) {
            if ($builder->has($name)) {
                $builder->get($name)->addModelTransformer(new CallbackTransformer(
                // Model (entité/DB) -> View (form bool)
                    function ($valueFromEntity) {
                        if ($valueFromEntity === null) return false;
                        return in_array($valueFromEntity, [true, 1, '1', 'Y', 'O', 'yes', 'on'], true);
                    },
                    // View (bool) -> Model (entité/DB)
                    function ($valueFromForm) {
                        // Adaptez si votre DB veut 'Y'/'N'
                        return $valueFromForm ? 1 : 0;
                    }
                ));
            }
        }

        /**
         * 2) Définir la valeur par défaut de taxevente (150.00) UNIQUEMENT en création
         *    (si la valeur de l’entité est nulle)
         */
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Vol|null $vol */
            $vol = $event->getData();
            if (!$vol) return;

            // Si aucune valeur encore définie dans l'entité, on met 150.00
            if ($vol->getTaxevente() === null) {
                $event->getForm()->get('taxevente')->setData(150.00);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
            'csrf_protection' => true,
            'allow_extra_fields' => true,
            'seqvol_value' => null,
            'aerodep_value' => null,
            'aeroarr_value' => null,
            'validation_groups' => ['Default', 'general', 'capacities', 'pricing', 'baggage'],
        ]);
    }
}
