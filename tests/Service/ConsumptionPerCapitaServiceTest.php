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

class ConsumptionPerCapitaServiceTest extends TestCase
{
    /** @var MockObject|EntityManagerInterface */
    private $entityManagerMock;

    /** @var MockObject|Connection */
    private $connectionMock;

    /** @var MockObject|AbstractPlatform */
    private $platformMock;

    /** @var ConsumptionPerCapitaService */
    private $service;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->connectionMock = $this->createMock(Connection::class);
        $this->platformMock = $this->createMock(AbstractPlatform::class);

        $this->entityManagerMock
            ->method('getConnection')
            ->willReturn($this->connectionMock);

        $this->connectionMock
            ->method('getDatabasePlatform')
            ->willReturn($this->platformMock);

        $this->platformMock
            ->method('getTruncateTableSQL')
            ->willReturn('TRUNCATE TABLE consumption_per_capita');

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

        // Mock the repositories
        $populationRepoMock = $this->createMock(EntityRepository::class);
        $populationRepoMock->method('findAll')->willReturn([$population1, $population2]);

        $consumptionRepoMock = $this->createMock(EntityRepository::class);
        $consumptionRepoMock->method('findAll')->willReturn([$averageConsumption]);

        // Set up the entity manager to return the mock repositories
        $this->entityManagerMock
            ->method('getRepository')
            ->willReturnMap([
                [PopulationPerElomrade::class, $populationRepoMock],
                [AverageConsumption::class, $consumptionRepoMock],
            ]);

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
}
