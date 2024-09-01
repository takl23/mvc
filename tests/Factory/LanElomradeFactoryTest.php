<?php

namespace App\Tests\Factory;

use App\Factory\LanElomradeFactory;
use App\Entity\LanElomrade;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LanElomradeFactoryTest extends TestCase
{
    private LanElomradeFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new LanElomradeFactory();
    }

    public function testCreateWithValidData(): void
    {
        $data = ['Stockholms län', 'SE3'];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(LanElomrade::class, $entity);
        $this->assertEquals('Stockholms län', $entity->getLan());
        $this->assertEquals('SE3', $entity->getElomrade());
    }

    public function testCreateWithNullValues(): void
    {
        $data = [null, 'SE3'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required data for \'lan\' or \'elomrade\'.');

        $this->factory->create($data);
    }

    public function testCreateWithEmptyStringValues(): void
    {
        $data = ['', ''];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required data for \'lan\' or \'elomrade\'.');

        $this->factory->create($data);
    }

    public function testCreateWithNumericValues(): void
    {
        $data = [123, 456];

        $entity = $this->factory->create($data);

        $this->assertInstanceOf(LanElomrade::class, $entity);
        $this->assertEquals('123', $entity->getLan());
        $this->assertEquals('456', $entity->getElomrade());
    }

    public function testCreateWithInvalidStringThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not a valid string');

        $data = [new \stdClass(), 'SE3'];
        $this->factory->create($data);
    }
}
