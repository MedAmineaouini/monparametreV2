<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('CODEPAYS', null, [
                'label' => 'Code pays'
            ])
            ->add('LIBPAYS', null, ['label' => 'Libellé'])
            ->add('PLACE', null, ['label' => 'Position'])
            ->add('ORDRE', null, ['label' => 'Ordre'])
            ->add('NATURE', null,['label' => 'Nature'])
            ->add('CONTINENT', null, ['label' => 'Continent'])
            ->add('FORMALITE', TextareaType::class, [  
                'label' => 'Formalité',
                'required' => false, 
                'attr' => [
                    'rows' => 5, 
                ],
            ])
            ->add('OBSERVATION', TextareaType::class, [  
                'label' => 'Observation',
                'required' => false, 
                'attr' => [
                    'rows' => 5, 
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
