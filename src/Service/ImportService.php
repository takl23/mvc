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
use InvalidArgumentException;
use Exception;

class ImportService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath, string $sheetName, string $entityClass): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheetName);

        if (!$worksheet) {
            throw new Exception("Sheet $sheetName not found in the file $filePath");
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

            try {
                switch ($entityClass) {
                    case RenewableEnergyTWh::class:
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
                        break;

                    case RenewableEnergyPercentage::class:
                        $entity = new RenewableEnergyPercentage();
                        $entity->setYear($this->ensureInt($data[0]));
                        $entity->setVIM($this->ensureInt($data[1]));
                        $entity->setEl($this->ensureInt($data[2]));
                        $entity->setTransport($this->ensureInt($data[3]));
                        $entity->setTotal($this->ensureInt($data[4]));
                        break;

                    case ElectricityPrice::class:
                        if ($this->isValidPriceData($data)) {
                            $entity = new ElectricityPrice();
                            $entity->setYear($this->ensureInt($data[0]));
                            $entity->setse1($this->ensureFloat($data[1]));
                            $entity->setse2($this->ensureFloat($data[2]));
                            $entity->setse3($this->ensureFloat($data[3]));
                            $entity->setse4($this->ensureFloat($data[4]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in ElectricityPrice.\n";
                            continue;
                        }
                        break;

                    case AverageConsumption::class:
                        if ($this->isValidConsumptionData($data)) {
                            $entity = new AverageConsumption();
                            $entity->setYear($this->ensureInt($data[0]));
                            $entity->setse1($this->ensureFloat($data[1]));
                            $entity->setse2($this->ensureFloat($data[2]));
                            $entity->setse3($this->ensureFloat($data[3]));
                            $entity->setse4($this->ensureFloat($data[4]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in AverageConsumption.\n";
                            continue;
                        }
                        break;

                    case EnergySupplyGDP::class:
                        $entity = new EnergySupplyGDP();
                        $entity->setYear($this->ensureInt($data[0]));
                        $entity->setPrecentage($this->ensureFloat($data[1]));
                        break;

                    case LanElomrade::class:
                        if ($data[0] !== null && $data[1] !== null) {
                            $entity = new LanElomrade();
                            $entity->setLan($this->ensureString($data[0]));
                            $entity->setElomrade($this->ensureString($data[1]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in LanElomrade.\n";
                            continue;
                        }
                        break;

                    case PopulationPerLan::class:
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
        $entity->setDalarnasLan($this->ensureInt(str_replace(' ', '', $this->ensureString($data[16]))));
        $entity->setGavleborg($this->ensureInt(str_replace(' ', '', $this->ensureString($data[17]))));
        $entity->setVasternorrland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[18]))));
        $entity->setJamtland($this->ensureInt(str_replace(' ', '', $this->ensureString($data[19]))));
        $entity->setVasterbotten($this->ensureInt(str_replace(' ', '', $this->ensureString($data[20]))));
        $entity->setNorrbotten($this->ensureInt(str_replace(' ', '', $this->ensureString($data[21]))));
    } else {
        echo "Skipping row {$row->getRowIndex()} due to missing year in PopulationPerLan.\n";
        continue;
    }
    break;


                    default:
                        throw new Exception("Unknown entity class: $entityClass");
                }

                if (isset($entity) && $this->isEntityValid($entity)) {
                    $this->entityManager->persist($entity);
                }
            } catch (\Exception $e) {
                echo "Error processing row {$row->getRowIndex()}: " . $e->getMessage() . "\n";
            }
        }

        $this->entityManager->flush();
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

    private function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int)$value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }

    private function ensureFloat(mixed $value): float
    {
        if (isset($value) && is_numeric($value)) {
            return (float)str_replace(',', '.', (string)$value);
        }
        throw new InvalidArgumentException("Value is not a valid float: " . print_r($value, true));
    }

    private function ensureString(mixed $value): string
{
    if (is_null($value)) {
        throw new InvalidArgumentException("Value is null, expected a string.");
    }

    if (is_array($value)) {
        throw new InvalidArgumentException("Value is an array, expected a string.");
    }

    if (is_object($value)) {
        throw new InvalidArgumentException("Value is an object, expected a string.");
    }

    if (!is_scalar($value)) {
        throw new InvalidArgumentException("Value is not a scalar, expected a string.");
    }

    return (string)$value;
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
}
