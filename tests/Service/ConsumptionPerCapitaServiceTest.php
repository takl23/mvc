<?php

namespace App\Tests\Service;

use App\Service\ConsumptionPerCapitaService;
use App\Entity\PopulationPerElomrade;
use App\Entity\AverageConsumption;
use App\Entity\ConsumptionPerCapita;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Exception;

class ConsumptionPerCapitaServiceTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManagerMock;

    /** @var EntityRepository<PopulationPerElomrade>&MockObject */
    private $populationRepoMock;

    /** @var EntityRepository<AverageConsumption>&MockObject */
    private $consumptionRepoMock;

    /** @var ConsumptionPerCapitaService */
    private $service;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->populationRepoMock = $this->createMock(EntityRepository::class);
        $this->consumptionRepoMock = $this->createMock(EntityRepository::class);

        // Mock the connection and platform
        $connectionMock = $this->createMock(Connection::class);
        $platformMock = $this->createMock(AbstractPlatform::class);

        $connectionMock->method('getDatabasePlatform')->willReturn($platformMock);
        $this->entityManagerMock->method('getConnection')->willReturn($connectionMock);

        $this->entityManagerMock->method('getRepository')->willReturnMap([
            [PopulationPerElomrade::class, $this->populationRepoMock],
            [AverageConsumption::class, $this->consumptionRepoMock],
        ]);

        $this->service = new ConsumptionPerCapitaService($this->entityManagerMock);
    }

    public function testCalculateAndSaveConsumptionPerCapita(): void
    {
        // Set up mock data for PopulationPerElomrade
        $population1 = $this->createMock(PopulationPerElomrade::class);
        $population1->method('getYear')->willReturn(2022);
        $population1->method('getElomrade')->willReturn('SE1');
        $population1->method('getPopulation')->willReturn(500000);

        $population2 = $this->createMock(PopulationPerElomrade::class);
        $population2->method('getYear')->willReturn(2022);
        $population2->method('getElomrade')->willReturn('SE2');
        $population2->method('getPopulation')->willReturn(700000);

        // Set up mock data for AverageConsumption
        $averageConsumption = $this->createMock(AverageConsumption::class);
        $averageConsumption->method('getYear')->willReturn(2022);
        $averageConsumption->method('getse1')->willReturn(100.0); // GWh
        $averageConsumption->method('getse2')->willReturn(200.0); // GWh

        // Setting up the repository mocks to return the mock data
        $this->populationRepoMock->method('findAll')->willReturn([$population1, $population2]);
        $this->consumptionRepoMock->method('findAll')->willReturn([$averageConsumption]);

        // Expect the entity manager to persist the ConsumptionPerCapita entities
        $this->entityManagerMock
            ->expects($this->exactly(2))
            ->method('persist')
            ->with($this->isInstanceOf(ConsumptionPerCapita::class));

        // Expect the entity manager to flush the changes
        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        // Run the service method
        $this->service->calculateAndSaveConsumptionPerCapita();

        // Assertions and expectations are handled through the mock's `expects` method
    }

    public function testCalculateAndSaveConsumptionPerCapitaWithMissingData(): void
    {
        // Simulate that no data is returned by the repository
        $this->populationRepoMock->method('findAll')->willReturn([]);
        $this->consumptionRepoMock->method('findAll')->willReturn([]);

        // Expect an exception to be thrown
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Missing necessary data to calculate consumption per capita.');

        // Run the method
        $this->service->calculateAndSaveConsumptionPerCapita();
    }
}
