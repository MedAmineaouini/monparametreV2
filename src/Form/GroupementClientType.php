<?php
namespace App\Form;

use App\Entity\GroupementClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class GroupementClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('groupeclient', TextType::class, [
                'label' => 'Code groupement : ',
                'attr' => [
                    'maxlength' => 10,
                    'placeholder' => 'Code (10 caractères max)'
                ]
            ])
            ->add('nomgroupeclient', TextType::class, [
                'label' => 'Nom du groupement : ',
                'attr' => [
                    'maxlength' => 30,
                    'placeholder' => 'Nom complet'
                ]
            ])
            ->add('archiver', CheckboxType::class, [
                'label' => 'Archivé : ',
                'required' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'form-check-input']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupementClient::class,
        ]);
    }
}