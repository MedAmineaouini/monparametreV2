<?php

namespace App\Form;

use App\Entity\Monnaie;
use App\Repository\PaysRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonnaieType extends AbstractType
{
    private PaysRepository $paysRepository;

    public function __construct(PaysRepository $paysRepository)
    {
        $this->paysRepository = $paysRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libmonnaie', TextType::class, [
                'label' => 'Monnaie : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Libellé de la monnaie...',
                ],
            ])
            ->add('nommonnaie', TextType::class, [
                'label' => 'Nom : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la monnaie...',
                ],
            ])
            ->add('taux', NumberType::class, [
                'label' => 'Taux : ',
                'scale' => 6,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Taux...',
                    'step' => '0.000001'
                ],
            ])
            ->add('libpays', TextType::class, [
            'label' => 'Pays : ',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Pays lié à la monnaie...',
                'readonly' => true, 
                ],
            ])
            ->add('datemaj', DateType::class, [
                'label' => 'Date de mise à jour : ',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('codepays', TextType::class, [
                'mapped' => false,
                'label' => 'Code pays',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 2,
                    'placeholder' => 'FR, TN, MA...'
                ]
            ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var Monnaie $monnaie */
            $monnaie = $event->getData();
            $form = $event->getForm();

            $codePays = strtoupper($form->get('codepays')->getData());

            if ($codePays) {
                $pays = $this->paysRepository->findOneBy(['CODEPAYS' => $codePays]);

                if ($pays) {
                    $monnaie->setPays($pays);
                    $monnaie->setLibpays($pays->getLIBPAYS());
                } else {
                    $form->get('codepays')->addError(
                        new \Symfony\Component\Form\FormError("Le code pays '{$codePays}' est invalide.")
                    );
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Monnaie::class,
        ]);
    }
}
