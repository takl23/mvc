<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use PHPUnit\Framework\TestCase;
use App\Entity\RenewableEnergyTWh;
use App\Entity\ElectricityPrice;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\PopulationPerLan;
use App\Entity\LanElomrade;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\FactoryManager;

class ImportServiceValidationTest extends TestCase
{
    /** @var ImportService */
    private $importService;

    /** @var EntityManagerInterface&\PHPUnit\Framework\MockObject\MockObject */
    private $entityManagerMock;

    /** @var FactoryManager&\PHPUnit\Framework\MockObject\MockObject */
    private $factoryManagerMock;

    protected function setUp(): void
    {
        // Create mocks for dependencies
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->factoryManagerMock = $this->createMock(FactoryManager::class);

        // Instantiate the ImportService with the mocked dependencies
        $this->importService = new ImportService(
            $this->entityManagerMock,
            $this->factoryManagerMock
        );
    }

    public function testIsEntityValidForRenewableEnergyTWh(): void
    {
        $entity = $this->createMock(RenewableEnergyTWh::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForElectricityPrice(): void
    {
        $entity = $this->createMock(ElectricityPrice::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForRenewableEnergyPercentage(): void
    {
        $entity = $this->createMock(RenewableEnergyPercentage::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForAverageConsumption(): void
    {
        $entity = $this->createMock(AverageConsumption::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForEnergySupplyGDP(): void
    {
        $entity = $this->createMock(EnergySupplyGDP::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForPopulationPerLan(): void
    {
        $entity = $this->createMock(PopulationPerLan::class);
        $entity->method('getYear')->willReturn(2021);

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }

    public function testIsEntityValidForLanElomrade(): void
    {
        $entity = $this->createMock(LanElomrade::class);
        $entity->method('getLan')->willReturn('Stockholms län');
        $entity->method('getElomrade')->willReturn('SE3');

        $result = $this->importService->isEntityValid($entity);

        $this->assertTrue($result);
    }
}
