<?php

namespace App\Form;

use App\Entity\Vol;
use App\Form\DataTransformer\DateTimeImmutableTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seqvol')
            ->add('nvol')
            ->add('datevol', DateType::class, [
                'label' => 'Date de vol',
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control',
                    'max' => (new \DateTimeImmutable('+1 year'))->format('d-m-Y') // Optionnel : limite de date
                ]
            ])
            ->add('retrocede', DateType::class, [
                'label' => 'Date fin chaine',
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control',
                    'max' => (new \DateTimeImmutable('+1 year'))->format('d-m-Y') // Optionnel : limite de date
                ]
            ])

            ->add('jo')
            ->add('jplus')
            ->add('villed')
            ->add('heured')
            ->add('villea')
            ->add('heurea')
            ->add('villev')
            ->add('typevol')
            ->add('kilos')
            ->add('codaffret')
            ->add('sg')
            ->add('vendu')
            ->add('reserve')
            ->add('prixada')
            ->add('prixzza')
            ->add('prixbba')
            ->add('taxea')
            ->add('prixadv')
            ->add('prixzzv')
            ->add('prixbbv')
            ->add('prixadv2')
            ->add('prixzzv2')
            ->add('prixbbv2')
            ->add('prixadv3')
            ->add('prixzzv3')
            ->add('prixbbv3')
            ->add('supp1')
            ->add('supp2')
            ->add('taxevente')
            ->add('cartevente')
            ->add('taxesovente')
            ->add('suppvol')
            ->add('dateconvo')
            ->add('heureconvo')
            ->add('lieuconvo')
            ->add('comptoir')
            ->add('porte')
            ->add('agence')
            ->add('telagence')
            ->add('formforf')
            ->add('formsec')
            ->add('obs')
            ->add('dateconf')
            ->add('datedeconf')
            ->add('freesale')
            ->add('assvol')
            ->add('ouvert')
            ->add('taxea2')
            ->add('autres')
            ->add('coaf')
            ->add('fictif')
            ->add('lien')
            ->add('typeavion')
            ->add('compagnie')
            ->add('stopsale')
            ->add('taxesolidarite')
            ->add('nomaxe')
            ->add('retro')
            ->add('paxRetro')
            ->add('datRetro')
            ->add('heuredv')
            ->add('heureav')
            ->add('dureevol')
            ->add('convoWeb')
            ->add('obsResa')
            ->add('paxEmbarque')
            ->add('heureEmbarque')
            ->add('prestAbord')
            ->add('stockg')
            ->add('villedd')
            ->add('villeaa')
            ->add('vendug')
            ->add('inclusSg')
            ->add('cron')
            ->add('soustock')
            ->add('reserves')
            ->add('vendus')
            ->add('engagement')
            ->add('seqvolGenerique')
            ->add('codaffret1')
            ->add('destination')
            ->add('nature')
            ->add('nvol2')
            ->add('taxev')
            ->add('taxesolidaritev')
            ->add('taxesoventev')
            ->add('totaltaxea')
            ->add('prixadulte')
            ->add('codaffret2')
            ->add('maxVolsecAlloue')
            ->add('venduVolsec')
            ->add('nvolvia')
            ->add('obsVia')
            ->add('affecter')
            ->add('freesale1')
            ->add('totMaxVolsec')
            ->add('totFreesale')
            ->add('seqreceptif')
            ->add('rachatImmediat')
            ->add('seqvilled')
            ->add('seqvillea')
            ->add('seqvillev')
            ->add('seqaffret1')
            ->add('seqaffret2')
            ->add('affecters')
            ->add('boardingPass')
            ->add('bagagesoption')
            ->add('prixbagagesoption')
            ->add('nbrbagagesoption')
            ->add('pnr')
            ->add('etablissement')
            ->add('natureVol')
            ->add('archiver')
            ->add('kilocabine')
            ->add('prixYield')
            ->add('aerod')
            ->add('aeroa')
            ->add('pasAfficherHoraire')
            ->add('kilobebe')
            ->add('aerodep')
            ->add('aeroarr')
            ->add('specification')
            ->add('bagagesoute')
            ->add('coafv')
            ->add('volsec')
            ->add('allotFreesale')
            ->add('retroVol')
            ->add('prixada2')
            ->add('prixada3')
            ->add('prixzza2')
            ->add('prixzza3')
            ->add('prixbba2')
            ->add('prixbba3')
            ->add('ville')
            ->add('nomfour')
            ->add('semaine1')
            ->add('blocsiege')
            ->add('prixadav')
            ->add('prixbbav')
            ->add('prixzzav')
            ->add('taxeB2b')
            ->add('ferry')
            ->add('sgGarantis')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
