<?php

namespace App\ExcelImport;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\AverageCost;

class AverageCostService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAverageCost(): void
    {
        $electricityPriceRepo = $this->entityManager->getRepository(ElectricityPrice::class);
        $averageConsumptionRepo = $this->entityManager->getRepository(AverageConsumption::class);
        $averageCostRepo = $this->entityManager->getRepository(AverageCost::class);

        $electricityPrices = $electricityPriceRepo->findAll();
        $averageConsumptions = $averageConsumptionRepo->findAll();

        foreach ($electricityPrices as $price) {
            foreach ($averageConsumptions as $consumption) {
                if ($price->getYear() === $consumption->getYear()) {
                    $cost = new AverageCost();
                    $cost->setYear($price->getYear());
                    $cost->setCostSE1($price->getSE1() * ($consumption->getSE1() * 1000000)); // SEK
                    $cost->setCostSE2($price->getSE2() * ($consumption->getSE2() * 1000000)); // SEK
                    $cost->setCostSE3($price->getSE3() * ($consumption->getSE3() * 1000000)); // SEK
                    $cost->setCostSE4($price->getSE4() * ($consumption->getSE4() * 1000000)); // SEK

                    $this->entityManager->persist($cost);
                }
            }
        }

        $this->entityManager->flush();
    }
}
