<?php
namespace App\Factory;

use App\Entity\RenewableEnergyTWh;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerLan;
use Exception;

class FactoryManager
{
    private RenewableEnergyTWhFactory $renewableEnergyTWhFactory;
    private RenewableEnergyPercentageFactory $renewableEnergyPercentageFactory;
    private ElectricityPriceFactory $electricityPriceFactory;
    private AverageConsumptionFactory $averageConsumptionFactory;
    private EnergySupplyGDPFactory $energySupplyGDPFactory;
    private LanElomradeFactory $lanElomradeFactory;
    private PopulationPerLanFactory $populationPerLanFactory;

    public function __construct(
        RenewableEnergyTWhFactory $renewableEnergyTWhFactory,
        RenewableEnergyPercentageFactory $renewableEnergyPercentageFactory,
        ElectricityPriceFactory $electricityPriceFactory,
        AverageConsumptionFactory $averageConsumptionFactory,
        EnergySupplyGDPFactory $energySupplyGDPFactory,
        LanElomradeFactory $lanElomradeFactory,
        PopulationPerLanFactory $populationPerLanFactory
    ) {
        $this->renewableEnergyTWhFactory = $renewableEnergyTWhFactory;
        $this->renewableEnergyPercentageFactory = $renewableEnergyPercentageFactory;
        $this->electricityPriceFactory = $electricityPriceFactory;
        $this->averageConsumptionFactory = $averageConsumptionFactory;
        $this->energySupplyGDPFactory = $energySupplyGDPFactory;
        $this->lanElomradeFactory = $lanElomradeFactory;
        $this->populationPerLanFactory = $populationPerLanFactory;
    }

    public function getFactory(string $entityClass)
    {
        switch ($entityClass) {
            case RenewableEnergyTWh::class:
                return $this->renewableEnergyTWhFactory;
            case RenewableEnergyPercentage::class:
                return $this->renewableEnergyPercentageFactory;
            case ElectricityPrice::class:
                return $this->electricityPriceFactory;
            case AverageConsumption::class:
                return $this->averageConsumptionFactory;
            case EnergySupplyGDP::class:
                return $this->energySupplyGDPFactory;
            case LanElomrade::class:
                return $this->lanElomradeFactory;
            case PopulationPerLan::class:
                return $this->populationPerLanFactory;
            default:
                throw new Exception("Unknown entity class: $entityClass");
        }
    }
}
