<?php

namespace App\Form;

use App\Entity\Curiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuristeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeCuriste')
            ->add('nomCuriste')
            ->add('adresse')
            ->add('cp')
            ->add('libVille')
            ->add('tel1')
            ->add('tel2')
            ->add('fax')
            ->add('email')
            ->add('contact1')
            ->add('contact2')
            ->add('obs')
            ->add('marge')
            ->add('sousPays')
            ->add('pays')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curiste::class,
        ]);
    }
}
