<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Exception;

class SpreadsheetLoader
{
    private Xlsx $reader;

    public function __construct(Xlsx $reader)
    {
        $this->reader = $reader;
    }

    public function load(string $filePath, string $sheetName): Worksheet
    {
        $spreadsheet = $this->reader->load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheetName);

        if (!$worksheet) {
            throw new Exception("Sheet $sheetName not found in the file $filePath");
        }

        return $worksheet;
    }
}
