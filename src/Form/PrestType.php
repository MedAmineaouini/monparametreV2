<?php

namespace App\Form;

use App\Entity\Prest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LIBPREST', null, [
                'label' => 'Libellé de la prestation',
                'required' => false,
            ])
            ->add('CODEPREST', null, [
                'label' => 'Code XFT',
                'required' => false,
            ])
            ->add('ACTIVER', CheckboxType::class, [
                'required' => false,
                'label' => 'Prestation active',
                'attr' => ['class' => 'form-check-input']
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prest::class,
        ]);
    }
}
