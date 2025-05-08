<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MAJ')
            ->add('CODEUTIL')
            ->add('NOMUTIL')
            ->add('PROFILUTIL')
            ->add('MDP')
            ->add('BADGE')
            ->add('FLAG1')
            ->add('FLAG2')
            ->add('DATEDEB')
            ->add('HEURED')
            ->add('DATEFIN')
            ->add('HEUREF')
            ->add('ENCOURS')
            ->add('SEQNIVEAU')
            ->add('emailutil')
            ->add('WEBLOGIN')
            ->add('WEBMDP')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
