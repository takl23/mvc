<?php

namespace App\Tests\Factory;

use App\Factory\RenewableEnergyTWhFactory;
use App\Entity\RenewableEnergyTWh;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class RenewableEnergyTWhFactoryTest extends TestCase
{
    private RenewableEnergyTWhFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new RenewableEnergyTWhFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [2021, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(1, $entity->getBiofuels());
        $this->assertEquals(2, $entity->getHydropower());
        $this->assertEquals(3, $entity->getWindPower());
        $this->assertEquals(4, $entity->getHeatPump());
        $this->assertEquals(5, $entity->getSolarEnergy());
        $this->assertEquals(6, $entity->getTotal());
        $this->assertEquals(7, $entity->getStatTransferToNorway());
        $this->assertEquals(8, $entity->getRenewableEnergyInTargetCalculation());
        $this->assertEquals(9, $entity->getTotalEnergyUse());
    }

    public function testCreateWithNullValues(): void
    {
        $data = [2021, null, null, null, null, null, null, null, null, null];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertNull($entity->getBiofuels());
        $this->assertNull($entity->getHydropower());
        $this->assertNull($entity->getWindPower());
        $this->assertNull($entity->getHeatPump());
        $this->assertNull($entity->getSolarEnergy());
        $this->assertNull($entity->getTotal());
        $this->assertNull($entity->getStatTransferToNorway());
        $this->assertNull($entity->getRenewableEnergyInTargetCalculation());
        $this->assertNull($entity->getTotalEnergyUse());
    }

    public function testCreateWithEmptyStringValues(): void
    {
        $data = [2021, '', '', '', '', '', '', '', '', ''];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyTWh::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertNull($entity->getBiofuels());
        $this->assertNull($entity->getHydropower());
        $this->assertNull($entity->getWindPower());
        $this->assertNull($entity->getHeatPump());
        $this->assertNull($entity->getSolarEnergy());
        $this->assertNull($entity->getTotal());
        $this->assertNull($entity->getStatTransferToNorway());
        $this->assertNull($entity->getRenewableEnergyInTargetCalculation());
        $this->assertNull($entity->getTotalEnergyUse());
    }

    public function testCreateWithInvalidIntValueThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid nullable integer");

        $data = [2021, 'invalid', 2, 3, 4, 5, 6, 7, 8, 9];
        $this->factory->create($data);
    }

    public function testCreateWithMissingYearThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer");

        $data = [null, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $this->factory->create($data);
    }
}
