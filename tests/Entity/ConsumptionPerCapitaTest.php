<?php
namespace App\Tests\Entity;

use App\Entity\ConsumptionPerCapita;
use PHPUnit\Framework\TestCase;

class ConsumptionPerCapitaTest extends TestCase
{
    public function testGetAndSetId(): void
    {
        $entity = new ConsumptionPerCapita();
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, 123);

        $this->assertEquals(123, $entity->getId());
    }

    public function testGetAndSetYear(): void
    {
        $entity = new ConsumptionPerCapita();
        $entity->setYear(2021);

        $this->assertEquals(2021, $entity->getYear());
    }

    public function testGetAndSetElomrade(): void
    {
        $entity = new ConsumptionPerCapita();
        $entity->setElomrade('SE3');

        $this->assertEquals('SE3', $entity->getElomrade());
    }

    public function testGetAndSetConsumptionPerCapita(): void
    {
        $entity = new ConsumptionPerCapita();
        $entity->setConsumptionPerCapita(2500.5);

        $this->assertEquals(2500.5, $entity->getConsumptionPerCapita());
    }
}
