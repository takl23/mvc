<?php 
// src/ExcelImport/ImportService.php

namespace App\ExcelImport;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RenewableEnergyTWh;

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

            $energyTWh = new RenewableEnergyTWh();
            $energyTWh->setYear((int)$data[0]);
            $energyTWh->setBiofuels((int)$data[1]);
            $energyTWh->setHydropower((int)$data[2]);
            $energyTWh->setWindPower((int)$data[3]);
            $energyTWh->setHeatPump((int)$data[4]);
            $energyTWh->setSolarEnergy((int)$data[5]);
            $energyTWh->setTotal((int)$data[6]);
            $energyTWh->setStatTransferToNorway((int)$data[7]);
            $energyTWh->setRenewebleEnergyInTargetCalculation((int)$data[8]);
            $energyTWh->setTotalEnergyUse((int)$data[9]);

            $this->entityManager->persist($energyTWh);
        }

        $this->entityManager->flush();
    }
}
