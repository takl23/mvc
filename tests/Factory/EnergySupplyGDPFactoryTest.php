<?php

namespace App\Tests\Factory;

use App\Factory\EnergySupplyGDPFactory;
use App\Entity\EnergySupplyGDP;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EnergySupplyGDPFactoryTest extends TestCase
{
    private EnergySupplyGDPFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new EnergySupplyGDPFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [2021, '3.5'];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(EnergySupplyGDP::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(3.5, $entity->getPrecentage());
    }

    public function testCreateWithNullYearThrowsException(): void
    {
        $data = [null, '3.5'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not a valid integer');

        $this->factory->create($data);
    }

    public function testCreateWithNullPercentageThrowsException(): void
    {
        $data = [2021, null];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not a valid float');

        $this->factory->create($data);
    }

    public function testCreateWithInvalidFloatThrowsException(): void
    {
        $data = [2021, 'invalid_float'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not a valid float');

        $this->factory->create($data);
    }

    public function testCreateWithInvalidIntThrowsException(): void
    {
        $data = ['invalid_int', '3.5'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not a valid integer');

        $this->factory->create($data);
    }

    public function testEnsureFloatWithComma(): void
    {
        $result = $this->factory->ensureFloat('3,5');
        $this->assertEquals(3.5, $result);
    }

    public function testEnsureIntWithValidData(): void
    {
        $result = $this->factory->ensureInt(2021);
        $this->assertEquals(2021, $result);
    }
}
