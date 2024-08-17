<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Factory\RenewableEnergyTWhFactory;
use App\Factory\RenewableEnergyPercentageFactory;
use App\Factory\ElectricityPriceFactory;
use App\Factory\AverageConsumptionFactory;
use App\Factory\EnergySupplyGDPFactory;
use App\Factory\LanElomradeFactory;
use App\Factory\PopulationPerLanFactory;

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
    private RenewableEnergyTWhFactory $renewableEnergyTWhFactory;
    private RenewableEnergyPercentageFactory $renewableEnergyPercentageFactory;
    private ElectricityPriceFactory $electricityPriceFactory;
    private AverageConsumptionFactory $averageConsumptionFactory;
    private EnergySupplyGDPFactory $energySupplyGDPFactory;
    private LanElomradeFactory $lanElomradeFactory;
    private PopulationPerLanFactory $populationPerLanFactory;

    public function __construct(
        EntityManagerInterface $entityManager, 
        SpreadsheetLoader $spreadsheetLoader,
        RenewableEnergyTWhFactory $renewableEnergyTWhFactory,
        RenewableEnergyPercentageFactory $renewableEnergyPercentageFactory,
        ElectricityPriceFactory $electricityPriceFactory,
        AverageConsumptionFactory $averageConsumptionFactory,
        EnergySupplyGDPFactory $energySupplyGDPFactory,
        LanElomradeFactory $lanElomradeFactory,
        PopulationPerLanFactory $populationPerLanFactory
    ) {
        $this->entityManager = $entityManager;
        $this->spreadsheetLoader = $spreadsheetLoader;
        $this->renewableEnergyTWhFactory = $renewableEnergyTWhFactory;
        $this->renewableEnergyPercentageFactory = $renewableEnergyPercentageFactory;
        $this->electricityPriceFactory = $electricityPriceFactory;
        $this->averageConsumptionFactory = $averageConsumptionFactory;
        $this->energySupplyGDPFactory = $energySupplyGDPFactory;
        $this->lanElomradeFactory = $lanElomradeFactory;
        $this->populationPerLanFactory = $populationPerLanFactory;
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
                $entity = $this->processRowData($data, $entityClass);

                if ($entity !== null && $this->isEntityValid($entity)) {
                    $this->entityManager->persist($entity);
                }
            } catch (Exception $e) {
                echo "Error processing row {$row->getRowIndex()}: " . $e->getMessage() . "\n";
            }
        }

        $this->entityManager->flush();
    }

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

    private function processRowData(array $data, string $entityClass): ?object
    {
        switch ($entityClass) {
            case RenewableEnergyTWh::class:
                return $this->renewableEnergyTWhFactory->create($data);
            case RenewableEnergyPercentage::class:
                return $this->renewableEnergyPercentageFactory->create($data);
            case ElectricityPrice::class:
                return $this->electricityPriceFactory->create($data);
            case AverageConsumption::class:
                return $this->averageConsumptionFactory->create($data);
            case EnergySupplyGDP::class:
                return $this->energySupplyGDPFactory->create($data);
            case LanElomrade::class:
                return $this->lanElomradeFactory->create($data);
            case PopulationPerLan::class:
                return $this->populationPerLanFactory->create($data);
            default:
                throw new Exception("Unknown entity class: $entityClass");
        }
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
