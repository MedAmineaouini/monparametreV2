<?php

namespace App\Form;

use App\Entity\SuperReseau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class SuperReseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomsuperreseau', TextType::class, [
                'label' => 'Nom du super réseau',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom du super réseau'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du super réseau est obligatoire'
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('datesaisie', DateTimeType::class, [
                'label' => 'Date de saisie',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker',
                    'autocomplete' => 'off'
                ],
                'format' => 'dd/MM/yyyy HH:mm',
                'data' => new \DateTime(), // Valeur par défaut = maintenant
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de saisie est obligatoire'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperReseau::class,
            'attr' => [
                'class' => 'needs-validation' // Pour la validation Bootstrap
            ]
        ]);
    }
}