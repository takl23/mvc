<?php

namespace App\Tests\Factory;

use App\Factory\ElectricityPriceFactory;
use App\Entity\ElectricityPrice;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ElectricityPriceFactoryTest extends TestCase
{
    private ElectricityPriceFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ElectricityPriceFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [
            2021,
            '35.5',
            '36.0',
            '34.8',
            '33.9'
        ];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(ElectricityPrice::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(35.5, $entity->getSe1());
        $this->assertEquals(36.0, $entity->getSe2());
        $this->assertEquals(34.8, $entity->getSe3());
        $this->assertEquals(33.9, $entity->getSe4());
    }

    public function testCreateWithNullYearThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Year is missing, cannot create ElectricityPrice entity.");

        $data = [null, '35.5', '36.0', '34.8', '33.9'];
        $this->factory->create($data);
    }

    public function testCreateWithInvalidFloatThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid price data provided.");
    
        $data = [2021, 'invalid', '36.0', '34.8', '33.9'];
        $this->factory->create($data);
    }
    

    public function testCreateWithMissingValuesThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid price data provided.");

        $data = [2021, '35.5', null, '34.8', '33.9'];
        $this->factory->create($data);
    }

    public function testEnsureFloatWithValidData(): void
    {
        $result = $this->factory->ensureFloat('35.5');
        $this->assertEquals(35.5, $result);
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

    public function testCreateWithEmptyStringThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid price data provided.");

        $data = [2021, '', '', '', ''];
        $this->factory->create($data);
    }
}
