<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "COMMISSION")]
class Commission
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQCOMM", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "CATEGORIE", type: "string", length: 2, unique: true, options: ["default" => ""])]
    private string $categorie = '';

    #[ORM\Column(name: "COMM1", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm1 = '0.00';

    #[ORM\Column(name: "COMM2", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm2 = '0.00';

    #[ORM\Column(name: "COMM3", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm3 = '0.00';

    #[ORM\Column(name: "COMM4", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm4 = '0.00';

    #[ORM\Column(name: "COMM5", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm5 = '0.00';

    #[ORM\Column(name: "COMM6", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm6 = '0.00';

    #[ORM\Column(name: "COMM7", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm7 = '0.00';

    #[ORM\Column(name: "COMM8", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm8 = '0.00';

    #[ORM\Column(name: "COMM9", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm9 = '0.00';

    #[ORM\Column(name: "COMM10", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm10 = '0.00';

    #[ORM\Column(name: "COMM11", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm11 = '0.00';

    #[ORM\Column(name: "COMM12", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm12 = '0.00';

    #[ORM\Column(name: "COMM13", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm13 = '0.00';

    #[ORM\Column(name: "COMM14", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm14 = '0.00';

    #[ORM\Column(name: "COMM15", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm15 = '0.00';

    #[ORM\Column(name: "COMM16", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm16 = '0.00';

    #[ORM\Column(name: "COMM17", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm17 = '0.00';

    #[ORM\Column(name: "COMM18", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm18 = '0.00';

    #[ORM\Column(name: "COMM19", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm19 = '0.00';

    #[ORM\Column(name: "COMM20", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm20 = '0.00';

    #[ORM\Column(name: "COMM21", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm21 = '0.00';

    #[ORM\Column(name: "COMM22", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm22 = '0.00';

    #[ORM\Column(name: "COMM23", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm23 = '0.00';

    #[ORM\Column(name: "COMM24", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm24 = '0.00';

    #[ORM\Column(name: "COMM25", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm25 = '0.00';

    #[ORM\Column(name: "COMM26", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm26 = '0.00';

    #[ORM\Column(name: "COMM27", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm27 = '0.00';

    #[ORM\Column(name: "COMM28", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm28 = '0.00';

    #[ORM\Column(name: "COMM29", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm29 = '0.00';

    #[ORM\Column(name: "COMM30", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm30 = '0.00';

    #[ORM\Column(name: "COMM31", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm31 = '0.00';

    #[ORM\Column(name: "COMM32", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm32 = '0.00';

    #[ORM\Column(name: "COMM33", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm33 = '0.00';

    #[ORM\Column(name: "COMM34", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm34 = '0.00';

    #[ORM\Column(name: "COMM35", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm35 = '0.00';

    #[ORM\Column(name: "COMM36", type: "decimal", precision: 6, scale: 2, options: ["default" => "0.00"])]
    private string $comm36 = '0.00';

    // Getters and setters

    public function getId(): ?int { return $this->id; }

    public function getCategorie(): string { return $this->categorie; }
    public function setCategorie(string $categorie): static { $this->categorie = $categorie; return $this; }

    public function getComm1(): string { return $this->comm1; }
    public function setComm1(string $val): static { $this->comm1 = $val; return $this; }

    public function getComm2(): string { return $this->comm2; }
    public function setComm2(string $val): static { $this->comm2 = $val; return $this; }

    public function getComm3(): string { return $this->comm3; }
    public function setComm3(string $val): static { $this->comm3 = $val; return $this; }

    public function getComm4(): string { return $this->comm4; }
    public function setComm4(string $val): static { $this->comm4 = $val; return $this; }

    public function getComm5(): string { return $this->comm5; }
    public function setComm5(string $val): static { $this->comm5 = $val; return $this; }

    public function getComm6(): string { return $this->comm6; }
    public function setComm6(string $val): static { $this->comm6 = $val; return $this; }

    public function getComm7(): string { return $this->comm7; }
    public function setComm7(string $val): static { $this->comm7 = $val; return $this; }

    public function getComm8(): string { return $this->comm8; }
    public function setComm8(string $val): static { $this->comm8 = $val; return $this; }

    public function getComm9(): string { return $this->comm9; }
    public function setComm9(string $val): static { $this->comm9 = $val; return $this; }

    public function getComm10(): string { return $this->comm10; }
    public function setComm10(string $val): static { $this->comm10 = $val; return $this; }

    public function getComm11(): string { return $this->comm11; }
    public function setComm11(string $val): static { $this->comm11 = $val; return $this; }

    public function getComm12(): string { return $this->comm12; }
    public function setComm12(string $val): static { $this->comm12 = $val; return $this; }

    public function getComm13(): string { return $this->comm13; }
    public function setComm13(string $val): static { $this->comm13 = $val; return $this; }

    public function getComm14(): string { return $this->comm14; }
    public function setComm14(string $val): static { $this->comm14 = $val; return $this; }

    public function getComm15(): string { return $this->comm15; }
    public function setComm15(string $val): static { $this->comm15 = $val; return $this; }

    public function getComm16(): string { return $this->comm16; }
    public function setComm16(string $val): static { $this->comm16 = $val; return $this; }

    public function getComm17(): string { return $this->comm17; }
    public function setComm17(string $val): static { $this->comm17 = $val; return $this; }

    public function getComm18(): string { return $this->comm18; }
    public function setComm18(string $val): static { $this->comm18 = $val; return $this; }

    public function getComm19(): string { return $this->comm19; }
    public function setComm19(string $val): static { $this->comm19 = $val; return $this; }

    public function getComm20(): string { return $this->comm20; }
    public function setComm20(string $val): static { $this->comm20 = $val; return $this; }

    public function getComm21(): string { return $this->comm21; }
    public function setComm21(string $val): static { $this->comm21 = $val; return $this; }

    public function getComm22(): string { return $this->comm22; }
    public function setComm22(string $val): static { $this->comm22 = $val; return $this; }

    public function getComm23(): string { return $this->comm23; }
    public function setComm23(string $val): static { $this->comm23 = $val; return $this; }

    public function getComm24(): string { return $this->comm24; }
    public function setComm24(string $val): static { $this->comm24 = $val; return $this; }

    public function getComm25(): string { return $this->comm25; }
    public function setComm25(string $val): static { $this->comm25 = $val; return $this; }

    public function getComm26(): string { return $this->comm26; }
    public function setComm26(string $val): static { $this->comm26 = $val; return $this; }

    public function getComm27(): string { return $this->comm27; }
    public function setComm27(string $val): static { $this->comm27 = $val; return $this; }

    public function getComm28(): string { return $this->comm28; }
    public function setComm28(string $val): static { $this->comm28 = $val; return $this; }

    public function getComm29(): string { return $this->comm29; }
    public function setComm29(string $val): static { $this->comm29 = $val; return $this; }

    public function getComm30(): string { return $this->comm30; }
    public function setComm30(string $val): static { $this->comm30 = $val; return $this; }

    public function getComm31(): string { return $this->comm31; }
    public function setComm31(string $val): static { $this->comm31 = $val; return $this; }

    public function getComm32(): string { return $this->comm32; }
    public function setComm32(string $val): static { $this->comm32 = $val; return $this; }

    public function getComm33(): string { return $this->comm33; }
    public function setComm33(string $val): static { $this->comm33 = $val; return $this; }

    public function getComm34(): string { return $this->comm34; }
    public function setComm34(string $val): static { $this->comm34 = $val; return $this; }

    public function getComm35(): string { return $this->comm35; }
    public function setComm35(string $val): static { $this->comm35 = $val; return $this; }

    public function getComm36(): string { return $this->comm36; }
    public function setComm36(string $val): static { $this->comm36 = $val; return $this; }

    public function __toString(): string
{
    return $this->categorie ?? ''; 
}
}
