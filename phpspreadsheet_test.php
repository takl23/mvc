<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Skapa ett nytt kalkylblad
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Testar!');

// Skriv till en temporär fil (XLSX-format)
$writer = new Xlsx($spreadsheet);
$fileName = 'phpspreadsheet_test.xlsx';
$writer->save($fileName);

// Output för att bekräfta att filen skapades
echo "Filen '$fileName' har skapats.";



?>
