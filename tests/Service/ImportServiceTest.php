<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

class ImportServiceTest extends TestCase
{
    private ImportService $importService;

    protected function setUp(): void
    {
        $this->importService = new ImportService($this->createMock(EntityManagerInterface::class));
    }

    public function testEnsureInt(): void
    {
        $this->assertEquals(10, $this->importService->ensureInt(10));
        $this->assertEquals(0, $this->importService->ensureInt('0'));

        $this->expectException(InvalidArgumentException::class);
        $this->importService->ensureInt(null);
    }

    public function testEnsureFloat(): void
    {
        $this->assertEquals(10.5, $this->importService->ensureFloat(10.5));
        $this->assertEquals(10.5, $this->importService->ensureFloat('10.5'));

        $this->expectException(InvalidArgumentException::class);
        $this->importService->ensureFloat('invalid');
    }

    public function testEnsureString(): void
    {
        $this->assertEquals('test', $this->importService->ensureString('test'));
        $this->assertEquals('10', $this->importService->ensureString(10));

        $this->expectException(InvalidArgumentException::class);
        $this->importService->ensureString(null);
    }
}
