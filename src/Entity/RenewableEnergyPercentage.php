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
    private ?int $year = null;

    #[ORM\Column(nullable: true)]
    private ?int $vim = null;

    #[ORM\Column(nullable: true)]
    private ?int $el = null;

    #[ORM\Column(nullable: true)]
    private ?int $transport = null;

    #[ORM\Column(nullable: true)]
    private ?int $total = null;

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

    public function getVIM(): ?int
    {
        return $this->vim;
    }

    public function setVIM(?int $vim): static
    {
        $this->vim = $vim;

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

    public function getTransport(): ?int
    {
        return $this->transport;
    }

    public function setTransport(?int $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): static
    {
        $this->total = $total;

        return $this;
    }
}
