<?php

namespace App\Tests\Entity;

use App\Entity\PopulationPerElomrade;
use PHPUnit\Framework\TestCase;

class PopulationPerElomradeTest extends TestCase
{
    public function testGetAndSetId(): void
    {
        $entity = new PopulationPerElomrade();
        $this->assertNull($entity->getId()); // Ny entitet bör inte ha ett ID

        // Eftersom ID vanligtvis sätts av databasen och inte manuellt, behöver vi inte testa setId.
        // Men om du vill testa det i ett specifikt scenario, kan du sätta ID via reflection.
    }

    public function testGetAndSetYear(): void
    {
        $entity = new PopulationPerElomrade();
        $entity->setYear(2023);
        $this->assertEquals(2023, $entity->getYear());
    }

    public function testGetAndSetElomrade(): void
    {
        $entity = new PopulationPerElomrade();
        $entity->setElomrade('SE1');
        $this->assertEquals('SE1', $entity->getElomrade());
    }

    public function testGetAndSetPopulation(): void
    {
        $entity = new PopulationPerElomrade();
        $entity->setPopulation(100000);
        $this->assertEquals(100000, $entity->getPopulation());
    }
}
