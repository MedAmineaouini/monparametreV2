<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('CODEPAYS', null, [
                'label' => 'Code pays'
            ])
            ->add('LIBPAYS', null, ['label' => 'Libellé'])
            ->add('PLACE', ChoiceType::class, [
                'label' => 'Lieu',
                'choices' => [
                    'CEE' => 'CEE',
                    'HORS CEE' => 'HORS CEE',
                    'FRANCE' => 'FRANCE',
                ],
                'attr' => [
                    'class' => 'form-control mode',
                ],
                'data' => 'HORS CEE', // valeur sélectionnée par défaut
                'placeholder' => false,
            ])
            ->add('CODE_IATA', TextType::class, [
                'label' => 'Code IATA',
                'attr' => [
                    'class' => 'form-control mode',
                    'style' => 'text-transform: uppercase;',
                    'placeholder' => 'Code iata...',
                ],
            ])
            ->add('NATURE', ChoiceType::class, [
                'label' => 'Nature',
                'choices'  => [
                    'Moyen courrier' => 1,
                    'Long courrier' => 2,
                ],
                'attr' => [
                    'class' => 'form-control mode',
                ],
                'placeholder' => false, // pas d'option vide
                'data' => 2, // valeur sélectionnée par défaut
                'required' => true,
                'expanded' => false, // false = <select>, true = radios
                'multiple' => false, // false = select simple
            ])
//            ->add('CONTINENT', null, ['label' => 'Continent'])
            ->add('FORMALITE', TextareaType::class, [  
                'label' => 'Formalité',
                'required' => false, 
                'attr' => [
                    'rows' => 5, 
                ],
            ])
            ->add('OBSERVATION', TextareaType::class, [  
                'label' => 'Observation',
                'required' => false, 
                'attr' => [
                    'rows' => 5, 
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
