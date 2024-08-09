<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AverageAnnualCostPerPerson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $year;

    #[ORM\Column(type: 'string', length: 255)]
    private string $elomrade;

    #[ORM\Column(type: 'float')]
    private float $averageCostPerPerson;

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

    public function getElomrade(): ?string
    {
        return $this->elomrade;
    }

    public function setElomrade(string $elomrade): self
    {
        $this->elomrade = $elomrade;
        return $this;
    }

    public function getAverageCostPerPerson(): ?float
    {
        return $this->averageCostPerPerson;
    }

    public function setAverageCostPerPerson(float $averageCostPerPerson): self
    {
        $this->averageCostPerPerson = $averageCostPerPerson;
        return $this;
    }
}
