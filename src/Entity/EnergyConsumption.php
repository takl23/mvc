<?php

namespace App\Entity;

use App\Repository\EnergyConsumptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnergyConsumptionRepository::class)]
class EnergyConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $SE1 = null;

    #[ORM\Column]
    private ?int $SE2 = null;

    #[ORM\Column]
    private ?int $SE3 = null;

    #[ORM\Column]
    private ?int $SE4 = null;

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

    public function getSE1(): ?int
    {
        return $this->SE1;
    }

    public function setSE1(int $SE1): static
    {
        $this->SE1 = $SE1;

        return $this;
    }

    public function getSE2(): ?int
    {
        return $this->SE2;
    }

    public function setSE2(int $SE2): static
    {
        $this->SE2 = $SE2;

        return $this;
    }

    public function getSE3(): ?int
    {
        return $this->SE3;
    }

    public function setSE3(int $SE3): static
    {
        $this->SE3 = $SE3;

        return $this;
    }

    public function getSE4(): ?int
    {
        return $this->SE4;
    }

    public function setSE4(int $SE4): static
    {
        $this->SE4 = $SE4;

        return $this;
    }
}
