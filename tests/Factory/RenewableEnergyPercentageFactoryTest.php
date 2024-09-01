<?php

namespace App\Tests\Factory;

use App\Factory\RenewableEnergyPercentageFactory;
use App\Entity\RenewableEnergyPercentage;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class RenewableEnergyPercentageFactoryTest extends TestCase
{
    private RenewableEnergyPercentageFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new RenewableEnergyPercentageFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [2021, 10, 20, 30, 40];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyPercentage::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(10, $entity->getVIM());
        $this->assertEquals(20, $entity->getEl());
        $this->assertEquals(30, $entity->getTransport());
        $this->assertEquals(40, $entity->getTotal());
    }

    public function testCreateWithNullValues(): void
    {
        $data = [2021, null, null, null, null];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyPercentage::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertNull($entity->getVIM());
        $this->assertNull($entity->getEl());
        $this->assertNull($entity->getTransport());
        $this->assertNull($entity->getTotal());
    }

    public function testCreateWithEmptyStringValues(): void
    {
        $data = [2021, '', '', '', ''];
        $entity = $this->factory->create($data);

        $this->assertInstanceOf(RenewableEnergyPercentage::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertNull($entity->getVIM());
        $this->assertNull($entity->getEl());
        $this->assertNull($entity->getTransport());
        $this->assertNull($entity->getTotal());
    }

    public function testCreateWithInvalidIntValueThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid nullable integer");

        $data = [2021, 'invalid', 20, 30, 40];
        $this->factory->create($data);
    }

    public function testCreateWithMissingYearThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer");

        $data = [null, 10, 20, 30, 40];
        $this->factory->create($data);
    }
}
