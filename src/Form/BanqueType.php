<?php

namespace App\Form;

use App\Entity\Banque;
use App\Entity\Ville;
use App\Entity\Pays;

use App\Repository\VilleRepository;
use App\Repository\PaysRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;

class BanqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LIBBANQUE', TextType::class, [
                'label' => 'Banque'
            ])
            ->add('CPTBANQUE', TextType::class, [
                'label' => 'N° de compte'
            ])
            ->add('SWFBANQUE', TextType::class, [
                'label' => 'Code Swift'
            ])
            ->add('ADRBANQUE', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('CPBANQUE', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('TELBANQUE', TextType::class, [
                'label' => 'Téléphone'
            ])
            ->add('FAXBANQUE', TextType::class, [
                'label' => 'Fax',
                'required' => false,
            ])
            ->add('EMLBANQUE', TextType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('OBSBANQUE', TextareaType::class, [  
                'label' => 'Observations',
                'required' => false, 
                'attr' => [
                    'rows' => 5, 
                ],
            ])
            // ->add('numterminal', TextType::class, [
            //     'label' => 'Numéro terminal'
            // ])
            // ->add('Journal1', TextType::class, [
            //     'label' => 'Journal 1',
            //     'required' => false,
            // ])
            // ->add('Journal2', TextType::class, [
            //     'label' => 'Journal 2',
            //     'required' => false,
            // ])
            // ->add('compte1', TextType::class, [
            //     'label' => 'Compte 1',
            //     'required' => false,
            // ])
            // ->add('compte2', TextType::class, [
            //     'label' => 'Compte 2',
            //     'required' => false,
            // ])
            ->add('VILBANQUE', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libville',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.libville', 'ASC');
                },
                'label' => 'Ville',
                'placeholder' => 'Sélectionner une ville',
                'attr' => ['class' => 'form-select']
            ])
            ->add('PAYBANQUE', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'LIBPAYS',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.LIBPAYS', 'ASC');
                },
                'label' => 'Pays',
                'placeholder' => 'Sélectionner un pays',
                'attr' => ['class' => 'form-select']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banque::class,
        ]);
    }
}
