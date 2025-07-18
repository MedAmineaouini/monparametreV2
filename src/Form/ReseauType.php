<?php

namespace App\Form;

use App\Entity\Reseau;
use App\Entity\SuperReseau;
use App\Entity\Typeregle;
use App\Entity\TypeClt;
use App\Entity\Commission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomreseau', TextType::class, [
                'label' => 'Nom du réseau',
                'required' => true,
            ])
            ->add('desactive', CheckboxType::class, [
                'label' => 'Désactivé',
                'required' => false,
            ])
            ->add('datesaisie', DateTimeType::class, [
                'label' => 'Date de saisie',
                'widget' => 'single_text',
                'required' => true,
                'input' => 'datetime_immutable', // Cette ligne est cruciale
            ])
            ->add('emailReseau', EmailType::class, [
                'label' => 'Email du réseau',
                'required' => false,
            ])
            ->add('codeorx', TextType::class, [
                'label' => 'Code ORX',
                'required' => false,
            ])
            ->add('seqsuperreseau', EntityType::class, [
                'class' => SuperReseau::class,
                'label' => 'Super réseau',
                'choice_label' => 'nomsuperreseau', // Remplacez 'nom' par la propriété appropriée de SuperReseau
                'required' => false,
                'placeholder' => 'Sélectionnez un super réseau',
            ])
            ->add('seqtyperegle', EntityType::class, [
                'class' => Typeregle::class,
                'label' => 'Type de règle',
                'choice_label' => 'libtyperegle', // Remplacez 'nom' par la propriété appropriée de Typeregle
                'required' => false,
                'placeholder' => 'Sélectionnez un type de règle',
            ])
            ->add('seqtypeclt', EntityType::class, [
                'class' => TypeClt::class,
                'label' => 'Type de client',
                'choice_label' => 'libtypeclt', // Remplacez 'nom' par la propriété appropriée de TypeClt
                'required' => false,
                'placeholder' => 'Sélectionnez un type de client',
            ])
            ->add('seqcomm', EntityType::class, [
                'class' => Commission::class,
                'label' => 'Commission',
                'choice_label' => 'categorie', // Remplacez 'nom' par la propriété appropriée de Commission
                'required' => false,
                'placeholder' => 'Sélectionnez une commission',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reseau::class,
        ]);
    }
}