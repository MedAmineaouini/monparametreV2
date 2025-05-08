<?php
// src/Entity/Parametre.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ParametreRepository')]
#[ORM\Table(name: 'PARAMETRE')]
class Parametre
{
#[ORM\Id]
#[ORM\GeneratedValue(strategy: 'AUTO')]
#[ORM\Column(type: 'integer', name: 'SEQPARAM')]
private $seqparam;

#[ORM\Column(type: 'string', length: 25, name: 'ENTETE1')]
private $entete1;

#[ORM\Column(type: 'string', length: 25, name: 'ENTETE2')]
private $entete2;

#[ORM\Column(type: 'string', length: 30, name: 'ADRESSE')]
private $adresse;

#[ORM\Column(type: 'string', length: 10, name: 'CP')]
private $cp;

#[ORM\Column(type: 'string', length: 20, name: 'VILLE')]
private $ville;

#[ORM\Column(type: 'string', length: 20, name: 'PAYS')]
private $pays;

#[ORM\Column(type: 'string', length: 16, name: 'TEL')]
private $tel;

#[ORM\Column(type: 'string', length: 16, name: 'FAX')]
private $fax;

#[ORM\Column(type: 'string', length: 50, name: 'EMAIL')]
private $email;

#[ORM\Column(type: 'integer', name: 'SEQRESA')]
private $seqresa;

#[ORM\Column(type: 'string', length: 50, name: 'CONTACTFR')]
private $contactfr;

#[ORM\Column(type: 'string', length: 50, name: 'CONTACT')]
private $contact;

#[ORM\Column(type: 'float', name: 'EURO')]
private $euro;

#[ORM\Column(type: 'string', length: 50, name: 'EXPEDITEUR')]
private $expediteur;

#[ORM\Column(type: 'boolean', name: 'ALERTE')]
private $alerte;

#[ORM\Column(type: 'float', name: 'BTOBVOL')]
private $btobvol;

#[ORM\Column(type: 'string', length: 20, name: 'TEL2')]
private $tel2;

#[ORM\Column(type: 'string', length: 20, name: 'TEL3')]
private $tel3;

#[ORM\Column(type: 'string', length: 20, name: 'TEL4')]
private $tel4;

#[ORM\Column(type: 'float', name: 'MARGE')]
private $marge;

    /**
     * @return mixed
     */
    public function getSeqparam()
    {
        return $this->seqparam;
    }

    /**
     * @param mixed $seqparam
     */
    public function setSeqparam($seqparam): void
    {
        $this->seqparam = $seqparam;
    }

    /**
     * @return mixed
     */
    public function getEntete1()
    {
        return $this->entete1;
    }

    /**
     * @param mixed $entete1
     */
    public function setEntete1($entete1): void
    {
        $this->entete1 = $entete1;
    }

    /**
     * @return mixed
     */
    public function getEntete2()
    {
        return $this->entete2;
    }

    /**
     * @param mixed $entete2
     */
    public function setEntete2($entete2): void
    {
        $this->entete2 = $entete2;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param mixed $cp
     */
    public function setCp($cp): void
    {
        $this->cp = $cp;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays): void
    {
        $this->pays = $pays;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSeqresa()
    {
        return $this->seqresa;
    }

    /**
     * @param mixed $seqresa
     */
    public function setSeqresa($seqresa): void
    {
        $this->seqresa = $seqresa;
    }

    /**
     * @return mixed
     */
    public function getContactfr()
    {
        return $this->contactfr;
    }

    /**
     * @param mixed $contactfr
     */
    public function setContactfr($contactfr): void
    {
        $this->contactfr = $contactfr;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getEuro()
    {
        return $this->euro;
    }

    /**
     * @param mixed $euro
     */
    public function setEuro($euro): void
    {
        $this->euro = $euro;
    }

    /**
     * @return mixed
     */
    public function getExpediteur()
    {
        return $this->expediteur;
    }

    /**
     * @param mixed $expediteur
     */
    public function setExpediteur($expediteur): void
    {
        $this->expediteur = $expediteur;
    }

    /**
     * @return mixed
     */
    public function getAlerte()
    {
        return $this->alerte;
    }

    /**
     * @param mixed $alerte
     */
    public function setAlerte($alerte): void
    {
        $this->alerte = $alerte;
    }

    /**
     * @return mixed
     */
    public function getBtobvol()
    {
        return $this->btobvol;
    }

    /**
     * @param mixed $btobvol
     */
    public function setBtobvol($btobvol): void
    {
        $this->btobvol = $btobvol;
    }

    /**
     * @return mixed
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * @param mixed $tel2
     */
    public function setTel2($tel2): void
    {
        $this->tel2 = $tel2;
    }

    /**
     * @return mixed
     */
    public function getTel3()
    {
        return $this->tel3;
    }

    /**
     * @param mixed $tel3
     */
    public function setTel3($tel3): void
    {
        $this->tel3 = $tel3;
    }

    /**
     * @return mixed
     */
    public function getTel4()
    {
        return $this->tel4;
    }

    /**
     * @param mixed $tel4
     */
    public function setTel4($tel4): void
    {
        $this->tel4 = $tel4;
    }

    /**
     * @return mixed
     */
    public function getMarge()
    {
        return $this->marge;
    }

    /**
     * @param mixed $marge
     */
    public function setMarge($marge): void
    {
        $this->marge = $marge;
    }

// Getter and Setter methods for each property...

}
