<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Souspays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SouspaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libsouspays', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'form-control mode',
                    'placeholder' => 'Libellé ...',
                ],
            ])
            ->add('tun', NumberType::class, [
                'label' => 'Tun',
                'required' => false,
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'step' => '0.01', // permet les décimales
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 123.45',
                    ]
                ])
            ->add('mir')
            ->add('nbe')
            ->add('dje')
            ->add('toe')
            ->add('tunvente')
            ->add('mirvente')
            ->add('nbevente')
            ->add('djevente')
            ->add('toevente')
//            ->add('ordre')
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'libpays', // <-- Adapté au nom du champ lisible dans ton entité Pays
                'placeholder' => 'Sélectionner un pays',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souspays::class,
        ]);
    }
}
