<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerElomrade;
use App\Entity\AverageConsumption;
use App\Entity\ConsumptionPerCapita;

class ConsumptionPerCapitaService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSaveConsumptionPerCapita(): void
    {
        // Rensa tabellen innan ny data importeras
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('consumption_per_capita', true));

        $populationPerElomradeRepository = $this->entityManager->getRepository(PopulationPerElomrade::class);
        $averageConsumptionRepository = $this->entityManager->getRepository(AverageConsumption::class);

        $populationsPerElomrade = $populationPerElomradeRepository->findAll();
        $averageConsumptions = $averageConsumptionRepository->findAll();

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
            foreach (['se1', 'se2', 'se3', 'se4'] as $elomrade) {
                if (isset($populationMap[$year][$elomrade])) {
                    $population = $populationMap[$year][$elomrade];
                    $consumptionGWh = $consumption->{'get' . $elomrade}();
                    $consumptionKWh = $consumptionGWh * 1_000_000; // Omvandla GWh till kWh
                    $consumptionPerCapitaValue = $consumptionKWh / $population;

                    $consumptionPerCapita[] = [
                        'year' => $year,
                        'elomrade' => $elomrade,
                        'consumptionPerCapita' => $consumptionPerCapitaValue,
                    ];
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
            }
        }

        $this->entityManager->flush();
    }
}
