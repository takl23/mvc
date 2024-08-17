<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerElomrade;
use App\Entity\AverageConsumption;
use App\Entity\ConsumptionPerCapita;
use Exception;

class ConsumptionPerCapitaService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSaveConsumptionPerCapita(): void
    {
        // Indikerar att funktionen har startat
        //echo "Funktionen calculateAndSaveConsumptionPerCapita körs!\n";
        //error_log("Funktionen calculateAndSaveConsumptionPerCapita körs!");

        // Rensa tabellen innan ny data importeras
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('consumption_per_capita', true));

        // Hämta befolkningsdata per elområde
        $populationPerElomradeRepository = $this->entityManager->getRepository(PopulationPerElomrade::class);
        $averageConsumptionRepository = $this->entityManager->getRepository(AverageConsumption::class);

        $populationsPerElomrade = $populationPerElomradeRepository->findAll();
        //echo "Population data hämtad:\n";
        //var_dump($populationsPerElomrade);
        //error_log("Population data hämtad: " . json_encode($populationsPerElomrade));

        // Hämta genomsnittlig förbrukning
        $averageConsumptions = $averageConsumptionRepository->findAll();
        //echo "Genomsnittlig förbrukning hämtad:\n";
        //var_dump($averageConsumptions);
        //error_log("Genomsnittlig förbrukning hämtad: " . json_encode($averageConsumptions));

        if (empty($populationsPerElomrade) || empty($averageConsumptions)) {
            throw new Exception("Missing necessary data to calculate consumption per capita.");
        }

        // Skapa en mapping mellan år och elområde för population och förbrukning
        $populationMap = [];
        foreach ($populationsPerElomrade as $population) {
            $year = $population->getYear();
            $elomrade = $population->getElomrade();
            $populationMap[$year][$elomrade] = $population->getPopulation();
        }

        $consumptionPerCapita = [];
        foreach ($averageConsumptions as $consumption) {
            $year = $consumption->getYear();
            foreach (['SE1', 'SE2', 'SE3', 'SE4'] as $elomrade) {
                if (isset($populationMap[$year][$elomrade])) {
                    $population = $populationMap[$year][$elomrade];
                    $consumptionGWh = $consumption->{'get' . strtolower($elomrade)}();

                    $consumptionKWh = $consumptionGWh * 1_000_000; // Convert GWh to kWh
                    $consumptionPerCapitaValue = $consumptionKWh / $population;

                    $consumptionPerCapita[] = [
                        'year' => $year,
                        'elomrade' => $elomrade,
                        'consumptionPerCapita' => $consumptionPerCapitaValue,
                    ];
                } else {
                    // Skip calculation for this year and elomrade if data is missing
                    error_log("Skipping year $year and elomrade $elomrade due to missing population data.");
                }
            }
        }


        // Spara konsumtionen per capita till databasen
        foreach ($consumptionPerCapita as $data) {
            if (is_int($data['year'])) { // Typkontroll för att säkerställa att året är en int
                $entity = new ConsumptionPerCapita();
                $entity->setYear($data['year']);
                $entity->setElomrade($data['elomrade']);
                $entity->setConsumptionPerCapita($data['consumptionPerCapita']);
                $this->entityManager->persist($entity);

                //echo "Data sparad för år {$data['year']} och elområde {$data['elomrade']}.\n";
                //error_log("Data sparad för år {$data['year']} och elområde {$data['elomrade']}.");
            }
        }

        $this->entityManager->flush();

        // Kontroll för att se hur många poster som sparats
        $checkData = $this->entityManager->getRepository(ConsumptionPerCapita::class)->findAll();
        //echo "Antal poster sparade: " . count($checkData) . "\n";
        //error_log("Antal poster sparade: " . count($checkData));
    }
}
