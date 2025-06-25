<?php

namespace App\Form;

use App\Entity\Typechambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypechambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libtypechambre')
            ->add('libtypechambre2')
            ->add('adultesMini')
            ->add('adultesMaxi')
            ->add('enfantsMini')
            ->add('enfantsMaxi')
            ->add('bebesMaxi')
            ->add('suppsg')
            ->add('capacite')
            ->add('sel')
            ->add('abrtypechambre')
            ->add('ordre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typechambre::class,
        ]);
    }
}
