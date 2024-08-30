<?php

namespace App\Tests\Service;

use App\Service\AverageAnnualCostPerPersonService;
use App\Entity\AverageAnnualCostPerPerson;
use App\Entity\ConsumptionPerCapita;
use App\Entity\ElectricityPrice;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class AverageAnnualCostPerPersonServiceTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManagerMock;

    /** @var MockObject|EntityRepository */
    private $consumptionRepoMock;

    /** @var MockObject|EntityRepository */
    private $electricityPriceRepoMock;

    /** @var AverageAnnualCostPerPersonService */
    private $service;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->consumptionRepoMock = $this->createMock(EntityRepository::class);
        $this->electricityPriceRepoMock = $this->createMock(EntityRepository::class);

        $this->entityManagerMock->method('getRepository')->willReturnMap([
            [ConsumptionPerCapita::class, $this->consumptionRepoMock],
            [ElectricityPrice::class, $this->electricityPriceRepoMock],
        ]);

        $this->service = new AverageAnnualCostPerPersonService($this->entityManagerMock);
    }

    public function testCalculateAndSaveAverageAnnualCostPerPerson(): void
    {
        // Mock data for ConsumptionPerCapita
        $consumptionMock = $this->createMock(ConsumptionPerCapita::class);
        $consumptionMock->method('getYear')->willReturn(2022);
        $consumptionMock->method('getElomrade')->willReturn('se1');
        $consumptionMock->method('getConsumptionPerCapita')->willReturn(5000.0); // kWh

        // Mock data for ElectricityPrice
        $electricityPriceMock = $this->createMock(ElectricityPrice::class);
        $electricityPriceMock->method('getYear')->willReturn(2022);
        $electricityPriceMock->method('getSe1')->willReturn(1.2); // Price per kWh

        // Set up the repository mocks to return the mock data
        $this->consumptionRepoMock->method('findAll')->willReturn([$consumptionMock]);
        $this->electricityPriceRepoMock->method('findOneBy')->with(['year' => 2022])->willReturn($electricityPriceMock);

        // Expect the entity manager to persist the AverageAnnualCostPerPerson entity
        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function (AverageAnnualCostPerPerson $entity) {
                return $entity->getYear() === 2022 &&
                    $entity->getElomrade() === 'se1' &&
                    $entity->getAverageCostPerPerson() === 5000.0 * 1.2;
            }));

        // Expect the entity manager to flush the changes
        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        // Run the service method
        $this->service->calculateAndSaveAverageAnnualCostPerPerson();

        // Assertions and expectations are handled through the mock's `expects` method
    }
}
