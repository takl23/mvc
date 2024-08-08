<?php
// src/Service/ConsumptionPerCapitaService.php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerElomrade;
use App\Entity\AverageConsumption;
use App\Entity\ConsumptionPerCapita;

class ConsumptionPerCapitaService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSaveConsumptionPerCapita(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('consumption_per_capita', true));

        $populationRepo = $this->entityManager->getRepository(PopulationPerElomrade::class);
        $consumptionRepo = $this->entityManager->getRepository(AverageConsumption::class);

        $populations = $populationRepo->findAll();
        $consumptions = $consumptionRepo->findAll();

        $populationData = [];
        foreach ($populations as $population) {
            $populationData[$population->getYear()][$population->getElomrade()] = $population->getPopulation();
        }

        foreach ($consumptions as $consumption) {
            $year = $consumption->getYear();
            foreach (['SE1', 'SE2', 'SE3', 'SE4'] as $elomrade) {
                if (isset($populationData[$year][$elomrade])) {
                    $population = $populationData[$year][$elomrade];
                    $consumptionValue = $consumption->{'get' . $elomrade}();
                    $consumptionPerCapita = $population > 0 ? $consumptionValue / $population : 0;

                    $entity = new ConsumptionPerCapita();
                    $entity->setYear($year);
                    $entity->setElomrade($elomrade);
                    $entity->setConsumptionPerCapita($consumptionPerCapita);
                    $this->entityManager->persist($entity);
                }
            }
        }

        $this->entityManager->flush();
    }
}
