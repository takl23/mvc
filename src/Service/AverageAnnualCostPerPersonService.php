<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AverageAnnualCostPerPerson;
use App\Entity\ConsumptionPerCapita;
use App\Entity\ElectricityPrice;

class AverageAnnualCostPerPersonService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSaveAverageAnnualCostPerPerson(): void
    {
        $consumptionPerCapitaRepository = $this->entityManager->getRepository(ConsumptionPerCapita::class);
        $electricityPriceRepository = $this->entityManager->getRepository(ElectricityPrice::class);

        $consumptionData = $consumptionPerCapitaRepository->findAll();
        $averageAnnualCostData = [];

        foreach ($consumptionData as $consumption) {
            $year = $consumption->getYear();
            $elomrade = $consumption->getElomrade();
            $consumptionPerCapita = $consumption->getConsumptionPerCapita();

            if ($year !== null && $elomrade !== null && $consumptionPerCapita !== null) {
                $electricityPrice = $electricityPriceRepository->findOneBy([
                    'year' => $year
                ]);

                if ($electricityPrice) {
                    $elomradeGetter = 'get' . ucfirst((string)$elomrade);
                    $annualCostPerPerson = $consumptionPerCapita * $electricityPrice->$elomradeGetter();
                    $averageAnnualCostData[] = [
                        'year' => $year,
                        'elomrade' => $elomrade,
                        'averageCostPerPerson' => $annualCostPerPerson
                    ];
                }
            }
        }

        foreach ($averageAnnualCostData as $data) {
            $entity = new AverageAnnualCostPerPerson();
            $entity->setYear($data['year']);
            $entity->setElomrade($data['elomrade']);
            $entity->setAverageCostPerPerson($data['averageCostPerPerson']);
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }
}
