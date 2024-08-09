<?php

namespace App\Entity;

use App\Repository\AverageConsumptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AverageConsumptionRepository::class)]
class AverageConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private ?int $year = null;

    #[ORM\Column(type: "float")]
    private ?float $se1 = null;

    #[ORM\Column(type: "float")]
    private ?float $se2 = null;

    #[ORM\Column(type: "float")]
    private ?float $se3 = null;

    #[ORM\Column(type: "float")]
    private ?float $se4 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getse1(): ?float
    {
        return $this->se1;
    }

    public function setse1(float $se1): self
    {
        $this->se1 = $se1;
        return $this;
    }

    public function getse2(): ?float
    {
        return $this->se2;
    }

    public function setse2(float $se2): self
    {
        $this->se2 = $se2;
        return $this;
    }

    public function getse3(): ?float
    {
        return $this->se3;
    }

    public function setse3(float $se3): self
    {
        $this->se3 = $se3;
        return $this;
    }

    public function getse4(): ?float
    {
        return $this->se4;
    }

    public function setse4(float $se4): self
    {
        $this->se4 = $se4;
        return $this;
    }
}
