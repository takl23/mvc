<?php

namespace App\Entity;

use App\Repository\AverageTemperatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AverageTemperatureRepository::class)]
class AverageTemperature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?float $SE1 = null;

    #[ORM\Column]
    private ?float $SE2 = null;

    #[ORM\Column]
    private ?float $SE3 = null;

    #[ORM\Column]
    private ?float $SE4 = null;

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

    public function getSE1(): ?float
    {
        return $this->SE1;
    }

    public function setSE1(float $SE1): static
    {
        $this->SE1 = $SE1;

        return $this;
    }

    public function getSE2(): ?float
    {
        return $this->SE2;
    }

    public function setSE2(float $SE2): static
    {
        $this->SE2 = $SE2;

        return $this;
    }

    public function getSE3(): ?float
    {
        return $this->SE3;
    }

    public function setSE3(float $SE3): static
    {
        $this->SE3 = $SE3;

        return $this;
    }

    public function getSE4(): ?float
    {
        return $this->SE4;
    }

    public function setSE4(float $SE4): static
    {
        $this->SE4 = $SE4;

        return $this;
    }
}
