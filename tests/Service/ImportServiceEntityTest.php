<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use App\Service\SpreadsheetLoader;
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

    /** @var SpreadsheetLoader&MockObject */
    private $spreadsheetLoaderMock;

    /** @var FactoryManager&MockObject */
    private $factoryManagerMock;

    /** @var ImportService */
    private $importService;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->spreadsheetLoaderMock = $this->createMock(SpreadsheetLoader::class);
        $this->factoryManagerMock = $this->createMock(FactoryManager::class);

        $this->importService = new ImportService(
            $this->entityManagerMock,
            $this->spreadsheetLoaderMock,
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
        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'ValidSheet';
        $entityClass = RenewableEnergyTWh::class;

        $data = [2021, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $factory = new RenewableEnergyTWhFactory();

        $this->spreadsheetLoaderMock->method('load')->with($filePath, $sheetName)->willReturn($this->mockWorksheet($data));

        $this->factoryManagerMock->method('getFactory')->with($entityClass)->willReturn($factory);

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(RenewableEnergyTWh::class));

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->importService->import($filePath, $sheetName, $entityClass);
    }

    private function mockWorksheet(array $data)
    {
        $worksheetMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::class);
        $rowMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Row::class);
        $cellMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Cell\Cell::class);

        $cellMock->method('getValue')->willReturnOnConsecutiveCalls(...$data);

        $validCalls = array_fill(0, count($data), true);
        $validCalls[] = false;
        $cellIteratorMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator::class);
        $cellIteratorMock->method('valid')->willReturnOnConsecutiveCalls(...$validCalls);
        $cellIteratorMock->method('current')->willReturn($cellMock);

        $rowMock->method('getCellIterator')->willReturn($cellIteratorMock);
        $rowIteratorMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\RowIterator::class);
        $rowIteratorMock->method('valid')->willReturn(true, false);
        $rowIteratorMock->method('current')->willReturn($rowMock);

        $worksheetMock->method('getRowIterator')->willReturn($rowIteratorMock);

        return $worksheetMock;
    }

    public function testFactoryHandlesNullValuesCorrectly(): void
    {
        $factory = new RenewableEnergyTWhFactory();
        $data = [2021, 1, null, null, 2, null, 3, null, 4, null];
        $entity = $factory->create($data);

        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(1, $entity->getBiofuels());
        $this->assertNull($entity->getHydropower());
        $this->assertNull($entity->getWindPower());
        $this->assertEquals(2, $entity->getHeatPump());
        $this->assertNull($entity->getSolarEnergy());
        $this->assertEquals(3, $entity->getTotal());
        $this->assertNull($entity->getStatTransferToNorway());
        $this->assertEquals(4, $entity->getRenewableEnergyInTargetCalculation());
        $this->assertNull($entity->getTotalEnergyUse());
    }

    public function testEntityPersistenceWithNullValues(): void
    {
        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'ValidSheet';
        $entityClass = RenewableEnergyTWh::class;

        $data = [2021, 1, null, null, 2, null, 3, null, 4, null];
        $factory = new RenewableEnergyTWhFactory();

        $this->spreadsheetLoaderMock->method('load')->with($filePath, $sheetName)->willReturn($this->mockWorksheet($data));

        $this->factoryManagerMock->method('getFactory')->with($entityClass)->willReturn($factory);

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(RenewableEnergyTWh::class));

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->importService->import($filePath, $sheetName, $entityClass);
    }
}
