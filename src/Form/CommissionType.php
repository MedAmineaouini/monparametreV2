<?php

namespace App\Form;

use App\Entity\Commission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', null, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ]);
            
        for ($i = 1; $i <= 36; $i++) {
            $builder->add("comm$i", null, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'text-align: center;'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commission::class,
        ]);
    }
}