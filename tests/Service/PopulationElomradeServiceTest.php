<?php

namespace App\Tests\Service;

use App\Service\PopulationElomradeService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class PopulationElomradeServiceTest extends TestCase
{
    private PopulationElomradeService $service;

    protected function setUp(): void
    {
        $this->service = new PopulationElomradeService($this->createMock(EntityManagerInterface::class));
    }

    public function testConvertLanToProperty(): void
    {
        $this->assertEquals('norrbotten', $this->service->convertLanToProperty('Norrbottens län'));
        $this->assertEquals('vasterbotten', $this->service->convertLanToProperty('Västerbottens län'));
        $this->assertEquals('unknown', $this->service->convertLanToProperty('Okänt län')); // Testar unknown
    }
}
