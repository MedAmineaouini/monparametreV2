<?php

namespace App\Form;


use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('MAJ', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'attr' => [
            //         'class' => 'form-control flatpickr-date',
            //         'placeholder' => 'YYYY-MM-DD'
            //     ]
            // ])
            ->add('MAJ')
            ->add('CODEUTIL')
            ->add('NOMUTIL')
            ->add('PROFILUTIL')
            ->add('MDP', PasswordType::class)
            ->add('BADGE')
            ->add('FLAG1')
            ->add('FLAG2')
            ->add('DATEDEB')
            ->add('HEURED')
            ->add('DATEFIN')
            ->add('HEUREF')
            // ->add('DATEDEB', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'attr' => [
            //         'class' => 'form-control flatpickr-date',
            //         'placeholder' => 'YYYY-MM-DD'
            //     ]
            // ])
            // ->add('HEURED', TimeType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'attr' => [
            //         'class' => 'form-control flatpickr-time',
            //         'placeholder' => 'HH:MM'
            //     ]
            // ])
            // ->add('DATEFIN', DateType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'attr' => [
            //         'class' => 'form-control flatpickr-date',
            //         'placeholder' => 'YYYY-MM-DD'
            //     ]
            // ])
            // ->add('HEUREF', TimeType::class, [
            //     'widget' => 'single_text',
            //     'html5' => false,
            //     'attr' => [
            //         'class' => 'form-control flatpickr-time',
            //         'placeholder' => 'HH:MM'
            //     ]
            // ])
            ->add('ENCOURS')
            ->add('SEQNIVEAU')
            ->add('emailutil', EmailType::class)
            ->add('WEBLOGIN')
            ->add('WEBMDP', PasswordType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}