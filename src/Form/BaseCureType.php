<?php

namespace App\Form;

use App\Entity\BaseCure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseCureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codelibcure', TextType::class, [
                'label' => 'Code: ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code Lib Cure...',
                ],
            ])
            // ->add('seqcure', TextType::class, [
            //     'label' => 'Seq Cure : ',
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => 'Séquence Cure...',
            //     ],
            // ])
            // ->add('seq', TextType::class, [
            //     'label' => 'Séquence : ',
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => 'Séquence...',
            //     ],
            // ])
            ->add('libelleCure', TextType::class, [
                'label' => 'Libellé : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Libellé de la cure...',
                ],
            ])
            // ->add('typecure', TextType::class, [
            //     'label' => 'Type de Cure : ',
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => 'Type de cure...',
            //     ],
            // ])
            // ->add('ancien', ChoiceType::class, [
            //     'label' => 'Ancien : ',
            //     'choices' => [
            //         'Oui' => true,
            //         'Non' => false,
            //     ],
            //     'attr' => [
            //         'class' => 'form-select',
            //     ],
            //     'required' => true,
            // ])
            ->add('archiver', ChoiceType::class, [
                'label' => 'Archiver : ',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'required' => true,
            ]);
            // ->add('seqtypecure', TextType::class, [
            //     'label' => 'Seq Type Cure : ',
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => 'Séquence type cure...',
            //     ],
            // ])
            // ->add('libtypecure', TextType::class, [
            //     'label' => 'Lib Type Cure : ',
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder' => 'Libellé type cure...',
            //     ],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BaseCure::class,
        ]);
    }
}
