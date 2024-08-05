<?php

namespace App\Entity;

use App\Repository\RenewableEnergyPercentageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenewableEnergyPercentageRepository::class)]
class RenewableEnergyPercentage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ar = null;

    #[ORM\Column(nullable: true)]
    private ?int $varme_kyla_industri_mm = null;

    #[ORM\Column(nullable: true)]
    private ?int $el = null;

    #[ORM\Column(nullable: true)]
    private ?int $transporter = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAr(): ?int
    {
        return $this->ar;
    }

    public function setAr(int $ar): static
    {
        $this->ar = $ar;

        return $this;
    }

    public function getVarmeKylaIndustriMm(): ?int
    {
        return $this->varme_kyla_industri_mm;
    }

    public function setVarmeKylaIndustriMm(?int $varme_kyla_industri_mm): static
    {
        $this->varme_kyla_industri_mm = $varme_kyla_industri_mm;

        return $this;
    }

    public function getEl(): ?int
    {
        return $this->el;
    }

    public function setEl(?int $el): static
    {
        $this->el = $el;

        return $this;
    }

    public function getTransporter(): ?int
    {
        return $this->transporter;
    }

    public function setTransporter(?int $transporter): static
    {
        $this->transporter = $transporter;

        return $this;
    }

    public function getTotalt(): ?int
    {
        return $this->totalt;
    }

    public function setTotalt(?int $totalt): static
    {
        $this->totalt = $totalt;

        return $this;
    }
}
