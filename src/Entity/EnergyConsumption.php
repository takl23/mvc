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
    private ?int $se1 = null;

    #[ORM\Column]
    private ?int $se2 = null;

    #[ORM\Column]
    private ?int $se3 = null;

    #[ORM\Column]
    private ?int $se4 = null;

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

    public function getse1(): ?int
    {
        return $this->se1;
    }

    public function setse1(int $se1): static
    {
        $this->se1 = $se1;

        return $this;
    }

    public function getse2(): ?int
    {
        return $this->se2;
    }

    public function setse2(int $se2): static
    {
        $this->se2 = $se2;

        return $this;
    }

    public function getse3(): ?int
    {
        return $this->se3;
    }

    public function setse3(int $se3): static
    {
        $this->se3 = $se3;

        return $this;
    }

    public function getse4(): ?int
    {
        return $this->se4;
    }

    public function setse4(int $se4): static
    {
        $this->se4 = $se4;

        return $this;
    }
}
