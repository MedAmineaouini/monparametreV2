<?php

namespace App\Form;

use App\Entity\TypeAssur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypeAssurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libTypeAssur', TextType::class, [
                'label' => 'Type assurance',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 80,
                    'placeholder' => 'Type assurance'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le type d\'assurance est obligatoire.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeAssur::class,
        ]);
    }
}
