<?php

namespace App\Entity;

use App\Repository\EnergySupplyGDPRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnergySupplyGDPRepository::class)]
class EnergySupplyGDP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(name: "precentage")]
    private ?float $precentage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getPrecentage(): ?float
    {
        return $this->precentage;
    }

    public function setPrecentage(float $precentage): static
    {
        $this->precentage = $precentage;

        return $this;
    }
}
