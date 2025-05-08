<?php

namespace App\Form;

use App\Entity\Parametre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entete1')
            ->add('entete2')
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('pays')
            ->add('tel')
            ->add('fax')
            ->add('email')
            ->add('seqresa')
            ->add('contactfr')
            ->add('contact')
            ->add('euro')
            ->add('expediteur')
            ->add('alerte')
            ->add('btobvol')
            ->add('tel2')
            ->add('tel3')
            ->add('tel4')
            ->add('marge')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametre::class,
        ]);
    }
}
