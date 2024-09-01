<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use App\Service\SpreadsheetLoader;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Factory\FactoryManager;

class ImportServiceSpreadsheetTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManagerMock;

    /** @var SpreadsheetLoader&MockObject */
    private $spreadsheetLoaderMock;

    /** @var FactoryManager&MockObject */
    private $factoryManagerMock;  // <-- Added this line

    /** @var ImportService */
    private $importService;

    protected function setUp(): void
    {
        // Create the mock for EntityManagerInterface
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        // Create the mock for SpreadsheetLoader
        $this->spreadsheetLoaderMock = $this->createMock(SpreadsheetLoader::class);

        // Create the mock for FactoryManager with the correct namespace
        $this->factoryManagerMock = $this->createMock(\App\Factory\FactoryManager::class);

        // Instantiate the ImportService with the mocked dependencies
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

        $worksheetMock = $this->createMock(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::class);
        $this->spreadsheetLoaderMock->method('load')->with($filePath, $sheetName)->willReturn($worksheetMock);

        $this->importService->import($filePath, $sheetName, 'App\Entity\SomeEntityClass');

        $this->assertTrue(true); // Placeholder assertion, ensure the process runs without errors
    }
}
