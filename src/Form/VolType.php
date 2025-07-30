<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seqvol', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nvol', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('datevol', DateType::class, [
                'label' => 'Date de vol',
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control',
                    'max' => (new \DateTimeImmutable('+1 year'))->format('Y-m-d'),
                ]
            ])
            ->add('retrocede', DateType::class, [
                'label' => 'Date fin chaine',
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control',
                    'max' => (new \DateTimeImmutable('+1 year'))->format('Y-m-d'),
                ]
            ])
            ->add('jo', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('jplus', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('villed', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('heured', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('villea', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('heurea', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('villev', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('typevol', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('kilos', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('codaffret', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('sg', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('vendu', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('reserve', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixada', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzza', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbba', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxea', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixadv', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzzv', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbbv', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixadv2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzzv2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbbv2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixadv3', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzzv3', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbbv3', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('supp1', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('supp2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxevente', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('cartevente', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxesovente', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder
            ->add('suppvol', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('dateconvo', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('heureconvo', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lieuconvo', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('comptoir', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('porte', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('agence', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telagence', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('formforf', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('formsec', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('obs', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('dateconf', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('datedeconf', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])

            ->add('assvol', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('taxea2', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('autres', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('coaf', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('lien', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('typeavion', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('compagnie', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('taxesolidarite', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('nomaxe', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('retro', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('paxRetro', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('datRetro', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('heuredv', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('heureav', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('dureevol', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('obsResa', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('paxEmbarque', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('heureEmbarque', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prestAbord', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('stockg', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('villedd', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder
            ->add('villeaa', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('vendug', NumberType::class, ['attr' => ['class' => 'form-control']])

            ->add('cron', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('soustock', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('reserves', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('vendus', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('engagement', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqvolGenerique', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('codaffret1', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('destination', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nature', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nvol2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxev', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxesolidaritev', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxesoventev', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('totaltaxea', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixadulte', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('codaffret2', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('maxVolsecAlloue', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('venduVolsec', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('nvolvia', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('obsVia', TextareaType::class, ['attr' => ['class' => 'form-control']])

            ->add('totMaxVolsec', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('totFreesale', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqreceptif', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('seqvilled', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqvillea', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqvillev', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqaffret1', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('seqaffret2', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('bagagesoption', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder
            ->add('prixbagagesoption', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('nbrbagagesoption', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('pnr', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('etablissement', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('natureVol', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('kilocabine', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixYield', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('aerod', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('aeroa', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('kilobebe', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('aerodep', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('aeroarr', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('specification', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('bagagesoute', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('coafv', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('prixada2', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixada3', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzza2', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzza3', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbba2', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbba3', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nomfour', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('semaine1', TextType::class, ['attr' => ['class' => 'form-control']])

            ->add('prixadav', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixbbav', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('prixzzav', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('taxeB2b', NumberType::class, ['attr' => ['class' => 'form-control']])

            ->add('stopsale', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('convoWeb', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('inclusSg', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('affecter', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('freesale1', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('rachatImmediat', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('affecters', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('boardingPass', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('archiver', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('pasAfficherHoraire', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('volsec', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('allotFreesale', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('retroVol', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('blocsiege', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('ferry', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('sgGarantis', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('freesale', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('ouvert', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('fictif', TextType::class, ['attr' => ['class' => 'form-control']]);

        ;





    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
