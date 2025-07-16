<?php

namespace App\Form;

use App\Entity\TypeClt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypeCltType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libtypeclt', TextType::class, [
                'label' => 'Libellé du type client : ',
                'attr' => [
                    'maxlength' => 60,
                    'placeholder' => 'Entrez le libellé',
                    'class' => 'form-control'
                ]
            ])
            ->add('depart', NumberType::class, [
                'label' => 'Départ : ',
                'attr' => [
                    'placeholder' => 'Code départ',
                    'class' => 'form-control',
                    'min' => '0',
                    'step' => '1'
                ],
                'required' => false
            ])
            ->add('jourFixe', NumberType::class, [
                'label' => 'Jour fixe : ',
                'attr' => [
                    'placeholder' => 'Jour fixe',
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '31',
                    'step' => '1'
                ],
                'required' => false
            ])
            ->add('moisPlus', NumberType::class, [
                'label' => 'Mois plus : ',
                'attr' => [
                    'placeholder' => 'Mois plus',
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '12',
                    'step' => '1'
                ],
                'required' => false
            ])
            ->add('reservation', NumberType::class, [
                'label' => 'Réservation : ',
                'attr' => [
                    'placeholder' => 'Jours de réservation',
                    'class' => 'form-control',
                    'min' => '0',
                    'step' => '1'
                ],
                'required' => false
            ])
            ->add('dateFixe', NumberType::class, [
                'label' => 'Date fixe : ',
                'attr' => [
                    'placeholder' => 'Date fixe',
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '31',
                    'step' => '1'
                ],
                'required' => false
            ])
            ->add('echeancement', TextType::class, [
                'label' => 'Échéancement : ',
                'attr' => [
                    'maxlength' => 12,
                    'placeholder' => 'Type échéancement',
                    'class' => 'form-control',
                    'required' => 'required' // Ajout de l'attribut HTML required
                ],
                'required' => true, // Validation Symfony
                'empty_data' => '', // Valeur par défaut si vide
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'échéancement est obligatoire',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeClt::class,
        ]);
    }
}