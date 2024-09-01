<?php

namespace App\Tests\Factory;

use App\Factory\PopulationPerLanFactory;
use App\Entity\PopulationPerLan;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PopulationPerLanFactoryTest extends TestCase
{
    private PopulationPerLanFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new PopulationPerLanFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = [
            2021,
            '1000000',
            '200000',
            '300000',
            '400000',
            '500000',
            '600000',
            '700000',
            '800000',
            '900000',
            '1000000',
            '1100000',
            '1200000',
            '1300000',
            '1400000',
            '1500000',
            '1600000',
            '1700000',
            '1800000',
            '1900000'
        ];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(PopulationPerLan::class, $entity);
        $this->assertEquals(2021, $entity->getYear());
        $this->assertEquals(1000000, $entity->getStockholm());
        $this->assertEquals(200000, $entity->getUppsala());
        // Fortsätt med de andra fälten...
    }

    public function testCreateWithNullYearThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("All values must be non-null and non-empty.");

        $data = [null, '1000000'];
        $this->factory->create($data);
    }

    public function testCreateWithNullPopulationValueThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("All values must be non-null and non-empty.");

        $data = [
            2021,
            null, // Null värde för Stockholm
            '200000',
            '300000'
        ];

        $this->factory->create($data);
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
