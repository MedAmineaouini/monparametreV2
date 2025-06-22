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
            ->add('jour1', TextType::class, [
                'label' => 'Jour 1',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('jour2', TextType::class, [
                'label' => 'Jour 2',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('facteur', TextType::class, [
                'label' => 'Facteur',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('typeannul', ChoiceType::class, [
                'label' => 'Type d\'annulation',
                'choices' => [
                    'Taux' => 0,
                    'Valeur' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-check mode',
                ],
            ])
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('bareme', TextType::class, [
                'label' => 'Barème',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('montantmini', TextType::class, [
                'label' => 'Montant minimum',
                'attr' => [
                    'class' => 'form-control mode',
                ],
            ])
            ->add('applicable', ChoiceType::class, [
                'label' => 'À appliquer',
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
