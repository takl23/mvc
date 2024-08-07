<?php

namespace App\Entity;

use App\Repository\AverageCostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AverageCostRepository::class)]
class AverageCost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?float $fl = null;

    #[ORM\Column]
    private ?float $costSE3 = null;

    #[ORM\Column]
    private ?float $costSE4 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getFl(): ?float
    {
        return $this->fl;
    }

    public function setFl(float $fl): static
    {
        $this->fl = $fl;

        return $this;
    }

    public function getCostSE3(): ?float
    {
        return $this->costSE3;
    }

    public function setCostSE3(float $costSE3): static
    {
        $this->costSE3 = $costSE3;

        return $this;
    }

    public function getCostSE4(): ?float
    {
        return $this->costSE4;
    }

    public function setCostSE4(float $costSE4): static
    {
        $this->costSE4 = $costSE4;

        return $this;
    }
}
