<?php

namespace App\Form;

use App\Entity\Typechambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypechambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libtypechambre', TextType::class, [
                'label' => 'Libellé type chambre',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('libtypechambre2', TextType::class, [
                'label' => 'Libellé type chambre 2',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('adultesMini', IntegerType::class, [
                'label' => 'Adultes minimum',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('adultesMaxi', IntegerType::class, [
                'label' => 'Adultes maximum',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('enfantsMini', IntegerType::class, [
                'label' => 'Enfants minimum',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('enfantsMaxi', IntegerType::class, [
                'label' => 'Enfants maximum',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('bebesMaxi', IntegerType::class, [
                'label' => 'Bébés maximum',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('suppsg', IntegerType::class, [
                'label' => 'Supplément single',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('sel', CheckboxType::class, [
                'label' => 'Act',
                'attr' => ['class' => 'form-check-input'],
                'required' => false
            ])
            ->add('abrtypechambre', TextType::class, [
                'label' => 'Abréviation type chambre',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('ordre', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => ['class' => 'form-control'],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typechambre::class,
        ]);
    }
}
