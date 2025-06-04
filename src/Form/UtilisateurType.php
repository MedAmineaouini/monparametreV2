<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SEQUTIL', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ]
            ])
            ->add('CODEUTIL', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('NOMUTIL', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('MDP', TextType::class, [
                'mapped' => true,
                'required' => false,
                'attr' => ['autocomplete' => 'new-password']
            ])
            ->add('ENCOURS', CheckboxType::class, [
                'required' => false,
                'label' => 'Utilisateur en cours',
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('SEQNIVEAU')
            ->add('emailutil', EmailType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('WEBLOGIN', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('WEBMDP', TextType::class, [
                'mapped' => true,
                'required' => false,
                'attr' => ['autocomplete' => 'new-password']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
