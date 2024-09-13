<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use App\Factory\FactoryManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Factory\RenewableEnergyTWhFactory;
use App\Entity\RenewableEnergyTWh;

class ImportServiceEntityTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManagerMock;

    /** @var FactoryManager&MockObject */
    private $factoryManagerMock;

    /** @var ImportService */
    private $importService;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->factoryManagerMock = $this->createMock(FactoryManager::class);

        $this->importService = new ImportService(
            $this->entityManagerMock,
            $this->factoryManagerMock
        );
    }

    public function testFactoryCreatesEntityCorrectly(): void
    {
        $factory = new RenewableEnergyTWhFactory();
        $data = [2021, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $entity = $factory->create($data);

        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(1, $entity->getBiofuels());
        $this->assertEquals(2, $entity->getHydropower());
        $this->assertEquals(3, $entity->getWindPower());
        $this->assertEquals(4, $entity->getHeatPump());
        $this->assertEquals(5, $entity->getSolarEnergy());
        $this->assertEquals(6, $entity->getTotal());
        $this->assertEquals(7, $entity->getStatTransferToNorway());
        $this->assertEquals(8, $entity->getRenewableEnergyInTargetCalculation());
        $this->assertEquals(9, $entity->getTotalEnergyUse());
    }

    public function testEntityPersistence(): void
{
    $filePath = 'src/csv/renewable_energy_twh.csv';
    $entityClass = RenewableEnergyTWh::class;

    // Mock CSV-data för 17 rader
    $csvData = [
        [2021, 134, 67, 29, 19, 2, 250, 0, 250, 409],
        [2020, 131, 67, 25, 18, 1, 241, 3, 238, 396],
        [2019, 126, 67, 21, 18, 1, 232, 6, 226, 406],
        [2018, 124, 66, 18, 17, 1, 226, 5, 221, 410],
        [2017, 126, 66, 17, 16, 0, 226, 5, 220, 412],
        [2016, 123, 66, 16, 16, 0, 221, 5, 216, 410],
        [2015, 118, 67, 14, 14, 0, 213, 4, 209, 401],
        [2014, 113, 65, 11, 14, 0, 204, 3, 201, 394],
        [2013, 114, 68, 9, 14, 0, 205, 2, 203, 406],
        [2012, 115, 69, 7, 14, 0, 205, 0, 205, 414],
        [2011, 108, 69, 5, 14, 0, 196, 0, 196, 411],
        [2010, 114, 68, 3, 11, 0, 197, 0, 197, 427],
        [2009, 104, 68, 3, 11, 0, 186, 0, 186, 395],
        [2008, 101, 67, 2, 10, 0, 180, 0, 180, 409],
        [2007, 100, 69, 1, 9, 0, 179, 0, 179, 415],
        [2006, 95, 68, 1, 8, 0, 172, 0, 172, 411],
        [2005, 89, 68, 1, 7, 0, 165, 0, 165, 413],
    ];

    $factory = new RenewableEnergyTWhFactory();
    $this->factoryManagerMock->method('getFactory')->with($entityClass)->willReturn($factory);

    // Förvänta exakt 17 anrop till persist, ett för varje rad
    $this->entityManagerMock->expects($this->exactly(17))
        ->method('persist')
        ->with($this->isInstanceOf(RenewableEnergyTWh::class));

    // Förvänta exakt ett anrop till flush
    $this->entityManagerMock->expects($this->once())
        ->method('flush')
        ->willReturnCallback(function() {
        });

    // Simulera import av CSV-data utan att anropa flush manuellt i testet
    $this->importService->import($filePath, $entityClass);
}


}
