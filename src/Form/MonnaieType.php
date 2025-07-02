<?php

namespace App\Form;

use App\Entity\Monnaie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonnaieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libmonnaie', TextType::class, [
                'label' => 'Libellé monnaie : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Libellé de la monnaie...',
                ],
            ])
            ->add('nommonnaie', TextType::class, [
                'label' => 'Nom : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la monnaie...',
                ],
            ])
            ->add('taux', NumberType::class, [
                'label' => 'Taux : ',
                'scale' => 6,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Taux...',
                    'step' => '0.000001'
                ],
            ])
            ->add('libpays', TextType::class, [
                'label' => 'Libellé pays : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pays lié à la monnaie...',
                ],
            ])
            ->add('calcul', TextType::class, [
                'label' => 'Mode de calcul : ',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('datemaj', DateType::class, [
                'label' => 'Date de mise à jour : ',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('idpays', TextType::class, [
                'label' => 'Code pays : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code ISO du pays...',
                    'maxlength' => '3'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Monnaie::class,
        ]);
    }
}
