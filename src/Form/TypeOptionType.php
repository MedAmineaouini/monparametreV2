<?php

namespace App\Form;

use App\Entity\TypeOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeOption', TextType::class, [
                'label' => 'Code :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code ...',
                ],
            ])
            ->add('nomOption', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom ...',
                ],
            ])
            ->add('autoriser', CheckboxType::class, [
                'required' => false,
                'label' => 'Options hôtels',
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('ordre', CheckboxType::class, [
                'required' => false,
                'label' => 'Produits complémentaires',
                'attr' => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeOption::class,
        ]);
    }
}
