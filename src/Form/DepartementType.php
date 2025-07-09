<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Region;
use App\Entity\Departement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\CommercialRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class DepartementType extends AbstractType
{
    private CommercialRepository $commercialRepository;
    private array $regions;

    public function __construct(CommercialRepository $commercialRepository)
    {
        $this->commercialRepository = $commercialRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->regions = $options['regions'] ?? [];

        $builder
            ->add('code_departement', TextType::class, [
                'label' => 'Code Département',
                'attr' => [
                    'maxlength' => 5,
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 75'
                ],
            ])
            ->add('lib_departement', TextType::class, [
                'label' => 'Libellé Département',
                'attr' => [
                    'maxlength' => 100,
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Paris'
                ],
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choices' => $this->regions,
                'choice_label' => 'libregion',
                'label' => 'Région',
                'attr' => ['class' => 'form-select'],
                'placeholder' => 'Sélectionnez une région',
                'required' => true,
            ])
            ->add('commercialCode', TextType::class, [
                'label' => 'Code Commercial',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le code commercial est obligatoire'
                    ]),
                    new Length([
                        'max' => 4,
                        'maxMessage' => 'Le code ne doit pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control commercial-code-input',
                    'autocomplete' => 'off',
                    'placeholder' => 'Ex: C123',
                    'id' => 'codeCommercialInput',
                ],
            ])
            ->add('commercial', TextType::class, [
                'label' => 'Commercial',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'readonly' => false,
                    'class' => 'form-control commercial-name-input',
                    'id' => 'commercialInput',
                    'placeholder' => 'Saisissez un code commercial'
                ],
            ]);

        // Pré-remplir les champs commerciaux si l'entité existe
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $departement = $event->getData();
            $form = $event->getForm();

            if ($departement && $departement->getCommercial()) {
                $commercial = $departement->getCommercial();
                $form->get('commercialCode')->setData($commercial->getCodeCommercial());
                $form->get('commercial')->setData(
                    $commercial->getNomCommercial() . ' ' . $commercial->getPrenomCommercial()
                );
            }
        });

        // Gérer la soumission du formulaire
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $departement = $event->getData();
            $form = $event->getForm();
            $codeCommercial = $form->get('commercialCode')->getData();

            // Trouver le commercial correspondant
            $commercial = $codeCommercial 
                ? $this->commercialRepository->findOneBy(['codeCommercial' => $codeCommercial])
                : null;

            // Mettre à jour l'entité Departement
            $departement->setCommercial($commercial);
            
            // Synchroniser le code commercial
            if ($commercial) {
                $departement->setCodeCommercial($commercial->getCodeCommercial());
            } else {
                $departement->setCodeCommercial($codeCommercial);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
            'regions' => [],
        ]);
    }
}