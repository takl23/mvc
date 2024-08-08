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

            try {
                switch ($entityClass) {
                    case RenewableEnergyTWh::class:
                        $entity = new RenewableEnergyTWh();
                        $entity->setYear((int)$data[0]);
                        $entity->setBiofuels(isset($data[1]) ? (int)$data[1] : null);
                        $entity->setHydropower(isset($data[2]) ? (int)$data[2] : null);
                        $entity->setWindPower(isset($data[3]) ? (int)$data[3] : null);
                        $entity->setHeatPump(isset($data[4]) ? (int)$data[4] : null);
                        $entity->setSolarEnergy(isset($data[5]) ? (int)$data[5] : null);
                        $entity->setTotal(isset($data[6]) ? (int)$data[6] : null);
                        $entity->setStatTransferToNorway(isset($data[7]) ? (int)$data[7] : null);
                        $entity->setRenewableEnergyInTargetCalculation(isset($data[8]) ? (int)$data[8] : null);
                        $entity->setTotalEnergyUse(isset($data[9]) ? (int)$data[9] : null);
                        break;

                    case RenewableEnergyPercentage::class:
                        $entity = new RenewableEnergyPercentage();
                        $entity->setYear((int)$data[0]);
                        $entity->setVIM(isset($data[1]) ? (int)$data[1] : null);
                        $entity->setEl(isset($data[2]) ? (int)$data[2] : null);
                        $entity->setTransport(isset($data[3]) ? (int)$data[3] : null);
                        $entity->setTotal(isset($data[4]) ? (int)$data[4] : null);
                        break;

                    case ElectricityPrice::class:
                        if ($data[1] !== null && $data[2] !== null && $data[3] !== null && $data[4] !== null) {
                            $entity = new ElectricityPrice();
                            $entity->setYear((int)$data[0]);
                            $entity->setSE1((float)str_replace(',', '.', $data[1]));
                            $entity->setSE2((float)str_replace(',', '.', $data[2]));
                            $entity->setSE3((float)str_replace(',', '.', $data[3]));
                            $entity->setSE4((float)str_replace(',', '.', $data[4]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in ElectricityPrice.\n";
                            continue;
                        }
                        break;

                    case AverageConsumption::class:
                        if ($data[1] !== null && $data[2] !== null && $data[3] !== null && $data[4] !== null) {
                            $entity = new AverageConsumption();
                            $entity->setYear((int)$data[0]);
                            $entity->setSE1((float)str_replace(',', '.', $data[1]));
                            $entity->setSE2((float)str_replace(',', '.', $data[2]));
                            $entity->setSE3((float)str_replace(',', '.', $data[3]));
                            $entity->setSE4((float)str_replace(',', '.', $data[4]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in AverageConsumption.\n";
                            continue;
                        }
                        break;

                    case EnergySupplyGDP::class:
                        $entity = new EnergySupplyGDP();
                        $entity->setYear((int)$data[0]);
                        $entity->setPrecentage(isset($data[1]) && is_numeric($data[1]) ? (float)str_replace(',', '.', $data[1]) : null);
                        break;

                    case LanElomrade::class:
                        if ($data[0] !== null && $data[1] !== null) {
                            $entity = new LanElomrade();
                            $entity->setLan($data[0]);
                            $entity->setElomrade($data[1]);
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing values in LanElomrade.\n";
                            continue;
                        }
                        break;

                    case PopulationPerLan::class:
                        if ($data[0] !== null) {
                            $entity = new PopulationPerLan();
                            $entity->setYear((int)$data[0]);
                            $entity->setStockholm((int)str_replace(' ', '', $data[1]));
                            $entity->setUppsala((int)str_replace(' ', '', $data[2]));
                            $entity->setSodermanland((int)str_replace(' ', '', $data[3]));
                            $entity->setOstergotland((int)str_replace(' ', '', $data[4]));
                            $entity->setJonkoping((int)str_replace(' ', '', $data[5]));
                            $entity->setKronoberg((int)str_replace(' ', '', $data[6]));
                            $entity->setKalmar((int)str_replace(' ', '', $data[7]));
                            $entity->setGotland((int)str_replace(' ', '', $data[8]));
                            $entity->setBlekinge((int)str_replace(' ', '', $data[9]));
                            $entity->setSkane((int)str_replace(' ', '', $data[10]));
                            $entity->setHalland((int)str_replace(' ', '', $data[11]));
                            $entity->setVastraGotaland((int)str_replace(' ', '', $data[12]));
                            $entity->setVarmland((int)str_replace(' ', '', $data[13]));
                            $entity->setOrebro((int)str_replace(' ', '', $data[14]));
                            $entity->setVastmanland((int)str_replace(' ', '', $data[15]));
                            $entity->setDalarnasLan((int)str_replace(' ', '', $data[16]));
                            $entity->setGavleborg((int)str_replace(' ', '', $data[17]));
                            $entity->setVasternorrland((int)str_replace(' ', '', $data[18]));
                            $entity->setJamtland((int)str_replace(' ', '', $data[19]));
                            $entity->setVasterbotten((int)str_replace(' ', '', $data[20]));
                            $entity->setNorrbotten((int)str_replace(' ', '', $data[21]));
                        } else {
                            echo "Skipping row {$row->getRowIndex()} due to missing year in PopulationPerLan.\n";
                            continue;
                        }
                        break;

                    default:
                        throw new \Exception("Unknown entity class: $entityClass");
                }

                if ($this->isEntityValid($entity)) {
                    $this->entityManager->persist($entity);
                }
            } catch (\Exception $e) {
                echo "Error processing row {$row->getRowIndex()}: " . $e->getMessage() . "\n";
            }
        }

        $this->entityManager->flush();
    }

    private function isEntityValid($entity): bool
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
