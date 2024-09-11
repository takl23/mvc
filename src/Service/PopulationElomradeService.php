<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerLan;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerElomrade;
use InvalidArgumentException;

class PopulationElomradeService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateAndSavePopulationPerElomrade(): void
    {
        // Rensa tabellen innan ny data importeras
        $this->truncateTable('population_per_elomrade');

        $populationsPerLan = $this->entityManager->getRepository(PopulationPerLan::class)->findAll();
        $lanElomrade = $this->entityManager->getRepository(LanElomrade::class)->findAll();

        if (empty($populationsPerLan) || empty($lanElomrade)) {
            // Avsluta tidigt om det inte finns något att bearbeta
            return;
        }

        // Skapa en mapping mellan län och elområde
        $lanToElomrade = $this->createLanToElomradeMap($lanElomrade);

        // Beräkna populationen per elområde för varje år
        $populationPerElomrade = $this->calculatePopulationPerElomrade($populationsPerLan, $lanToElomrade);

        // Spara populationen per elområde till databasen
        $this->savePopulationPerElomrade($populationPerElomrade);

        $this->entityManager->flush();
    }

    private function truncateTable(string $tableName): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
    }

    /**
 * @param LanElomrade[] $lanElomrade
 * @return array<string, string>
 */
    private function createLanToElomradeMap(array $lanElomrade): array
    {
        $lanToElomrade = [];
        foreach ($lanElomrade as $entry) {
            $lanToElomrade[$entry->getLan()] = $entry->getElomrade() ?? '';
        }
        return $lanToElomrade;
    }

    /**
 * @param PopulationPerLan[] $populationsPerLan
 * @param array<string, string> $lanToElomrade
 * @return array<int, array<string, int>>
 */
    private function calculatePopulationPerElomrade(array $populationsPerLan, array $lanToElomrade): array
    {
        $populationPerElomrade = [];

        foreach ($populationsPerLan as $population) {
            $year = $this->ensureInt($population->getYear());

            foreach ($lanToElomrade as $lan => $elomrade) {
                $lanProperty = $this->convertLanToProperty($lan);

                try {
                    $populationValue = $population->{'get' . ucfirst($lanProperty)}();

                    if (!isset($populationPerElomrade[$year][$elomrade])) {
                        $populationPerElomrade[$year][$elomrade] = 0;
                    }
                    $populationPerElomrade[$year][$elomrade] += $populationValue;
                } catch (\Exception $e) {
                    // Property doesn't exist on the entity
                }
            }
        }

        return $populationPerElomrade;
    }

    /**
 * @param array<int, array<string, int>> $populationPerElomrade
 */
    private function savePopulationPerElomrade(array $populationPerElomrade): void
    {
        foreach ($populationPerElomrade as $year => $elomradeData) {
            foreach ($elomradeData as $elomrade => $totalPopulation) {
                $entity = new PopulationPerElomrade();
                $entity->setYear($year);
                $entity->setElomrade($this->ensureString($elomrade));
                $entity->setPopulation($totalPopulation);
                $this->entityManager->persist($entity);
            }
        }
    }

    public function convertLanToProperty(string $lan): string
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

    public function ensureString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (string)$value;
        }

        if ($value === null) {
            throw new InvalidArgumentException("Value is null, expected a valid string: " . print_r($value, true));
        }

        throw new InvalidArgumentException("Value is not a valid string: " . print_r($value, true));
    }

    public function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int)$value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }
}
