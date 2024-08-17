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
        if ($entity instanceof RenewableEnergyTWh ||
            $entity instanceof RenewableEnergyPercentage ||
            $entity instanceof ElectricityPrice ||
            $entity instanceof AverageConsumption ||
            $entity instanceof EnergySupplyGDP ||
            $entity instanceof PopulationPerLan) {
            return $entity->getYear() !== null && $entity->getYear() > 0;
        } elseif ($entity instanceof LanElomrade) {
            return $entity->getLan() !== null && $entity->getElomrade() !== null;
        }

        return false;
    }
}
