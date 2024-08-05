// src/ExcelImport/ImportService.php

namespace App\ExcelImport;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RenewableEnergyPercentage;

class ImportService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

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

            $energyPercentage = new RenewableEnergyPercentage();
            $energyPercentage->setYear((int)$data[0]);
            $energyPercentage->setPercentage((float)$data[1]);

            $this->entityManager->persist($energyPercentage);
        }

        $this->entityManager->flush();
    }
}
