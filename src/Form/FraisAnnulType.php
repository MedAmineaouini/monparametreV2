<?php

namespace App\Form;

use App\Entity\FraisAnnul;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FraisAnnulType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('jour1', TextType::class, [
                'label' => 'De :',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('jour2', TextType::class, [
                'label' => 'A :',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('facteur', TextType::class, [
                'label' => 'Valeur :',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('typeannul', ChoiceType::class, [
                'label' => 'Type :',
                'choices' => [
                    'Taux' => 0,
                    'Valeur' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label_attr' => [
                    'class' => 'fw-bold mb-2',
                ],
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
            ])

            ->add('montantmini', TextType::class, [
                'label' => 'Mnt mini :',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('applicable', ChoiceType::class, [
                'label' => 'À appliquer :',
                'choices' => [
                    'Par personne' => 0,
                    'Par dossier' => 1,
                ],
                'placeholder' => 'Sélectionner',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FraisAnnul::class,
        ]);
    }
}
