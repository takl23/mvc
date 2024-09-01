<?php

namespace App\Tests\Factory;

use App\Factory\FactoryManager;
use App\Factory\RenewableEnergyTWhFactory;
use App\Factory\RenewableEnergyPercentageFactory;
use App\Factory\ElectricityPriceFactory;
use App\Factory\AverageConsumptionFactory;
use App\Factory\EnergySupplyGDPFactory;
use App\Factory\LanElomradeFactory;
use App\Factory\PopulationPerLanFactory;
use App\Entity\RenewableEnergyTWh;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerLan;
use PHPUnit\Framework\TestCase;
use Exception;

class FactoryManagerTest extends TestCase
{
    private FactoryManager $factoryManager;

    protected function setUp(): void
    {
        $this->factoryManager = new FactoryManager(
            new RenewableEnergyTWhFactory(),
            new RenewableEnergyPercentageFactory(),
            new ElectricityPriceFactory(),
            new AverageConsumptionFactory(),
            new EnergySupplyGDPFactory(),
            new LanElomradeFactory(),
            new PopulationPerLanFactory()
        );
    }

    public function testGetFactoryForRenewableEnergyTWh(): void
    {
        $factory = $this->factoryManager->getFactory(RenewableEnergyTWh::class);
        $this->assertInstanceOf(RenewableEnergyTWhFactory::class, $factory);
    }

    public function testGetFactoryForRenewableEnergyPercentage(): void
    {
        $factory = $this->factoryManager->getFactory(RenewableEnergyPercentage::class);
        $this->assertInstanceOf(RenewableEnergyPercentageFactory::class, $factory);
    }

    public function testGetFactoryForElectricityPrice(): void
    {
        $factory = $this->factoryManager->getFactory(ElectricityPrice::class);
        $this->assertInstanceOf(ElectricityPriceFactory::class, $factory);
    }

    public function testGetFactoryForAverageConsumption(): void
    {
        $factory = $this->factoryManager->getFactory(AverageConsumption::class);
        $this->assertInstanceOf(AverageConsumptionFactory::class, $factory);
    }

    public function testGetFactoryForEnergySupplyGDP(): void
    {
        $factory = $this->factoryManager->getFactory(EnergySupplyGDP::class);
        $this->assertInstanceOf(EnergySupplyGDPFactory::class, $factory);
    }

    public function testGetFactoryForLanElomrade(): void
    {
        $factory = $this->factoryManager->getFactory(LanElomrade::class);
        $this->assertInstanceOf(LanElomradeFactory::class, $factory);
    }

    public function testGetFactoryForPopulationPerLan(): void
    {
        $factory = $this->factoryManager->getFactory(PopulationPerLan::class);
        $this->assertInstanceOf(PopulationPerLanFactory::class, $factory);
    }

    public function testGetFactoryForUnknownClassThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Unknown entity class:");

        $this->factoryManager->getFactory('UnknownClass');
    }
}
