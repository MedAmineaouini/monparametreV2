<?php

namespace App\Form;

use App\Entity\TypePromo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypePromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libTypePromo', TextType::class, ['label' => 'Libellé : ',
        'attr' => [
            'class' => 'form-control mode',
            'placeholder' => 'Libellé ...',
        ],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypePromo::class,
        ]);
    }
}
