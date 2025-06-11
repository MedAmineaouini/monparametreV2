<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeville')
            ->add('aero')
            ->add('libville')
            ->add('codeiata')
            ->add('seq_zone')
            ->add('iataaero')
            ->add('seqvilleparent')
            ->add('taxe_b2b')
            ->add('pays')
            ->add('souspays')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
