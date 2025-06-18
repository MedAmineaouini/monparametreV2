<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Assur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AssurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libassur', TextType::class, [
                'label' => 'Assurance',
                'attr' => ['class' => 'form-control', 'maxlength' => 40, 'required' => 'required']
            ])
//            ->add('total1', NumberType::class, ['attr' => ['class' => 'form-control']])
//            ->add('total2', NumberType::class, ['attr' => ['class' => 'form-control']])
//            ->add('typevaleur', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('valeur', NumberType::class, ['label' => 'Montant','attr' => ['class' => 'form-control']])
//            ->add('prixvente', NumberType::class, ['attr' => ['class' => 'form-control']])
//            ->add('prixvente2', NumberType::class, ['attr' => ['class' => 'form-control']])
//            ->add('prixachat', NumberType::class, ['attr' => ['class' => 'form-control']])
//            ->add('prixachat2', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('mini1', IntegerType::class, ['label' => 'Mini','attr' => ['class' => 'form-control']])
            ->add('maxi1', IntegerType::class, ['label' => 'Maxi','attr' => ['class' => 'form-control']])
            ->add('valeurAchat', NumberType::class, ['label' => 'Achat','attr' => ['class' => 'form-control']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assur::class,
        ]);
    }
}
