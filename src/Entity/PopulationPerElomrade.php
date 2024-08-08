<?php

namespace App\Entity;

use App\Repository\PopulationPerElomradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopulationPerElomradeRepository::class)]
class PopulationPerElomrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $year = null;

    #[ORM\Column(type: 'string', length: 3)]
    private ?string $elomrade = null;

    #[ORM\Column(type: 'integer')]
    private ?int $population = null;

    // Getters and setters

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

    public function getElomrade(): ?string
    {
        return $this->elomrade;
    }

    public function setElomrade(string $elomrade): static
    {
        $this->elomrade = $elomrade;
        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): static
    {
        $this->population = $population;
        return $this;
    }
}
