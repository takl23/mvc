<?php
// src/Service/AverageAnnualCostPerPersonService.php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AverageAnnualCostPerPerson;
use App\Entity\ConsumptionPerCapita;
use App\Entity\ElectricityPrice;
use Psr\Log\LoggerInterface;

class AverageAnnualCostPerPersonService
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function calculateAndSaveAverageAnnualCostPerPerson(): void
    {
        $this->logger->info('Starting calculation and saving of average annual cost per person.');

        $this->truncateTable();

        $consumptionPerCapitaRepository = $this->entityManager->getRepository(ConsumptionPerCapita::class);
        $electricityPriceRepository = $this->entityManager->getRepository(ElectricityPrice::class);

        $consumptionData = $consumptionPerCapitaRepository->findAll();

        foreach ($consumptionData as $consumption) {
            $year = $consumption->getYear();
            $elomrade = $consumption->getElomrade();
            $consumptionPerCapita = $consumption->getConsumptionPerCapita();

            if ($year !== null && $elomrade !== null && $consumptionPerCapita !== null) {
                $electricityPrice = $electricityPriceRepository->findOneBy(['year' => $year]);

                if ($electricityPrice) {
                    $elomradeGetter = 'get' . ucfirst($elomrade);
                    $annualCostPerPerson = $consumptionPerCapita * $electricityPrice->$elomradeGetter();

                    $entity = new AverageAnnualCostPerPerson();
                    $entity->setYear($year);
                    $entity->setElomrade($elomrade);
                    $entity->setAverageCostPerPerson($annualCostPerPerson);
                    $this->entityManager->persist($entity);

                    $this->logger->info("Calculated and added: Year {$year}, Elomrade {$elomrade}, Cost {$annualCostPerPerson}");
                }
            }
        }

        $this->entityManager->flush();
        $this->logger->info('Finished calculation and saving of average annual cost per person.');
    }

    private function truncateTable(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('average_annual_cost_per_person', true));
        $this->logger->info('Truncated the average_annual_cost_per_person table.');
    }
}
