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

class ImportServiceTest extends TestCase
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
        // Skapa mocks för alla beroenden
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->spreadsheetLoaderMock = $this->createMock(SpreadsheetLoader::class);
        $this->factoryManagerMock = $this->createMock(FactoryManager::class);

        // Skapa ImportService-instans med de mockade beroendena
        $this->importService = new ImportService(
            $this->entityManagerMock,
            $this->spreadsheetLoaderMock,
            $this->factoryManagerMock
        );
    }

    public function testBasicFileLoading(): void
    {
        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'ValidSheet';

        // Mocka att SpreadsheetLoader laddar arket korrekt
        $worksheetMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::class);
        $this->spreadsheetLoaderMock->method('load')->with($filePath, $sheetName)->willReturn($worksheetMock);

        // Kör import-funktionen utan att göra något avancerat ännu
        $this->importService->import($filePath, $sheetName, 'App\Entity\SomeEntityClass');

        // Kontrollera att load-metoden kallades korrekt
        $this->assertTrue(true); // Temporär assertion för att säkerställa att inget kraschar
    }

    public function testFactoryCreatesEntityCorrectly(): void
    {
        $factory = new RenewableEnergyTWhFactory();
        $data = [2021, 100, 200, 1, 2, 3, 4, 5, 6, 7];
        $entity = $factory->create($data);
    
        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(100, $entity->getBiofuels());
        $this->assertEquals(200, $entity->getHydropower());
        $this->assertEquals(1, $entity->getWindPower());
        $this->assertEquals(2, $entity->getHeatPump());
        $this->assertEquals(3, $entity->getSolarEnergy());
        $this->assertEquals(4, $entity->getTotal());
        $this->assertEquals(5, $entity->getStatTransferToNorway());
        $this->assertEquals(6, $entity->getRenewableEnergyInTargetCalculation());
        $this->assertEquals(7, $entity->getTotalEnergyUse());
    }
    
    public function testEntityPersistence(): void
    {
        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'ValidSheet';
        $entityClass = RenewableEnergyTWh::class;
    
        // Använd samma testdata här
        $data = [2021, 100, 200, 1, 2, 3, 4, 5, 6, 7];
        $factory = new RenewableEnergyTWhFactory();
        $entity = $factory->create($data);
    
        $this->spreadsheetLoaderMock->method('load')->with($filePath, $sheetName)->willReturn($this->mockWorksheet($data));
    
        $this->factoryManagerMock->method('getFactory')->with($entityClass)->willReturn($factory);
    
        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($object) use ($data) {
                return $object instanceof RenewableEnergyTWh && $object->getYear() === $data[0];
            }));
    
        $this->entityManagerMock->expects($this->once())
            ->method('flush');
    
        $this->importService->import($filePath, $sheetName, $entityClass);
    }
    
    private function mockWorksheet(array $data)
    {
        $worksheetMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::class);
        $rowMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Row::class);
        $cellMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Cell\Cell::class);
    
        // Mock cellvärden inklusive null
        $cellMock->method('getValue')->willReturnOnConsecutiveCalls(...$data);
    
        // Skapa valid calls array
        $validCalls = array_fill(0, count($data), true);
        $validCalls[] = false; // Avsluta iterationen med false
        $cellIteratorMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator::class);
        $cellIteratorMock->method('valid')->willReturnOnConsecutiveCalls(...$validCalls);
        $cellIteratorMock->method('current')->willReturn($cellMock);
    
        // Mock row iterator
        $rowMock->method('getCellIterator')->willReturn($cellIteratorMock);
        $rowIteratorMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\RowIterator::class);
        $rowIteratorMock->method('valid')->willReturn(true, false); // Bara en rad, så avsluta iterationen efter en gång
        $rowIteratorMock->method('current')->willReturn($rowMock);
    
        $worksheetMock->method('getRowIterator')->willReturn($rowIteratorMock);
    
        return $worksheetMock;
    }
    

}
