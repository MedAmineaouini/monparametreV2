<?php

namespace App\Form;

use App\Entity\Ville;
use App\Entity\Pays;
use App\Entity\Souspays;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeville', TextType::class, [
                'label' => 'Code Ville'
            ])
           ->add('aero')
            ->add('libville', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('codeiata', TextType::class, [
                'label' => 'Code ISO ville'
            ])
           ->add('seq_zone')
           ->add('iataaero')
           ->add('seqvilleparent')
           ->add('taxe_b2b')
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'LIBPAYS', 
            ])
            ->add('souspays', EntityType::class, [
                'class' => SousPays::class,
                'choice_label' => 'LIBSOUSPAYS',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
