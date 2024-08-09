<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RenewableEnergyTWh;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerLan;
use Exception;
use InvalidArgumentException;

class ImportService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath, string $sheetName, string $entityClass): void
    {
        $worksheet = $this->loadSpreadsheet($filePath, $sheetName);

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

    private function loadSpreadsheet(string $filePath, string $sheetName): \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheetName);
        if (!$worksheet) {
            throw new Exception("Sheet $sheetName not found in the file $filePath");
        }
        return $worksheet;
    }

    private function isHeaderRow(\PhpOffice\PhpSpreadsheet\Worksheet\Row $row): bool
    {
        return $row->getRowIndex() === 1;
    }

    /**
     * @return array<mixed>
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

    /**
     * @param array<mixed> $data
     */
    private function processRowData(array $data, string $entityClass): ?object
    {
        switch ($entityClass) {
            case RenewableEnergyTWh::class:
                return $this->createRenewableEnergyTWh($data);
            case RenewableEnergyPercentage::class:
                return $this->createRenewableEnergyPercentage($data);
            case ElectricityPrice::class:
                return $this->createElectricityPrice($data);
            case AverageConsumption::class:
                return $this->createAverageConsumption($data);
            case EnergySupplyGDP::class:
                return $this->createEnergySupplyGDP($data);
            case LanElomrade::class:
                return $this->createLanElomrade($data);
            case PopulationPerLan::class:
                return $this->createPopulationPerLan($data);
            default:
                throw new Exception("Unknown entity class: $entityClass");
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function createRenewableEnergyTWh(array $data): RenewableEnergyTWh
    {
        $entity = new RenewableEnergyTWh();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setBiofuels($this->ensureInt($data[1]));
        $entity->setHydropower($this->ensureInt($data[2]));
        $entity->setWindPower($this->ensureInt($data[3]));
        $entity->setHeatPump($this->ensureInt($data[4]));
        $entity->setSolarEnergy($this->ensureInt($data[5]));
        $entity->setTotal($this->ensureInt($data[6]));
        $entity->setStatTransferToNorway($this->ensureInt($data[7]));
        $entity->setRenewableEnergyInTargetCalculation($this->ensureInt($data[8]));
        $entity->setTotalEnergyUse($this->ensureInt($data[9]));
        return $entity;
    }

    /**
     * @param array<mixed> $data
     */
    private function createRenewableEnergyPercentage(array $data): RenewableEnergyPercentage
    {
        $entity = new RenewableEnergyPercentage();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setVIM($this->ensureInt($data[1]));
        $entity->setEl($this->ensureInt($data[2]));
        $entity->setTransport($this->ensureInt($data[3]));
        $entity->setTotal($this->ensureInt($data[4]));
        return $entity;
    }

    /**
     * @param array<mixed> $data
     */
    private function createElectricityPrice(array $data): ?ElectricityPrice
    {
        if ($this->isValidPriceData($data)) {
            $entity = new ElectricityPrice();
            $entity->setYear($this->ensureInt($data[0]));
            $entity->setSe1($this->ensureFloat($data[1]));
            $entity->setSe2($this->ensureFloat($data[2]));
            $entity->setSe3($this->ensureFloat($data[3]));
            $entity->setSe4($this->ensureFloat($data[4]));
            return $entity;
        } else {
            echo "Skipping row due to missing values in ElectricityPrice.\n";
            return null;
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function createAverageConsumption(array $data): ?AverageConsumption
    {
        if ($this->isValidConsumptionData($data)) {
            $entity = new AverageConsumption();
            $entity->setYear($this->ensureInt($data[0]));
            $entity->setSe1($this->ensureFloat($data[1]));
            $entity->setSe2($this->ensureFloat($data[2]));
            $entity->setSe3($this->ensureFloat($data[3]));
            $entity->setSe4($this->ensureFloat($data[4]));
            return $entity;
        } else {
            echo "Skipping row due to missing values in AverageConsumption.\n";
            return null;
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function createEnergySupplyGDP(array $data): EnergySupplyGDP
    {
        $entity = new EnergySupplyGDP();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setPrecentage($this->ensureFloat($data[1]));
        return $entity;
    }

    /**
     * @param array<mixed> $data
     */
    private function createLanElomrade(array $data): ?LanElomrade
    {
        if ($data[0] !== null && $data[1] !== null) {
            $entity = new LanElomrade();
            $entity->setLan($this->ensureString($data[0]));
            $entity->setElomrade($this->ensureString($data[1]));
            return $entity;
        } else {
            echo "Skipping row due to missing values in LanElomrade.\n";
            return null;
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function createPopulationPerLan(array $data): ?PopulationPerLan
    {
        if ($data[0] !== null) {
            $entity = new PopulationPerLan();
            $entity->setYear($this->ensureInt($data[0]));
            $entity->setStockholm($this->ensureInt(str_replace(' ', '', $this->ensureString($data[1]))));
            $entity->setUppsala($this->ensureInt(str_replace(' ', '', $this->ensureString($data[2]))));
            $entity->setSodermanland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[3]))));
            $entity->setOstergotland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[4]))));
            $entity->setJonkoping($this->ensureInt(str_replace(' ', '', $this->ensureString($data[5]))));
            $entity->setKronoberg($this->ensureInt(str_replace(' ', '', $this->ensureString($data[6]))));
            $entity->setKalmar($this->ensureInt(str_replace(' ', '', $this->ensureString($data[7]))));
            $entity->setGotland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[8]))));
            $entity->setBlekinge($this->ensureInt(str_replace(' ', '', $this->ensureString($data[9]))));
            $entity->setSkane($this->ensureInt(str_replace(' ', '', $this->ensureString($data[10]))));
            $entity->setHalland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[11]))));
            $entity->setVastraGotaland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[12]))));
            $entity->setVarmland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[13]))));
            $entity->setOrebro($this->ensureInt(str_replace(' ', '', $this->ensureString($data[14]))));
            $entity->setVastmanland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[15]))));
            $entity->setVasternorrland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[16]))));
            $entity->setJamtland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[17]))));
            $entity->setVasterbotten($this->ensureInt(str_replace(' ', '', $this->ensureString($data[18]))));
            $entity->setNorrbotten($this->ensureInt(str_replace(' ', '', $this->ensureString($data[19]))));

            return $entity;
        } else {
            echo "Skipping row due to missing year in PopulationPerLan.\n";
            return null;
        }
    }

    private function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int) $value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }

    private function ensureFloat(mixed $value): float
    {
        if (isset($value) && is_numeric($value)) {
            return (float) str_replace(',', '.', (string) $value);
        }
        throw new InvalidArgumentException("Value is not a valid float: " . print_r($value, true));
    }

    private function ensureString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if ($value === null) {
            throw new InvalidArgumentException("Value is null, expected a valid string.");
        }

        throw new InvalidArgumentException("Value is not a valid string: " . print_r($value, true));
    }

    /**
     * @param array<mixed> $data
     */
    private function isValidPriceData(array $data): bool
    {
        return isset($data[1], $data[2], $data[3], $data[4]) &&
               is_numeric($data[1]) && is_numeric($data[2]) &&
               is_numeric($data[3]) && is_numeric($data[4]);
    }

    /**
     * @param array<mixed> $data
     */
    private function isValidConsumptionData(array $data): bool
    {
        return isset($data[1], $data[2], $data[3], $data[4]) &&
               is_numeric($data[1]) && is_numeric($data[2]) &&
               is_numeric($data[3]) && is_numeric($data[4]);
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
