<?php

namespace App\Form;

use App\Entity\Typeregle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TyperegleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libtyperegle', TextType::class, ['label' => 'Libellé : ',
                'attr' => [
                    'class' => 'form-control mode',
                    'placeholder' => 'Libellé ...',
                ],
            ])
            ->add('contrepartie', TextType::class, ['label' => 'Compte N° : ',
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'N° Compte ...',
                    'maxlength' => '8',
                ],
            ])
            ->add('comptabilisable', ChoiceType::class, [
                'label' => 'Comptabilisable : ',
                'choices' => [
                    'O' => 'O',
                    'N' => 'N'
                ],
                'attr' => [
                    'class' => 'form-select',
                    'required' => 'required'
                ],
                'required' => true,
            ])
            ->add('journal', TextType::class, ['label' => 'Journal : ',
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'journal ...',
                    'maxlength' => '8',

                ],
            ])
            ->add('sens', ChoiceType::class, [
                'label' => 'Sens : ',
                'choices' => [
                    'D' => 'D',
                    'C' => 'C'
                ],
                'attr' => [
                    'class' => 'form-select',
                    'required' => 'required'
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typeregle::class,
        ]);
    }
}
