<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Factory\FactoryManager;
use Exception;

class ImportService
{
    private EntityManagerInterface $entityManager;
    private FactoryManager $factoryManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        FactoryManager $factoryManager
    ) {
        $this->entityManager = $entityManager;
        $this->factoryManager = $factoryManager;
    }

    public function importAll(): void
    {
        // Lista över alla CSV-filer och vilken entitetsklass de tillhör
        $csvFiles = [
            ['path' => 'src/csv/renewable_energy_twh.csv', 'entityClass' => \App\Entity\RenewableEnergyTWh::class],
            ['path' => 'src/csv/renewable_energy_percentage.csv', 'entityClass' => \App\Entity\RenewableEnergyPercentage::class],
            ['path' => 'src/csv/electricity_price.csv', 'entityClass' => \App\Entity\ElectricityPrice::class],
            ['path' => 'src/csv/average_consumption.csv', 'entityClass' => \App\Entity\AverageConsumption::class],
            ['path' => 'src/csv/energy_supply_gdp.csv', 'entityClass' => \App\Entity\EnergySupplyGDP::class],
            ['path' => 'src/csv/population_per_lan.csv', 'entityClass' => \App\Entity\PopulationPerLan::class],
            ['path' => 'src/csv/lan_elomrade.csv', 'entityClass' => \App\Entity\LanElomrade::class],
        ];

        foreach ($csvFiles as $csvFile) {
            $this->import($csvFile['path'], $csvFile['entityClass']);
        }
    }

    public function import(string $filePath, string $entityClass): void
    {
        // Öppna CSV-filen
        if (($handle = fopen($filePath, 'r')) !== false) {
            $rowIndex = 0;

            // Skriv ut att filen bearbetas
            echo "Processing file: $filePath\n";

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // Hoppa över headern
                if ($rowIndex === 0) {
                    $rowIndex++;
                    continue;
                }

                // Lägg till felsökningsutskrift för att visa datan för varje rad
                echo "Processing row {$rowIndex}: " . json_encode($data) . "\n";

                try {
                    $factory = $this->factoryManager->getFactory($entityClass);
                    $entity = $factory->create($data);

                    // Om entiteten är ogiltig, logga datan
                    if ($entity === null || !$this->isEntityValid($entity)) {
                        echo "Invalid entity on row {$rowIndex}: " . json_encode($data) . "\n";
                    } else {
                        // Spara entiteten om den är giltig
                        $this->entityManager->persist($entity);
                    }
                } catch (Exception $e) {
                    // Fånga eventuella undantag och skriv ut felmeddelandet
                    echo "Error processing row {$rowIndex} in file {$filePath}: " . $e->getMessage() . "\n";
                }

                $rowIndex++;
            }

            // Stäng filen efter bearbetning
            fclose($handle);

            // Skicka alla entiteter till databasen
            $this->entityManager->flush();
            echo "Finished processing file: $filePath\n";
        } else {
            throw new Exception("Could not open file $filePath");
        }
    }

    public function isEntityValid(object $entity): bool
    {
        // Kontrollera entitetens giltighet beroende på dess typ
        if ($entity instanceof \App\Entity\RenewableEnergyTWh) {
            return $this->isRenewableEnergyTWhValid($entity);
        }

        if ($entity instanceof \App\Entity\RenewableEnergyPercentage) {
            return $this->isRenewableEnergyPercentageValid($entity);
        }

        if ($entity instanceof \App\Entity\ElectricityPrice) {
            return $this->isElectricityPriceValid($entity);
        }

        if ($entity instanceof \App\Entity\AverageConsumption) {
            return $this->isAverageConsumptionValid($entity);
        }

        if ($entity instanceof \App\Entity\EnergySupplyGDP) {
            return $this->isEnergySupplyGDPValid($entity);
        }

        if ($entity instanceof \App\Entity\PopulationPerLan) {
            return $this->isPopulationPerLanValid($entity);
        }

        if ($entity instanceof \App\Entity\LanElomrade) {
            return $this->isLanElomradeValid($entity);
        }

        return false;
    }

    public function isRenewableEnergyTWhValid(\App\Entity\RenewableEnergyTWh $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isRenewableEnergyPercentageValid(\App\Entity\RenewableEnergyPercentage $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isElectricityPriceValid(\App\Entity\ElectricityPrice $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isAverageConsumptionValid(\App\Entity\AverageConsumption $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isEnergySupplyGDPValid(\App\Entity\EnergySupplyGDP $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isPopulationPerLanValid(\App\Entity\PopulationPerLan $entity): bool
    {
        return $entity->getYear() !== null && $entity->getYear() > 0;
    }

    public function isLanElomradeValid(\App\Entity\LanElomrade $entity): bool
    {
        return $entity->getLan() !== null && $entity->getElomrade() !== null;
    }
}
