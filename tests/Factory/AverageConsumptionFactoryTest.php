<?php

namespace App\Tests\Factory;

use App\Factory\AverageConsumptionFactory;
use App\Entity\AverageConsumption;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AverageConsumptionFactoryTest extends TestCase
{
    private AverageConsumptionFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new AverageConsumptionFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [
            2021,
            '100.5',
            '200.3',
            '300.7',
            '400.2'
        ];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(AverageConsumption::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(100.5, $entity->getSe1());
        $this->assertEquals(200.3, $entity->getSe2());
        $this->assertEquals(300.7, $entity->getSe3());
        $this->assertEquals(400.2, $entity->getSe4());
    }

    public function testCreateWithNullYearThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer:");

        $data = [null, '100.5', '200.3', '300.7', '400.2'];
        $this->factory->create($data);
    }

    public function testCreateWithInvalidFloatThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid float:");

        $data = [2021, 'invalid', '200.3', '300.7', '400.2'];
        $this->factory->create($data);
    }

    public function testEnsureFloatWithValidData(): void
    {
        $result = $this->factory->ensureFloat('100.5');
        $this->assertEquals(100.5, $result);
    }

    public function testEnsureFloatWithComma(): void
    {
        $result = $this->factory->ensureFloat('100,5');
        $this->assertEquals(100.5, $result);
    }

    public function testEnsureFloatWithInvalidDataThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid float:");

        $this->factory->ensureFloat('invalid');
    }

    public function testEnsureIntWithValidData(): void
    {
        $result = $this->factory->ensureInt(2021);
        $this->assertEquals(2021, $result);
    }

    public function testEnsureIntWithInvalidDataThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer:");

        $this->factory->ensureInt('invalid');
    }
}
