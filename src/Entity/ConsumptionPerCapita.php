<?php

// src/Entity/ConsumptionPerCapita.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConsumptionPerCapitaRepository;

#[ORM\Entity(repositoryClass: ConsumptionPerCapitaRepository::class)]
class ConsumptionPerCapita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'string', length: 255)]
    private $elomrade;

    #[ORM\Column(type: 'float')]
    private $consumptionPerCapita;

    // Getters and setters...

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

    public function getConsumptionPerCapita(): ?float
    {
        return $this->consumptionPerCapita;
    }

    public function setConsumptionPerCapita(float $consumptionPerCapita): self
    {
        $this->consumptionPerCapita = $consumptionPerCapita;

        return $this;
    }
}
