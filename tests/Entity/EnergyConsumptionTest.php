<?php

namespace App\Tests\Entity;

use App\Entity\EnergyConsumption;
use PHPUnit\Framework\TestCase;

class EnergyConsumptionTest extends TestCase
{
    public function testGetAndSetId(): void
    {
        $entity = new EnergyConsumption();
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, 1);

        $this->assertEquals(1, $entity->getId());
    }

    public function testGetAndSetYear(): void
    {
        $entity = new EnergyConsumption();
        $entity->setYear(2021);

        $this->assertEquals(2021, $entity->getYear());
    }

    public function testGetAndSetSe1(): void
    {
        $entity = new EnergyConsumption();
        $entity->setSe1(5000);

        $this->assertEquals(5000, $entity->getSe1());
    }

    public function testGetAndSetSe2(): void
    {
        $entity = new EnergyConsumption();
        $entity->setSe2(6000);

        $this->assertEquals(6000, $entity->getSe2());
    }

    public function testGetAndSetSe3(): void
    {
        $entity = new EnergyConsumption();
        $entity->setSe3(7000);

        $this->assertEquals(7000, $entity->getSe3());
    }

    public function testGetAndSetSe4(): void
    {
        $entity = new EnergyConsumption();
        $entity->setSe4(8000);

        $this->assertEquals(8000, $entity->getSe4());
    }
}
