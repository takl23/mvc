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
    private ?int $Year = null;

    #[ORM\Column(nullable: true)]
    private ?int $Biofuels = null;

    #[ORM\Column(nullable: true)]
    private ?int $Hydropower = null;

    #[ORM\Column(nullable: true)]
    private ?int $Wind_Power = null;

    #[ORM\Column(nullable: true)]
    private ?int $Heat_Pump = null;

    #[ORM\Column(nullable: true)]
    private ?int $Solar_Energy = null;

    #[ORM\Column(nullable: true)]
    private ?int $Total = null;

    #[ORM\Column(nullable: true)]
    private ?int $Stat_Transfer_To_Norway = null;

    #[ORM\Column(nullable: true)]
    private ?int $Reneweble_Energy_In_Target_Calculation = null;

    #[ORM\Column(nullable: true)]
    private ?int $Total_Energy_Use = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->Year;
    }

    public function setYear(int $Year): static
    {
        $this->Year = $Year;

        return $this;
    }

    public function getBiofuels(): ?int
    {
        return $this->Biofuels;
    }

    public function setBiofuels(?int $Biofuels): static
    {
        $this->Biofuels = $Biofuels;

        return $this;
    }

    public function getHydropower(): ?int
    {
        return $this->Hydropower;
    }

    public function setHydropower(?int $Hydropower): static
    {
        $this->Hydropower = $Hydropower;

        return $this;
    }

    public function getWindPower(): ?int
    {
        return $this->Wind_Power;
    }

    public function setWindPower(?int $Wind_Power): static
    {
        $this->Wind_Power = $Wind_Power;

        return $this;
    }

    public function getHeatPump(): ?int
    {
        return $this->Heat_Pump;
    }

    public function setHeatPump(?int $Heat_Pump): static
    {
        $this->Heat_Pump = $Heat_Pump;

        return $this;
    }

    public function getSolarEnergy(): ?int
    {
        return $this->Solar_Energy;
    }

    public function setSolarEnergy(?int $Solar_Energy): static
    {
        $this->Solar_Energy = $Solar_Energy;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->Total;
    }

    public function setTotal(?int $Total): static
    {
        $this->Total = $Total;

        return $this;
    }

    public function getStatTransferToNorway(): ?int
    {
        return $this->Stat_Transfer_To_Norway;
    }

    public function setStatTransferToNorway(?int $Stat_Transfer_To_Norway): static
    {
        $this->Stat_Transfer_To_Norway = $Stat_Transfer_To_Norway;

        return $this;
    }

    public function getRenewebleEnergyInTargetCalculation(): ?int
    {
        return $this->Reneweble_Energy_In_Target_Calculation;
    }

    public function setRenewebleEnergyInTargetCalculation(?int $Reneweble_Energy_In_Target_Calculation): static
    {
        $this->Reneweble_Energy_In_Target_Calculation = $Reneweble_Energy_In_Target_Calculation;

        return $this;
    }

    public function getTotalEnergyUse(): ?int
    {
        return $this->Total_Energy_Use;
    }

    public function setTotalEnergyUse(?int $Total_Energy_Use): static
    {
        $this->Total_Energy_Use = $Total_Energy_Use;

        return $this;
    }
}
