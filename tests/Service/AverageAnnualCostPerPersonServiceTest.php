<?php

namespace App\Tests\Service;

use App\Service\AverageAnnualCostPerPersonService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\ConsumptionPerCapita;
use App\Entity\ElectricityPrice;
use App\Entity\AverageAnnualCostPerPerson;

class AverageAnnualCostPerPersonServiceTest extends TestCase
{
    private AverageAnnualCostPerPersonService $service;
    private $entityManager;
    private $consumptionPerCapitaRepository;
    private $electricityPriceRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // Mock the EntityRepository instead of ObjectRepository
        $this->consumptionPerCapitaRepository = $this->createMock(EntityRepository::class);
        $this->electricityPriceRepository = $this->createMock(EntityRepository::class);

        // Use willReturnMap to return the correct repository for each entity
        $this->entityManager->method('getRepository')
            ->willReturnMap([
                [ConsumptionPerCapita::class, $this->consumptionPerCapitaRepository],
                [ElectricityPrice::class, $this->electricityPriceRepository],
            ]);

        $this->service = new AverageAnnualCostPerPersonService($this->entityManager);
    }

    public function testCalculateAndSaveAverageAnnualCostPerPerson(): void
    {
        $consumptionMock = $this->createMock(ConsumptionPerCapita::class);
        $consumptionMock->method('getYear')->willReturn(2021);
        $consumptionMock->method('getElomrade')->willReturn('SE1');
        $consumptionMock->method('getConsumptionPerCapita')->willReturn(1000.0);

        $priceMock = $this->createMock(ElectricityPrice::class);
        $priceMock->method('getSe1')->willReturn(0.5);

        $this->consumptionPerCapitaRepository->method('findAll')
            ->willReturn([$consumptionMock]);

        $this->electricityPriceRepository->method('findOneBy')
            ->with(['year' => 2021])
            ->willReturn($priceMock);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function (AverageAnnualCostPerPerson $entity) {
                return $entity->getYear() === 2021 &&
                       $entity->getElomrade() === 'SE1' &&
                       $entity->getAverageCostPerPerson() === 500.0;
            }));

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->service->calculateAndSaveAverageAnnualCostPerPerson();
    }
}
