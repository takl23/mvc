<?php
namespace App\ExcelImport;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AverageConsumption;
use App\Entity\ElectricityPrice;

class ImportService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath, string $sheetName, string $entityClass): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheetName);

        if (!$worksheet) {
            throw new \Exception("Sheet $sheetName not found in the file $filePath");
        }

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Skippa rubrikraden
            if ($row->getRowIndex() === 1) {
                continue;
            }

            if ($entityClass === AverageConsumption::class) {
                $entity = new AverageConsumption();
                $entity->setYear((int)$data[0]);
                $entity->setSE1((float)str_replace(',', '.', $data[1]));
                $entity->setSE2((float)str_replace(',', '.', $data[2]));
                $entity->setSE3((float)str_replace(',', '.', $data[3]));
                $entity->setSE4((float)str_replace(',', '.', $data[4]));
            } elseif ($entityClass === ElectricityPrice::class) {
                $entity = new ElectricityPrice();
                $entity->setYear((int)$data[0]);
                $entity->setSE1((float)str_replace(',', '.', $data[1]));
                $entity->setSE2((float)str_replace(',', '.', $data[2]));
                $entity->setSE3((float)str_replace(',', '.', $data[3]));
                $entity->setSE4((float)str_replace(',', '.', $data[4]));
            } else {
                throw new \Exception("Unknown entity class: $entityClass");
            }

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }
}
