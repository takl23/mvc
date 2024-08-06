<?php

namespace App\Entity;

use App\Repository\RenewableEnergyTWhRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenewableEnergyTWhRepository::class)]
class RenewableEnergyTWh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(nullable: true)]
    private ?int $biofuels = null;

    #[ORM\Column(nullable: true)]
    private ?int $hydropower = null;

    #[ORM\Column(nullable: true)]
    private ?int $windPower = null;

    #[ORM\Column(nullable: true)]
    private ?int $heatPump = null;

    #[ORM\Column(nullable: true)]
    private ?int $solarEnergy = null;

    #[ORM\Column(nullable: true)]
    private ?int $total = null;

    #[ORM\Column(nullable: true)]
    private ?int $statTransferToNorway = null;

    #[ORM\Column(nullable: true)]
    private ?int $renewableEnergyInTargetCalculation = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalEnergyUse = null;

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

    public function getBiofuels(): ?int
    {
        return $this->biofuels;
    }

    public function setBiofuels(?int $biofuels): static
    {
        $this->biofuels = $biofuels;

        return $this;
    }

    public function getHydropower(): ?int
    {
        return $this->hydropower;
    }

    public function setHydropower(?int $hydropower): static
    {
        $this->hydropower = $hydropower;

        return $this;
    }

    public function getWindPower(): ?int
    {
        return $this->windPower;
    }

    public function setWindPower(?int $windPower): static
    {
        $this->windPower = $windPower;

        return $this;
    }

    public function getHeatPump(): ?int
    {
        return $this->heatPump;
    }

    public function setHeatPump(?int $heatPump): static
    {
        $this->heatPump = $heatPump;

        return $this;
    }

    public function getSolarEnergy(): ?int
    {
        return $this->solarEnergy;
    }

    public function setSolarEnergy(?int $solarEnergy): static
    {
        $this->solarEnergy = $solarEnergy;

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

    public function getStatTransferToNorway(): ?int
    {
        return $this->statTransferToNorway;
    }

    public function setStatTransferToNorway(?int $statTransferToNorway): static
    {
        $this->statTransferToNorway = $statTransferToNorway;

        return $this;
    }

    public function getRenewableEnergyInTargetCalculation(): ?int
    {
        return $this->renewableEnergyInTargetCalculation;
    }

    public function setRenewableEnergyInTargetCalculation(?int $renewableEnergyInTargetCalculation): static
    {
        $this->renewableEnergyInTargetCalculation = $renewableEnergyInTargetCalculation;

        return $this;
    }

    public function getTotalEnergyUse(): ?int
    {
        return $this->totalEnergyUse;
    }

    public function setTotalEnergyUse(?int $totalEnergyUse): static
    {
        $this->totalEnergyUse = $totalEnergyUse;

        return $this;
    }
}

