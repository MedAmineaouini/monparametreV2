<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Region;
use App\Entity\Commercial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $regions = $options['regions'] ?? null;
        $commercials = $options['commercials'] ?? null;

        $builder
            ->add('code_departement', TextType::class, [
                'label' => 'Code Département',
                'attr' => [
                    'class' => 'form-control mode',
                ],
              
            ])
            ->add('lib_departement', TextType::class, [
                'label' => 'Libellé Département',
                'attr' => [
                    'class' => 'form-control mode',
                ],
                
            ])
            ->add('codecommercial', TextType::class, [
                'label' => 'Code Commercial',
                'attr' => [
                    'class' => 'form-control mode',
                ],
               
            ])
            // ->add('region', EntityType::class, [
            //     'class' => Region::class,
            //     'choice_label' => 'libregion',
            //     'label' => 'Région',
            //     'placeholder' => 'Sélectionnez une région',
            //     'choices' => $regions,
            //     'required' => true,
            // ])
            // ->add('commercial', EntityType::class, [
            //     'class' => Commercial::class,
            //     'choice_label' => function (Commercial $commercial) {
            //         return $commercial->getCodeCommercial() . ' - ' . $commercial->getNomCommercial();
            //     },
            //     'label' => 'Commercial',
            //     'placeholder' => 'Sélectionnez un commercial',
            //     'choices' => $commercials,
            //     'required' => false,
            // ]);
            ->add('commercial', EntityType::class, [
                'class' => Commercial::class,
                'choice_label' => function (Commercial $commercial) {
                    return $commercial->getCodeCommercial() . ' - ' . $commercial->getNomCommercial();
                },
                'attr' => [
                    'class' => 'form-select', 
                ],
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'libregion',
                'attr' => [
                    'class' => 'form-select', 
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
            'regions' => null,
            'commercials' => null,
        ]);
    }
}
