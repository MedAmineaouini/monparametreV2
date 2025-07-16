<?php

namespace App\Form;

use App\Entity\Typechambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TypechambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libtypechambre', TextType::class, [
                'required' => false,
                'empty_data' => ' '
            ])
            ->add('libtypechambre2', TextType::class, [
                'required' => false,
                'empty_data' => ' '
            ])
            ->add('adultesMini', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('adultesMaxi', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('enfantsMini', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('enfantsMaxi', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('bebesMaxi', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('suppsg', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('capacite', IntegerType::class, [
                'empty_data' => 0
            ])
            ->add('sel', CheckboxType::class, [
                'required' => false,
                'empty_data' => false
            ])
            ->add('abrtypechambre', TextType::class, [
                'empty_data' => ' '
            ])
            ->add('ordre', IntegerType::class, [
                'empty_data' => 0
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typechambre::class,
            'allow_extra_fields' => true,
        ]);
    }
}