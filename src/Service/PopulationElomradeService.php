<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerLan;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerElomrade;

class PopulationElomradeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSavePopulationPerElomrade(): void
    {
        // Rensa tabellen innan ny data importeras
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('population_per_elomrade', true));

        $populationPerLanRepository = $this->entityManager->getRepository(PopulationPerLan::class);
        $lanElomradeRepository = $this->entityManager->getRepository(LanElomrade::class);

        $populationsPerLan = $populationPerLanRepository->findAll();
        $lanElomrade = $lanElomradeRepository->findAll();

        // Debugging: Visa antalet rader som hittades
        echo "Antal PopulationPerLan poster: " . count($populationsPerLan) . "\n";
        echo "Antal LanElomrade poster: " . count($lanElomrade) . "\n";

        // Skapa en mapping mellan län och elområde
        $lanToElomrade = [];
        foreach ($lanElomrade as $entry) {
            $lanToElomrade[$entry->getLan()] = $entry->getElomrade();
        }

        // Debugging: Visa mappingen
        print_r($lanToElomrade);

        // Beräkna populationen per elområde för varje år
        $populationPerElomrade = [];

        foreach ($populationsPerLan as $population) {
            $year = $population->getYear();
            echo "Bearbetar år: $year\n"; // Debugging
            foreach ($lanToElomrade as $lan => $elomrade) {
                $lanProperty = $this->convertLanToProperty($lan);

                if (property_exists($population, $lanProperty)) {
                    echo "Hittade property: $lanProperty för $lan\n"; // Debugging
                    if (!isset($populationPerElomrade[$year][$elomrade])) {
                        $populationPerElomrade[$year][$elomrade] = 0;
                    }
                    $populationValue = $population->{'get' . ucfirst($lanProperty)}();
                    echo "Adding $populationValue to $elomrade for year $year\n"; // Debugging
                    $populationPerElomrade[$year][$elomrade] += $populationValue;
                } else {
                    echo "Property $lanProperty finns inte på PopulationPerLan\n"; // Debugging
                }
            }
        }

        // Debug utskrift
        foreach ($populationPerElomrade as $year => $elomradeData) {
            foreach ($elomradeData as $elomrade => $totalPopulation) {
                echo "Year: $year, Elomrade: $elomrade, Population: $totalPopulation\n";
            }
        }

        // Spara populationen per elområde till databasen
        foreach ($populationPerElomrade as $year => $elomradeData) {
            foreach ($elomradeData as $elomrade => $totalPopulation) {
                $entity = new PopulationPerElomrade();
                $entity->setYear($year);
                $entity->setElomrade($elomrade);
                $entity->setPopulation($totalPopulation);
                $this->entityManager->persist($entity);
            }
        }

        $this->entityManager->flush();
    }

    private function convertLanToProperty(string $lan): string
    {
        $lanMappings = [
            'Norrbottens län' => 'norrbotten',
            'Västerbottens län' => 'vasterbotten',
            'Jämtlands län' => 'jamtland',
            'Västernorrlands län' => 'vasternorrland',
            'Gävleborgs län' => 'gavleborg',
            'Dalarnas län' => 'dalarnasLan',
            'Västmanlands län' => 'vastmanland',
            'Örebro län' => 'orebro',
            'Värmlands län' => 'varmland',
            'Uppsala län' => 'uppsala',
            'Stockholms län' => 'stockholm',
            'Södermanlands län' => 'sodermanland',
            'Östergötlands län' => 'ostergotland',
            'Jönköpings län' => 'jonkoping',
            'Kronobergs län' => 'kronoberg',
            'Kalmar län' => 'kalmar',
            'Gotlands län' => 'gotland',
            'Blekinge län' => 'blekinge',
            'Skåne län' => 'skane',
            'Hallands län' => 'halland',
            'Västra Götalands län' => 'vastraGotaland'
        ];

        return $lanMappings[$lan] ?? '';
    }
}
