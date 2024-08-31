<?php

namespace App\Tests\Service;

use App\Service\SpreadsheetLoader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Exception;

class SpreadsheetLoaderTest extends TestCase
{
    /** @var MockObject */
    private $readerMock;

    /** @var SpreadsheetLoader */
    private $spreadsheetLoader;

    protected function setUp(): void
    {
        // Här tar vi bort typdeklarationen men använder en kommentar för att specificera typen.
        /** @var MockObject|Xlsx $readerMock */
        $this->readerMock = $this->createMock(Xlsx::class);
        
        // Nu använder vi den mockade versionen av Xlsx
        $this->spreadsheetLoader = new SpreadsheetLoader($this->readerMock);
    }

    public function testLoadValidSheet(): void
    {
        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'ValidSheet';

        // Mocking Spreadsheet and Worksheet
        $spreadsheetMock = $this->createMock(Spreadsheet::class);
        $worksheetMock = $this->createMock(Worksheet::class);

        // Mocking the load method to return the mock Spreadsheet
        $this->readerMock->method('load')
            ->with($filePath)
            ->willReturn($spreadsheetMock);

        // Mocking the getSheetByName method to return the mock Worksheet
        $spreadsheetMock->method('getSheetByName')
            ->with($sheetName)
            ->willReturn($worksheetMock);

        // Run the load method
        $result = $this->spreadsheetLoader->load($filePath, $sheetName);

        // Assert that the returned worksheet is the expected mock
        $this->assertSame($worksheetMock, $result);
    }

    public function testLoadInvalidSheet(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Sheet InvalidSheet not found in the file dummy/path/to/spreadsheet.xlsx");


        $filePath = 'dummy/path/to/spreadsheet.xlsx';
        $sheetName = 'InvalidSheet';

        // Mocking Spreadsheet
        $spreadsheetMock = $this->createMock(Spreadsheet::class);

        // Mocking the load method to return the mock Spreadsheet
        $this->readerMock->method('load')
            ->with($filePath)
            ->willReturn($spreadsheetMock);

        // Mocking the getSheetByName method to return null (indicating the sheet is not found)
        $spreadsheetMock->method('getSheetByName')
            ->with($sheetName)
            ->willReturn(null);

        // Run the load method, which should throw an Exception
        $this->spreadsheetLoader->load($filePath, $sheetName);
    }
}
