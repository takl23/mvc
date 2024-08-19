<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Factory\FactoryManager;
use App\Entity\RenewableEnergyTWh;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerLan;
use Exception;

class ImportService
{
    private EntityManagerInterface $entityManager;
    private SpreadsheetLoader $spreadsheetLoader;
    private FactoryManager $factoryManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        SpreadsheetLoader $spreadsheetLoader,
        FactoryManager $factoryManager
    ) {
        $this->entityManager = $entityManager;
        $this->spreadsheetLoader = $spreadsheetLoader;
        $this->factoryManager = $factoryManager;
    }

    public function import(string $filePath, string $sheetName, string $entityClass): void
    {
        $worksheet = $this->spreadsheetLoader->load($filePath, $sheetName);

        foreach ($worksheet->getRowIterator() as $row) {
            if ($this->isHeaderRow($row)) {
                continue;
            }

            $data = $this->extractRowData($row);

            try {
                $factory = $this->factoryManager->getFactory($entityClass);
                $entity = $factory->create($data);

                if ($entity !== null && $this->isEntityValid($entity)) {
                    $this->entityManager->persist($entity);
                }
            } catch (Exception $e) {
                echo "Error processing row {$row->getRowIndex()}: " . $e->getMessage() . "\n";
            }
        }

        $this->entityManager->flush();
    }

    /**
 * Extracts row data from a spreadsheet row.
 *
 * @param \PhpOffice\PhpSpreadsheet\Worksheet\Row $row
 * @return array<int, mixed> The array containing values from the row cells.
 */
    private function extractRowData(\PhpOffice\PhpSpreadsheet\Worksheet\Row $row): array
    {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        $data = [];
        foreach ($cellIterator as $cell) {
            $data[] = $cell->getValue();
        }

        return $data;
    }

    private function isHeaderRow(\PhpOffice\PhpSpreadsheet\Worksheet\Row $row): bool
    {
        return $row->getRowIndex() === 1;
    }

    private function isEntityValid(object $entity): bool
    {
        if ($entity instanceof RenewableEnergyTWh) {
            return $this->isRenewableEnergyTWhValid($entity);
        }

        if ($entity instanceof RenewableEnergyPercentage) {
            return $this->isRenewableEnergyPercentageValid($entity);
        }

        if ($entity instanceof ElectricityPrice) {
            return $this->isElectricityPriceValid($entity);
        }

        if ($entity instanceof AverageConsumption) {
            return $this->isAverageConsumptionValid($entity);
        }

        if ($entity instanceof EnergySupplyGDP) {
            return $this->isEnergySupplyGDPValid($entity);
        }

        if ($entity instanceof PopulationPerLan) {
            return $this->isPopulationPerLanValid($entity);
        }

        if ($entity instanceof LanElomrade) {
            return $this->isLanElomradeValid($entity);
        }

        return false;
    }


    private function isRenewableEnergyTWhValid(RenewableEnergyTWh $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isRenewableEnergyPercentageValid(RenewableEnergyPercentage $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isElectricityPriceValid(ElectricityPrice $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isAverageConsumptionValid(AverageConsumption $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isEnergySupplyGDPValid(EnergySupplyGDP $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isPopulationPerLanValid(PopulationPerLan $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    private function isLanElomradeValid(LanElomrade $entity): bool
    {
        return $entity->getLan() !== null && $entity->getElomrade() !== null;
    }

}
