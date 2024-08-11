<?php

namespace App\Tests\Service;

use App\Service\ConsumptionPerCapitaService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class ConsumptionPerCapitaServiceTest extends TestCase
{
    private ConsumptionPerCapitaService $service;

    protected function setUp(): void
    {
        $this->service = new ConsumptionPerCapitaService($this->createMock(EntityManagerInterface::class));
    }

    public function testCalculateConsumptionPerCapita(): void
    {
        $result = $this->service->calculateConsumptionPerCapita(1000000.0, 50);
        $this->assertEquals(20000.0, $result);

        $result = $this->service->calculateConsumptionPerCapita(1000000.0, 0);
        $this->assertEquals(0.0, $result);
    }

    public function testConvertGWhToKWh(): void
    {
        $result = $this->service->convertGWhToKWh(1.0);
        $this->assertEquals(1000000.0, $result);
    }
}
