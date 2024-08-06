<?php

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

    public function import(string $filePath, string $entityClass): void
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

            if ($entityClass === RenewableEnergyTWh::class) {
                $entity = new RenewableEnergyTWh();
                $entity->setYear((int)$data[0]);
                $entity->setBiofuels($data[1] !== null ? (int)$data[1] : null);
                $entity->setHydropower($data[2] !== null ? (int)$data[2] : null);
                $entity->setWindPower($data[3] !== null ? (int)$data[3] : null);
                $entity->setHeatPump($data[4] !== null ? (int)$data[4] : null);
                $entity->setSolarEnergy($data[5] !== null ? (int)$data[5] : null);
                $entity->setTotal($data[6] !== null ? (int)$data[6] : null);
                $entity->setStatTransferToNorway($data[7] !== null ? (int)$data[7] : null);
                $entity->setRenewebleEnergyInTargetCalculation($data[8] !== null ? (int)$data[8] : null);
                $entity->setTotalEnergyUse($data[9] !== null ? (int)$data[9] : null);
            } else {
                throw new \Exception("Unknown entity class: $entityClass");
            }

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }
}
