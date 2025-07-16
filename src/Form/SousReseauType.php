<?php

namespace App\Form;

use App\Entity\SousReseau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class SousReseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomsousreseau', TextType::class, [
                'label' => 'Nom du sous-réseau',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom du sous-réseau',
                    'required' => true
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du sous-réseau est obligatoire'
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousReseau::class,
            'attr' => [
                'novalidate' => 'novalidate',
                'class' => 'needs-validation'
            ]
        ]);
    }
}