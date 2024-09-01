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
    /** @var EntityManagerInterface|MockObject */
    private $entityManagerMock;

    /** @var MockObject|EntityRepository */
    private $populationRepoMock;

    /** @var MockObject|EntityRepository */
    private $consumptionRepoMock;

    /** @var ConsumptionPerCapitaService */
    private $service;

    protected function setUp(): void
    {
        /** @var EntityManagerInterface|MockObject $entityManagerMock */
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        /** @var EntityRepository|MockObject $populationRepoMock */
        $this->populationRepoMock = $this->createMock(EntityRepository::class);

        /** @var EntityRepository|MockObject $consumptionRepoMock */
        $this->consumptionRepoMock = $this->createMock(EntityRepository::class);

        // Mock the connection and platform
        $connectionMock = $this->createMock(Connection::class);
        $platformMock = $this->createMock(AbstractPlatform::class);

        // Set expectations for the methods
        $connectionMock->method('getDatabasePlatform')->willReturn($platformMock);
        $this->entityManagerMock->method('getConnection')->willReturn($connectionMock);

        $this->entityManagerMock->method('getRepository')->willReturnMap([
            [PopulationPerElomrade::class, $this->populationRepoMock],
            [AverageConsumption::class, $this->consumptionRepoMock],
        ]);

        $this->service = new ConsumptionPerCapitaService($this->entityManagerMock);
    }

    public function testCalculateAndSaveConsumptionPerCapita()
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
    // Simulera att inget data returneras av repository
    $this->populationRepoMock->method('findAll')->willReturn([]);
    $this->consumptionRepoMock->method('findAll')->willReturn([]);

    // Förvänta att en exception kastas
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Missing necessary data to calculate consumption per capita.');

    // Kör metoden
    $this->service->calculateAndSaveConsumptionPerCapita();
}


}
